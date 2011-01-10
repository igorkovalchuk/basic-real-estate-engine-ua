<?php

require_once 'RealEstateAgency/Object/Obj.php';

require_once 'RealEstateAgency/Const.php';
require_once 'RealEstateAgency/Util.php';

require_once 'RealEstateAgency/Object/Event.php';

require_once 'RealEstateAgency/Database/Object/All.php';

require_once 'Zend/Validate.php';
require_once 'Zend/Validate/Int.php';

class RealEstateAgency_Object_RealEstateObject extends RealEstateAgency_Object_Obj
{
    
    private $obj_id = NULL;
    private $broker_id = 0;
    
	private $op_type = 0; // version 1.5
	
    private $started = NULL;
    private $updated = NULL;
    
    private $price = 0;
    
    private $type = NULL;
    private $rooms = NULL;
    private $rooms_type = 0;
    
    private $settlement_id = 0;
    private $location_text = "";
    private $settl_area_id = 0;
	private $settl_sub_part_name = ""; // version 1.4
    private $street_text = "";
    private $house_num = "";
    
    private $sq_all = 0;
    private $sq_live = 0;
    private $sq_kitchen = 0;
	private $sq_land = 0;
    
    private $obj_level = 0;
    private $obj_levels = 0;
    
    private $external = NULL;
    private $wc_num = NULL;
    private $bath_num = NULL;
    private $tel = NULL;
    
    private $description = "";
    
    private $rent_period = ""; // version 1.5
    
    private $area_name = NULL;
    private $district_name = NULL;
    private $settlement_name = NULL;
    private $settlement_part_name = NULL;
    
    
    private $zend_row = NULL;
    
    public function toString() {
        $str = 'RealEstateAgency_Object_RealEstateObject: ';
        $str .= 'obj_id=' . $this->obj_id . '; ';
        return $str;
    }
    
    function completeFillByArray($row) {
        $this->fillByArray($row);
    }
    
    function fillByArray($row) {
        $this->obj_id = $row['obj_id'];
		$this->op_type = $row['op_type']; // version 1.5
        $this->broker_id = $row['broker_id'];
        $this->started = $row['started'];
        $this->updated = $row['updated'];
        $this->price = $row['price'];
        $this->type = $row['type'];
        $this->rooms = $row['rooms'];
        $this->rooms_type = $row['rooms_type'];
        $this->settlement_id = $row['settlement_id'];
        $this->location_text = $row['location_text'];
        $this->settl_area_id = $row['settl_area_id'];
		$this->settl_sub_part_name = $row['settl_sub_part_name']; // version 1.4
        $this->street_text = $row['street_text'];
        $this->house_num = $row['house_num'];
        $this->sq_all = $row['sq_all'];
        $this->sq_live = $row['sq_live'];
        $this->sq_kitchen = $row['sq_kitchen'];
		$this->sq_land = $row['sq_land']; // version 1.6
        $this->obj_level = $row['obj_level'];
        $this->obj_levels = $row['obj_levels'];
        $this->external = $row['external'];
        $this->wc_num = $row['wc_num'];
        $this->bath_num = $row['bath_num'];
        $this->tel = $row['tel'];
        $this->description = $row['description'];
        $this->rent_period = $row['rent_period']; // version 1.5
		
        $this->area_name = $row['area_name'];
        $this->district_name = $row['district_name'];
        $this->settlement_name = $row['settlement_name'];
        $this->settlement_part_name = $row['settlement_part_name'];
        
    }
    
    function fillByZendRow($row) {
        $this->obj_id = $row->obj_id;
		$this->op_type = $row->op_type; // version 1.5
        $this->broker_id = $row->broker_id;
        $this->started = $row->started;
        $this->updated = $row->updated;
        $this->price = $row->price;
        $this->type = $row->type;
        $this->rooms = $row->rooms;
        $this->rooms_type = $row->rooms_type;
        $this->settlement_id = $row->settlement_id;
        $this->location_text = $row->location_text;
        $this->settl_area_id = $row->settl_area_id;
		$this->settl_sub_part_name = $row->settl_sub_part_name; // version 1.4
        $this->street_text = $row->street_text;
        $this->house_num = $row->house_num;
        $this->sq_all = $row->sq_all;
        $this->sq_live = $row->sq_live;
        $this->sq_kitchen = $row->sq_kitchen;
		$this->sq_land = $row->sq_land; // version 1.6
        $this->obj_level = $row->obj_level;
        $this->obj_levels = $row->obj_levels;
        $this->external = $row->external;
        $this->wc_num = $row->wc_num;
        $this->bath_num = $row->bath_num;
        $this->tel = $row->tel;
        $this->description = $row->description;
		$this->rent_period = $row->rent_period; // version 1.5

        $this->zend_row = $row;
    }
    
