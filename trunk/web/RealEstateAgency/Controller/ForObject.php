<?php

require_once 'RealEstateAgency/Const.php';
require_once 'RealEstateAgency/Util.php';

require_once 'RealEstateAgency/Object/RealEstateObject.php';
require_once 'RealEstateAgency/Object/SettlementList.php';

require_once 'RealEstateAgency/Object/SettlementPartList.php';

require_once 'RealEstateAgency/Object/Event.php';

require_once 'Zend/Validate.php';
require_once 'Zend/Validate/Int.php';

require_once 'RealEstateAgency/Controller/Base.php';

/**
 * 
object_id
price
r_e_type
rooms
rooms_type
settlement / list_of_settlements
location_text
city_district / list_of_city_districts
submit: filter_district
street
house_num
sq_all
sq_live
sq_kitchen
floor
floors
external
wc_num
bath_num
tel_type
description
submit: do_select
submit: just_save
 */
class RealEstateAgency_Controller_ForObject extends RealEstateAgency_Controller_Base
{
    
    private $object_action = '';
    private $location_id = NULL;
    private $location_text = NULL;
	private $operation_type = 0;
    private $action = '';
	private $do_not_save = false; // especially to test external client;
    
    public function execute() {
        
        $this->getInput();
        $view = $this->getGlobalData()->getView();
        $action = $this->action;
        // Show the list of settlements;
        
		$view->op_type = $this->operation_type;
		
        if ($action == 'firstpage') {
            $view->viewmode = 'firstpage';
            $list = new RealEstateAgency_Object_SettlementList();
            $list->setGlobalData($this->getGlobalData());
            $list->setAreaId(1);
            $list->loadBy();
            $view->list_of_links = $list->getArray();
        } else if ($action == 'secondpage') {
            
            $this->secondPage($view);
            //$view->settlement_name = $this->getSettlementName();
            
        } else if ($action == 'submit') {
            $view->viewmode = 'show';
            
            $obj = new RealEstateAgency_Object_RealEstateObject();
            $obj->setGlobalData($this->getGlobalData());
            $brokerID = $this->getGlobalData()->getLoginObject()->getLoggedUserID();
            
            $obj->setBrokerID($brokerID);
            
			//tools_log_debug($this->getGlobalData(),"validate reo",tools_get_input('op_type'));
			
            $obj->readWebForm();
            $obj->toWebForm($view);
            $validation = $obj->validate();
            if (count($validation) > 0) {
                $view->validation = $validation;
                $this->secondPage($view);
                //$view->settlement_name = $this->getSettlementName();
            } else {
                // Submit;
                $view->settlement_name = $this->getSettlementName();
                $time = tools_date2database(time());
                $obj->setDateOfStart($time);
                $obj->setDateOfUpdate($time);
				if (! $this->do_not_save) {
					$obj->insert();
				}
            }
        }

    }
    
    private function getSettlementName() {
        
        $location_id = $this->location_id;
        $location_text = $this->location_text;
        
        if ($location_id != NULL) {
            
            $object = RealEstateAgency_Object_Settlement::loadById($this->getGlobalData(), $location_id);
            return $object->getObjectName();
            
        } else {
            return $location_text;
        }
    }
    
    private function secondPage($view) {
        
        $view->viewmode = 'secondpage';
        if ($this->location_id != NULL) {
            $view->location_id = $this->location_id;
        }
        
        if ($this->location_text != NULL) {
            $view->location_text = $this->location_text;
        }
        
        if($this->location_id != NULL) {
            $list1 = new RealEstateAgency_Object_SettlementPartList();
            $list1->setGlobalData($this->getGlobalData());
            $list1->setSettlementId($this->location_id);
            $list1->loadBy();
            $list2 = $list1->getArray();
            $list3 = NULL; 
            if (count($list2)) {
                $list3 = array_merge( array(0 => array('id'=>0, 'name'=>'...')) , $list2 );
            }
            $view->list_of_city_districts = $list3;
        }
    }
    
    
    private function getInput() {
        $this->object_action = tools_get_input('object_action');
        
        $this->location_id = tools_get_input('location_id');
        $this->location_text = tools_get_input('location_text');
        
		$op_type = tools_get_input('op_type');
		if (1 == $op_type) {
			$op_type = 1;
		} else {
			$op_type = 0;
		}
		$this->operation_type = $op_type;
		
		if (tools_get_input('do_not_save')) {
			$this->do_not_save = true;
		}
		
        $this->action = 'secondpage';
        if ( ($this->location_id == NULL) && ($this->location_text == NULL) ) {
            $this->action = 'firstpage';
        }
        if (tools_is_button('just_save')) {
            $this->action = 'submit';
        }
        
    }
    
    
    
}

