<?php

require_once 'RealEstateAgency/Object/Obj.php';

require_once 'RealEstateAgency/Const.php';
require_once 'RealEstateAgency/Util.php';

require_once 'RealEstateAgency/Database/Event/All.php';

require_once 'Zend/Validate.php';
require_once 'Zend/Validate/Int.php';

class RealEstateAgency_Object_Event extends RealEstateAgency_Object_Obj
{
    private $obj_id = NULL;
	private $log_date = NULL;
    private $log_name = '';
	private $log_string = '';
    private $log_status = 0;
	
    private $zend_row = NULL;
    
    function fillByArray($row) {
        $this->obj_id = $row['obj_id'];
		$this->log_date = $row['log_date'];
		$this->log_name = $row['log_name'];
		$this->log_string = $row['log_string'];
		$this->log_status = $row['log_status'];
    }
    
    function fillByZendRow($row) {
        $this->obj_id = $row->obj_id;
		$this->log_date = $row->log_date;
        $this->log_name = $row->log_name;
		$this->log_string = $row->log_string;
		$this->log_status = $row->log_status;
    }
    
    function toZendRow($row) {
        $row->obj_id = $this->obj_id;
		$row->log_date = $this->log_date;
        $row->log_name = $this->log_name;
		$row->log_string = $this->log_string;
		$row->log_status = $this->log_status;
    }
	
    public static function simpleLogging($globalData, $name, $message, $status) {
		$object = new RealEstateAgency_Object_Event();
		$object->setGlobalData($globalData);
		$time = time();
		$object->log_date = tools_date2database($time);
		$object->log_name = $name;
		$object->log_string = $message;
		$object->log_status = $status;
        $db = $object->getGlobalData()->takeConnection();
        $table = new RealEstateAgency_Database_Event_Table( array( 'db' => $db ) );
        $row = $table->createRow();
        $object->toZendRow($row);
        $row->save();
        return RealEstateAgency_Const::OK;
    }
    
	public static function getNumberOfErrorsByTime($globalData, $time) {
		$db = $globalData->takeConnection();
        $select = $db->select();
        $select->from('events_list');
		$select->where('log_status = ?', RealEstateAgency_Const::LOG_ERROR);
		$date = tools_date2database($time);
		$select->where('log_date >= ?', $date);
		
		$stmt = $db->query($select);
        $result = $stmt->fetchAll();
        
        //echo '<pre>';
        //var_dump($result);
        //echo '</pre>';
        
        return count($result);
	}
	
}

function tools_log_error($globalData, $name, $message) {
	return RealEstateAgency_Object_Event::simpleLogging($globalData, $name, $message, RealEstateAgency_Const::LOG_ERROR);
}

function tools_log_warn($globalData, $name, $message) {
	return RealEstateAgency_Object_Event::simpleLogging($globalData, $name, $message, RealEstateAgency_Const::LOG_WARN);
}

function tools_log_debug($globalData, $name, $message) {
	return RealEstateAgency_Object_Event::simpleLogging($globalData, $name, $message, RealEstateAgency_Const::LOG_DEBUG);
}

function tools_log_get_number_of_errors_by_time($globalData, $time) {
	return RealEstateAgency_Object_Event::getNumberOfErrorsByTime($globalData, $time);
}