    function toZendRow($row) {
        $row->obj_id = $this->obj_id;
		$row->op_type = $this->op_type; // version 1.5
        $row->broker_id = $this->broker_id;
        $row->started = $this->started;
        $row->updated = $this->updated;
        $row->price = $this->price;
        $row->type = $this->type;
        $row->rooms = $this->rooms;
        $row->rooms_type = $this->rooms_type;
        $row->settlement_id = $this->settlement_id;
        $row->location_text = $this->location_text;
        $row->settl_area_id = $this->settl_area_id;
		$row->settl_sub_part_name = $this->settl_sub_part_name; // version 1.4
        $row->street_text = $this->street_text;
        $row->house_num = $this->house_num;
        $row->sq_all = $this->sq_all;
        $row->sq_live = $this->sq_live;
        $row->sq_kitchen = $this->sq_kitchen;
		$row->sq_land = $this->sq_land; // version 1.6
        $row->obj_level = $this->obj_level;
        $row->obj_levels = $this->obj_levels;
        $row->external = $this->external;
        $row->wc_num = $this->wc_num;
        $row->bath_num = $this->bath_num;
        $row->tel = $this->tel;
        $row->description = $this->description;
		$row->rent_period = $this->rent_period; // version 1.5
    }
    
    /**
     * Constructor;
     * Load object without additional details;    
     */
    private function loadById_pure($globalData, $object_id) {
        if (! tools_verify_int($object_id)) {
            return NULL;   
        }
        $db = $globalData->takeConnection();
        $table = new RealEstateAgency_Database_Object_Table( array( 'db' => $db ) );
        $where = $db->quoteInto('obj_id = ?', $object_id);
        $rowset = $table->fetchAll($where);
        $row = $rowset->current();
        if ($row) {
            $new_object = new RealEstateAgency_Object_RealEstateObject();
            $new_object->setGlobalData($globalData);
            $new_object->fillByZendRow($row);
            return $new_object;
        } else {
            return NULL;
        }
    }
    
    public static function loadById($globalData, $object_id) {
        if (! tools_verify_int($object_id)) {
            return NULL;   
        }
        $db = $globalData->takeConnection();
        $select = $db->select();
        $select->from('r_e_object');
        
		
		$select->joinLeft(
            'settlement',
            'r_e_object.settlement_id=settlement.obj_id',
            array('settlement_name' => 'obj_name')
        );
        
        $select->joinLeft(
            'settlement_part',
            'r_e_object.settl_area_id=settlement_part.obj_id',
            array('settlement_part_name' => 'obj_name')
        );
        
        $select->joinLeft(
            'district',
            'settlement.district=district.obj_id',
            array('district_name' => 'obj_name')
        );
        
        $select->joinLeft(
            'area',
            'district.area=area.obj_id',
            array('area_name' => 'obj_name')
        );
        
        $where = $db->quoteInto('r_e_object.obj_id = ?', $object_id);
        $select->where($where);
        $stmt = $db->query($select);
        $result = $stmt->fetchAll();
        $row = current($result);
        if ($row) {
            $new_object = new RealEstateAgency_Object_RealEstateObject();
            $new_object->setGlobalData($globalData);
            $new_object->completeFillByArray($row);
            return $new_object;
        } else {
            return NULL;
        }
    }
    
    
    public function delete() {
        $zend_row = $this->zend_row;
        if ($zend_row) {
            $zend_row->delete();
        } else {
            throw new Exception('Delete object. Not initialized database object !');
        }
    }
    
