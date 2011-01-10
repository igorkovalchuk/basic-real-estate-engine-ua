<?php

require_once 'RealEstateAgency/Const.php';
require_once 'RealEstateAgency/Util.php';

require_once 'RealEstateAgency/Object/RealEstateObject.php';
require_once 'RealEstateAgency/Object/SettlementList.php';

require_once 'RealEstateAgency/Object/SettlementPartList.php';

require_once 'Zend/Validate.php';
require_once 'Zend/Validate/Int.php';

require_once 'RealEstateAgency/Controller/Base.php';


class RealEstateAgency_Controller_ForUpdate extends RealEstateAgency_Controller_Base
{
    
    private $action = '';
	private $objectID = NULL;
	private $operation_type = 0;
	
	
    public function execute() {
        
		// 1 - just load and show;
		// 2 - after the submit, when incorrect: read from the form + loaded object, show;
		// 3 - after the submit, whem correct: read from the form + loaded object, submit;
		
        $this->getInput();
		$action = $this->action;
		$objectID = $this->objectID;
		
		$globalData = $this->getGlobalData();
		$view = $globalData->getView();
		
		$view->op_type = $this->operation_type;
		
		$object = RealEstateAgency_Object_RealEstateObject::loadById($globalData,$objectID);
		
		$view->location_details = $object->getLocationDetails();
		
		if ($action == 'showpage') {
			
			$view->viewmode = 'showpage';
			$this->getCityDistricts($view,$object);
			$object->toWebForm($view);
			
		} else if ($action == 'submit') {
			
			$write = $object->isEditable();
			
			if ($write) {
			
				$object->readWebFormForUpdate();
				$view->location_details = $object->getLocationDetails();
				$validation = $object->validate();
				
				if (count($validation) > 0) {
					// Show again;
					$view->validation = $validation;
					$view->viewmode = 'showpage';
					$this->getCityDistricts($view,$object);
					$object->toWebForm($view);
				} else {
					// Update this object; Show result page;
					$time = tools_date2database(time());
					$object->setDateOfUpdate($time);
					
					$object->update();
					
					$this->uploadFile($view,$object);
					$view->viewmode = 'resultpage';
				}
			
			}
			
		}
    }
    
	private function getCityDistricts($view, $object) {
		$locationID = $object->getSettlementID();
		if($locationID != NULL) {
			$list1 = new RealEstateAgency_Object_SettlementPartList();
			$list1->setGlobalData($this->getGlobalData());
			$list1->setSettlementId($locationID);
			$list1->loadBy();
			$list2 = $list1->getArray();
			$list3 = NULL;
			if (count($list2)) {
				$list3 = array_merge( array(0 => array('id'=>0, 'name'=>'...')) , $list2 );
			}
			$view->list_of_city_districts = $list3;
		}
	}
    
	private function uploadFile($view,$object) {
		
		// $object->getImagesList();
		
		if ($_FILES['userfile']['name'] == NULL) {
			return;
		}
		
		if ($_FILES['userfile']['size'] > RealEstateAgency_Const::MAX_FILE_SIZE) {
			// Protection, if MAX_FILE_SIZE was manually removed from the web page
			$view->upload_status = 'Не вдалося записати зображення. Розмір має бути менше '.RealEstateAgency_Const::MAX_FILE_SIZE;
			$view->upload_status_error = true;
			return;
		}
		
		if ($_FILES['userfile']['error'] == 1) {
			$view->upload_status = 'Не вдалося записати зображення. Вибачте, але сервер не дозволяє завантажувати файли такого об\'єму.';
			$view->upload_status_error = true;
			return;
		}
		
		if ($_FILES['userfile']['error'] == 2) {
			$view->upload_status = 'Не вдалося записати зображення. Розмір має бути менше '.RealEstateAgency_Const::MAX_FILE_SIZE;
			$view->upload_status_error = true;
			return;
		}
		
		if ($_FILES['userfile']['error'] == 3) {
			$view->upload_status = 'Не вдалося записати зображення. Файл було отримано тільки частково. ';
			$view->upload_status_error = true;
			return;
		}
		
		// foreach ($_FILES['userfile'] as $key => $value) {
			// $str_z = $key . ' = ' . $value . '<br />' . "\n";
			// echo "*(" . $str_z . ")*";
		// }

		$uploaddir = RealEstateAgency_Const::UPLOAD_IMAGES_DIR;
		$basename = basename($_FILES['userfile']['name']);
		
		$ext = strtolower( tools_get_ext($basename) );
		if (tools_is_allowable_ext($ext)) {
				// Ok!
		} else {
			$view->upload_status = 'Не вдалося записати зображення. Підтримуються лише файли типу: ' . tools_get_allowable_ext_string() . '.';
			$view->upload_status_error = true;
			return;
		}
		
		$basename = $object->getNewImageName();
		if ($basename == NULL) {
			$view->upload_status = 'Не вдалося записати зображення. Дозволяється не більше '.RealEstateAgency_Const::MAX_IMAGES.' зображень.';
			$view->upload_status_error = true;
			return;
		}
		
		$basename .= '.' . $ext;
		
		$uploadfile = $uploaddir . $basename;
		
		if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
			$view->upload_status = 'Зображення також збережено.';
		} else {
			$view->upload_status = 'Не вдалося записати зображення. Помилка: [' . $_FILES['userfile']['error'] . ']';
			$view->upload_status_error = true;
		}
	}
	
    private function getInput() {
        
        $this->action = 'showpage';
		$this->objectID = tools_get_input('object_id');
		
		$op_type = tools_get_input('op_type');
		if ($op_type == 1) {
			$op_type = 1;
		} else {
			$op_type = 0;
		}
		$this->operation_type = $op_type;
		
        if (tools_is_button('just_save')) {
            $this->action = 'submit';
        }
    }
	
}