    public static function deleteById($globalData, $object_id) {
        $object = RealEstateAgency_Object_RealEstateObject::loadById_pure($globalData, $object_id);
        if ($object) {
            $object->delete();
        }
    }
    
    // input data
    public function insert() {
        $object_id = $this->obj_id;
        $db = $this->getGlobalData()->takeConnection();
        $table = new RealEstateAgency_Database_Object_Table( array( 'db' => $db ) );
        $row = $table->createRow();
        $this->toZendRow($row);
        $row->save();
        $this->obj_id = $row->obj_id;
        return RealEstateAgency_Const::OK;
    }
    
    public function update() {
        $previous_object =  RealEstateAgency_Object_RealEstateObject::loadById_pure($this->getGlobalData(), $this->obj_id);
        if ($previous_object) {
            $row = $previous_object->zend_row;
            $this->toZendRow($row);
            $row->save();
        }
    }
    
    public function getObjectID() {
        return $this->obj_id;
    }

    public function setObjectID($value) {
        $this->obj_id = $value;
    }

    public function getOperationType() {
        return $this->op_type;
    }

    public function setOperationType($value) {
        $this->op_type = $value;
    }

    public function getBrokerID() {
        return $this->broker_id;
    }

    public function setBrokerID($value) {
        $this->broker_id = $value;
    }

    public function getDateOfStart() {
        return $this->started;
    }

    public function setDateOfStart($value) {
        $this->started = $value;
    }

    public function getDateOfUpdate() {
        return $this->updated;
    }

    public function setDateOfUpdate($value) {
        $this->updated = $value;
    }

    public function getPrice() {
        return $this->price;
    }

    public function setPrice($value) {
        $value = str_replace(',', '.', $value);
        $this->price = $value;
    }

    public function getObjectType() {
        return $this->type;
    }

    public function setObjectType($value) {
        $this->type = $value;
    }

    public function getRooms() {
        return $this->rooms;
    }

    public function setRooms($value) {
        $this->rooms = $value;
    }

    public function getRoomsType() {
        return $this->rooms_type;
    }

    public function setRoomsType($value) {
        $this->rooms_type = $value;
    }

    public function getSettlementID() {
        return $this->settlement_id;
    }

    public function setSettlementID($value) {
        $this->settlement_id = $value;
    }

    public function getLocationText() {
        return $this->location_text;
    }

    public function setLocationText($value) {
        $this->location_text = $value;   
    }

    public function getSettlementAreaID() {
        return $this->settl_area_id;
    }

    public function setSettlementAreaID($value) {
        $this->settl_area_id = $value;
    }

	public function getSettlementSubPartName() {
		return $this->settl_sub_part_name;
	}

	public function setSettlementSubPartName($value) {
		$this->settl_sub_part_name = $value;
	}

    public function getStreet() {
        return $this->street_text;
    }

    public function setStreet($value) {
        $this->street_text = $value;
    }

    public function getHouseNumber() {
        return $this->house_num;
    }

    public function setHouseNumber($value) {
        $this->house_num = $value;
    }

    public function getSquareAll() {
        return $this->sq_all;
    }

    public function setSquareAll($value) {
        $value = str_replace(',', '.', $value);
        $this->sq_all = $value;
    }

    public function getSquareLive() {
        return $this->sq_live;
    }

    public function setSquareLive($value) {
        $value = str_replace(',', '.', $value);
        $this->sq_live = $value;
    }

    public function getSquareKitchen() {
        return $this->sq_kitchen;
    }

    public function setSquareKitchen($value) {
        $value = str_replace(',', '.', $value);
        $this->sq_kitchen = $value;
    }

    public function getSquareLand() {
        return $this->sq_land;
    }

    public function setSquareLand($value) {
        $value = str_replace(',', '.', $value);
        $this->sq_land = $value;
    }

    public function getFloor() {
        return $this->obj_level;
    }

    public function setFloor($value) {
        $this->obj_level = $value;
    }

    public function getFloors() {
        return $this->obj_levels;
    }

    public function setFloors($value) {
        $this->obj_levels = $value;
    }

    public function getExternal() {
        return $this->external;
    }

    public function setExternal($value) {
        $this->external = $value;
    }

    public function getWcNumber() {
        return $this->wc_num;
    }

    public function setWcNumber($value) {
        $this->wc_num = $value;
    }

    public function getBathNumber() {
        return $this->bath_num;
    }

    public function setBathNumber($value) {
        $this->bath_num = $value;
    }

    public function getTelType() {
        return $this->tel;
    }

    public function setTelType($value) {
        $this->tel = $value;
    }
    
    public function getDescription() {
        return $this->description;   
    }
    
    public function setDescription($value) {
        $this->description = $value;
    }
	
    public function getRentPeriod() {
        return $this->rent_period;   
    }
    
    public function setRentPeriod($value) {
        $this->rent_period = $value;
    }
	
    public function getAreaName() {
        return $this->area_name;
    }
    
    public function getDistrictName() {
        return $this->district_name;
    }
    
    public function getSettlementName() {
        return $this->settlement_name;
    }

    public function getSettlementPartName() {
        return $this->settlement_part_name;
    }

    // Editable for it's owner and for the main administrator.
    public function isEditable() {
        $brokerID = $this->getGlobalData()->getLoginObject()->getLoggedUserID();
		
		if ( ($brokerID != NULL) && ($brokerID != 0) ) {
            if ($brokerID == $this->getBrokerID() ) {
                return true;
            }
            if ($brokerID == 1) {
                return true;
            }
        }
        return false;
    }

    /**
     * Before show, create, update, delete;
     */
    public function verifyState($mode) {
        throw new Exception('Please implement this function: verifyState() for R.E.Object.');
    }

    /**
     * Read data from the web page;
     */
    public function readWebForm() {
        
        $this->setObjectID( tools_get_input('object_id') );
		
		$this->setOperationType( tools_get_input('op_type') ); // version 1.5
		
        $this->setPrice( tools_get_input('price') );
        $this->setObjectType( tools_get_input('r_e_type') );
        
        $this->setRooms( tools_get_input('rooms') );
        $this->setRoomsType( tools_get_input('rooms_type') );
        
        $this->setSettlementID( tools_get_input('location_id') );
        $this->setLocationText( tools_get_input('location_text') );
        
        $this->setSettlementAreaID( tools_get_input('city_district') );
		
		$this->setSettlementSubPartName( tools_get_input('city_sub_district') ); // version 1.4
        
        $this->setStreet( tools_get_input('street') );
        $this->setHouseNumber( tools_get_input('house_num') );
        $this->setSquareAll( tools_get_input('sq_all') );
        $this->setSquareLive( tools_get_input('sq_live') );
        $this->setSquareKitchen( tools_get_input('sq_kitchen') );
		$this->setSquareLand( tools_get_input('sq_land') );
        $this->setFloor( tools_get_input('floor') );
        $this->setFloors( tools_get_input('floors') );
        $this->setExternal( tools_get_input('external') );
        $this->setWcNumber( tools_get_input('wc_num') );
        $this->setBathNumber( tools_get_input('bath_num') );
        $this->setTelType( tools_get_input('tel_type') ); 
        $this->setDescription( tools_get_input('description') );
		$this->setRentPeriod( tools_get_input('rent_period') ); // version 1.5
        // throw new Exception('Please implement this function: readWebForm() for R.E.Object.');
    }
    
	/**
	 * Read data from the web page;
	 */
    public function readWebFormForUpdate() {
        
		$this->setObjectType( tools_get_input('r_e_type') );
		
        $this->setPrice( tools_get_input('price') );
        
        $this->setRooms( tools_get_input('rooms') );
        $this->setRoomsType( tools_get_input('rooms_type') );
        
        $this->setSettlementAreaID( tools_get_input('city_district') );
        
		$this->setSettlementSubPartName( tools_get_input('city_sub_district') ); // version 1.4
		
        $this->setStreet( tools_get_input('street') );
        $this->setHouseNumber( tools_get_input('house_num') );
        
		$this->setSquareAll( tools_get_input('sq_all') );
        $this->setSquareLive( tools_get_input('sq_live') );
        $this->setSquareKitchen( tools_get_input('sq_kitchen') );
		$this->setSquareLand( tools_get_input('sq_land') );
        
		$this->setFloor( tools_get_input('floor') );
        $this->setFloors( tools_get_input('floors') );
        
		$this->setDescription( tools_get_input('description') );
		$this->setRentPeriod( tools_get_input('rent_period') ); // version 1.5
    }
	
    public function validate() {
        $result = array();
        
        $price = $this->getPrice();
        if ( (!tools_verify_float($price)) || ($price < 0)) {
            $result['price'] = 'позитивне число, наприклад 100000.5 або 0';
        }
		
		$operationType = $this->getOperationType(); // version 1.5
		
		// tools_log_debug($this->getGlobalData(),"validate reo1",$operationType);
		
		if ($operationType == NULL) {
			$operationType = 0;
		} else if ($operationType == 1) {
			$operationType = 1;
		} else {
			$operationType = 0;
		}
		
		// tools_log_debug($this->getGlobalData(),"validate reo2",$operationType);
		
		$this->setOperationType($operationType);
		
        $objectType = $this->getObjectType();
        if ( (!tools_verify_int($objectType)) || ($objectType < 1) || ($objectType > 6) ) {
            $result['r_e_type'] = 'виберіть зі списку';
        }
        
        $rooms = $this->getRooms();
		$allowNoRooms = false;
		if (
			(RealEstateAgency_Const::TYPE_FLAT_NUMBER != $objectType) &&
			(RealEstateAgency_Const::TYPE_ROOM_NUMBER != $objectType)
		) {
			$allowNoRooms = true;
		}
		
		if ($allowNoRooms) {
			$this->setRooms(0);
			//if ( (!tools_verify_int($rooms)) || ($rooms != 0) ) {
				//$result['rooms'] = 'мусить бути нуль';
			//}
		} else {
			if ( (!tools_verify_int($rooms)) || ($rooms <= 0) || ($rooms > 999) ) {
				$result['rooms'] = 'число, від 1 до 999';
			}
		}
        
		$roomsType = $this->getRoomsType();
        if ( (!tools_verify_int($roomsType)) || ($roomsType < 0) || ($roomsType > 3) ) {
            $result['rooms_type'] = 'виберіть зі списку';
        }
        
        $settlementID = $this->getSettlementID();
        $locationText = $this->getLocationText();
        
        if ( ($settlementID == NULL) && ($locationText == NULL) ) {
            $result['generally'] = "Не вказано місцезнаходження об'єкту.";
        }
        
        if ($settlementID != NULL) {
            if ( (!tools_verify_int($settlementID)) || ($settlementID < 1) ) {
                $result['generally'] = "Не вказано місцезнаходження об'єкту.";
            }
        }
        
        $settlementAreaID = $this->getSettlementAreaID();
        if ($settlementAreaID != NULL) {
            if ( (!tools_verify_int($settlementAreaID)) || ($settlementAreaID < 1) ) {
                $result['city_district'] = "виберіть зі списку";
            }
        }
        
		$settlementSubPartName = $this->getSettlementSubPartName();
		if ($settlementSubPartName != NULL) {
			if (strlen($settlementSubPartName) > 64) {
				$result['city_sub_district'] = 'не більше 64 знаків';
			}
		}
		
        $streetText = $this->getStreet();
        if ($streetText == NULL) {
            $result['street'] = 'назва вулиці';
        }
        
        $houseNum = $this->getHouseNumber();
        if ( ($houseNum != NULL) && (strlen($houseNum) > 10) ) {
            $result['house_num'] = 'не більше 10 знаків';
        }
        
        $sqAll = $this->getSquareAll();
        $sqLive = $this->getSquareLive();
        $sqKitchen = $this->getSquareKitchen();
		$sqLand = $this->getSquareLand();
        
        if ( (!tools_verify_float($sqAll)) || ($sqAll < 0) ) {
            $result['sq_all'] = 'позитивне число або нуль';
        }
        
        if ( (!tools_verify_float($sqLive)) || ($sqLive < 0) ) {
            $result['sq_live'] = 'позитивне число або нуль';
        }
        
        if ( (!tools_verify_float($sqKitchen)) || ($sqKitchen < 0) ) {
            $result['sq_kitchen'] = 'позитивне число або нуль';
        }
        
		if ( ($sqLand != NULL) && ( (!tools_verify_float($sqLand)) || ($sqLand < 0) ) ) {
            $result['sq_land'] = 'позитивне число, нуль або пробіл';
        }

		if ($sqLand == NULL) {
			# SQLSTATE[01000]: Warning: 1265 Data truncated for column 'sq_land' at row 1
			$sqLand = "0";
			$this->setSquareLand($sqLand);
		}

        $floor = $this->getFloor();
        $floors = $this->getFloors();

		if ( ($floor != NULL) && ( (!tools_verify_int($floor)) || ($floor < 0) ) ) {
            $result['floor'] = 'має бути позитивне число, нуль або пробіл';
        }

        if ( ($floors != NULL) && ( (!tools_verify_int($floors)) || ($floors < 0) ) ) {
            $result['floors'] = 'має бути позитивне число, нуль або пробіл';
        }

        $wcNum = $this->getWcNumber();
        if ( ($wcNum != NULL) && ( (!tools_verify_int($wcNum)) || ($wcNum < 0) ) ) {
            $result['wc_num'] = 'має бути позитивне число, нуль або пробіл';
        }
        
        $bathNum = $this->getBathNumber();
        if ( ($bathNum != NULL) && ( (!tools_verify_int($bathNum)) || ($bathNum < 0) ) ) {
            $result['bath_num'] = 'має бути позитивне число, нуль або пробіл';
        }
        
        $external = $this->getExternal();
        if ( ($external != NULL) && ( (!tools_verify_int($external)) || ($external < 0) ) ) {
            $result['external'] = 'має бути позитивне число, нуль або пробіл';
        }
        
        $telType = $this->getTelType();
        if ( (!tools_verify_int($telType)) || ($telType < 0) || ($telType > 4) ) {
            $result['tel_type'] = 'виберіть зі списку';
        }
        
        $description = $this->getDescription();
        if ( ($description != NULL) && (strlen($description) > 100) ) {
            $result['description'] = 'не більше 100 знаків';
        }
        
		$rentPeriod = $this->getRentPeriod(); // version 1.5
		if ( ($rentPeriod != NULL) && (strlen($rentPeriod) > 10) ) {
			$result['rent_period'] = 'не більше 10 знаків';
		}
		
        return $result;
    }
        
    /**
     * $view - there is Zend View object;
     */
    public function toWebForm($view) {
        $view->object_id = $this->getObjectID();
        // $view->user_id
		$view->op_type = $this->getOperationType(); // version 1.5
        $view->price = $this->getPrice();
        $view->r_e_type = $this->getObjectType();
        $view->rooms = $this->getRooms();
        $view->rooms_type = $this->getRoomsType();
        
        $view->location_id = $this->getSettlementID();
        $view->location_text = $this->getLocationText();
        
        $view->city_district = $this->getSettlementAreaID();
		
		$view->city_sub_district = $this->getSettlementSubPartName(); // version 1.4
		
        $view->street = $this->getStreet();
        $view->house_num = $this->getHouseNumber();
        $view->sq_all = $this->getSquareAll();
        $view->sq_live = $this->getSquareLive();
        $view->sq_kitchen = $this->getSquareKitchen();
        $view->floor = $this->getFloor();
        $view->floors = $this->getFloors();
        $view->external = $this->getExternal();
        $view->wc_num = $this->getWcNumber();
        $view->bath_num = $this->getBathNumber();
        $view->tel_type = $this->getTelType();
        $view->description = $this->getDescription();
		$view->rent_period = $this->getRentPeriod(); // version 1.5
    }
    
	public function getLocationDetails() {
		
		$location_text = $this->getLocationText();
		$area_name = $this->getAreaName();
		$district_name = $this->getDistrictName();
		$settlement_name = $this->getSettlementName();
		$settlement_part_name = $this->getSettlementPartName();
		$settlement_sub_part_name = $this->getSettlementSubPartName();
		
		$result = '';
		
		if ($area_name != NULL) {
			$result .= 'Область: ' . $area_name;
		}
		
		if ($district_name != NULL) {
			if ($district_name != '...') {
				if ($result != '') {
					$result .= '<br />';
				}
				$result .= 'Район: ' . $district_name;
			}
		}
		
		// version 1.4
		if ($settlement_sub_part_name != NULL) {
			if ($result != '') {
				$result .= '<br />';
			}
			$result .= 'Масив: ' . $settlement_sub_part_name;
		}
		
		if ($settlement_name != NULL) {
			if ($result != '') {
				$result .= '<br />';
			}
			$result .= 'Населений пункт: ' . $settlement_name;
		} else if ($location_text != NULL) {
			if ($result != '') {
				$result .= '<br />';
			}
			$result .= 'Населений пункт: ' . $location_text;
		}
		
		return $result;
	}
	
    public function test() {
        
        require_once 'RealEstateAgency/GlobalData.php';
        $globalData = new RealEstateAgency_GlobalData();
        
        $object = new RealEstateAgency_Object_RealEstateObject();
        $object->setGlobalData($globalData);
        $object->setObjectID(NULL);
        $object->setBrokerID(1);
        $object->setDateOfStart( tools_date2database(time()) );
        $object->setDateOfUpdate(NULL);
        $object->setPrice(10000);
        $object->setObjectType(3);
        $object->setRooms(5);
        $object->setRoomsType(1);
        $object->setSettlementID(1);
        $object->setLocationText("Альтернативне місцезнаходження");
        $object->setSettlementAreaID(1);
        $object->setStreet("Оболонський просп.");
        $object->setHouseNumber('15a');
        $object->setSquareAll(100.5);
        $object->setSquareLive(90.5);
        $object->setSquareKitchen(10.5);
        $object->setFloor(1);
        $object->setFloors(16);
        $object->setExternal(1);
        $object->setWcNumber(1);
        $object->setBathNumber(2);
        $object->setTelType(1);
        $object->setDescription("Якийсь додатковий опис.");
        $object->insert();
        $obj_id = $object->getObjectID();
        
        sleep(3);

        $object2 = $this->loadById($globalData, $obj_id);
        $object2->setPrice(20000);
        $update_time = time();
        $object2->setDateOfUpdate( tools_date2database($update_time) );
        $object2->update();
        
        $object3 = $this->loadById($globalData, $obj_id);
        if ($object3->getPrice() != 20000) {
            throw new Exception('Incorrect value - price, after update.');
        }
        if ( tools_database2date( $object3->getDateOfUpdate() ) != $update_time ) {
            throw new Exception('Incorrect value - time, after update.');
        }
        RealEstateAgency_Object_RealEstateObject::deleteById($globalData, $obj_id);
    }
    
	/**
	 * Returns new image name (full path) or NULL;
	 */
	public function getNewImageName() {
		// clearstatcache();
		$dir = RealEstateAgency_Const::UPLOAD_IMAGES_DIR;
		$filename1 = 'file_' . $this->getObjectID() . '_';
		$filename2 = $dir . $filename1;
		$filename3 = '';
		$i = 1;
		while ($i <= RealEstateAgency_Const::MAX_IMAGES) {
			$filename3 = $filename2 . $i . '.*';
			if ( ! file_exists($filename3)) {
				return $filename1 . $i;
			}
			$i++;
		}
		return NULL;
	}
	
	/**
	 * Returns the list of names of images or NULL;
	 */
	public function getImagesList() {
		// clearstatcache();
		$object_id = $this->getObjectID();
		$result = RealEstateAgency_Object_RealEstateObject::getImagesListStatic($object_id);
		return $result;
	}
	
	public static function getImagesListStatic($object_id) {
		if ( ($object_id == NULL) || ($object_id == '') ) {
			return NULL;
		}
		$result = array();
		$dir = RealEstateAgency_Const::UPLOAD_IMAGES_DIR;
		$filename_example = $dir . 'file_' . $object_id . '_*.*';

		foreach (glob($filename_example) as $filename) {
			$result[] = basename($filename);
		}

		if (count($result) > 0) {
			return $result;
		} else {
			return NULL;
		}

	}
	
	public function isAnyImage() {
		$result = $this->getImagesList();
		if ($result != NULL) {
			return true;
		}
		return false;
	}
	
}

if (false) {
    print "Test: RealEstateAgency_Object_RealEstateObject\n";
    $object = new RealEstateAgency_Object_RealEstateObject();
    $object->test();
}


