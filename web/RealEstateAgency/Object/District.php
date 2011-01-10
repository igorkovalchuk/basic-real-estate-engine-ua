<?php

require_once 'RealEstateAgency/Object/Obj.php';

require_once 'RealEstateAgency/Const.php';

require_once 'RealEstateAgency/Database/District/All.php';

require_once 'Zend/Validate.php';
require_once 'Zend/Validate/Int.php';

class RealEstateAgency_Object_District extends RealEstateAgency_Object_Obj
{
    private $obj_id = NULL;
    private $obj_name = '';
    private $area_id = NULL; // in the database: area
    
    private $area_name = '?';
    
    private $zend_row = NULL;
    
    public function toString() {
        $str = 'RealEstateAgency_Object_District: ';
        $str .= 'obj_id=' . $this->obj_id . '; ';
        $str .= 'obj_name=' . $this->obj_name . '; ';
        $str .= 'area_id=' . $this->area_id . '; ';
        return $str;
    }
    
    function completeFillByArray($row) {
        $this->fillByArray($row);
        if ( isset($row['area_name']) ) {
            $this->area_name = $row['area_name'];
        }
        
    }
    
    function fillByArray($row) {
        $this->obj_id = $row['obj_id'];
        $this->obj_name = $row['obj_name'];
        $this->area_id = $row['area'];
    }
    
    function fillByZendRow($row) {
        $this->obj_id = $row->obj_id;
        $this->obj_name = $row->obj_name;
        $this->area_id = $row->area;
        $this->zend_row = $row;
    }
    
    function toZendRow($row) {
        $row->obj_id = $this->obj_id;
        $row->obj_name = $this->obj_name;
        $row->area = $this->area_id;
    }
    
    /*
    Constructor;
    */
    public function loadById($globalData, $object_id) {
        $validatorChain = new Zend_Validate();
        $validatorChain->addValidator( new Zend_Validate_Int() );
        if ( ! $validatorChain->isValid($object_id) ) {
            return NULL;
        }
        $db = $globalData->takeConnection();
        $table = new RealEstateAgency_Database_District_Table( array( 'db' => $db ) );
        $where = $db->quoteInto('obj_id = ?', $object_id);
        $rowset = $table->fetchAll($where);
        $row = $rowset->current();
        if ($row) {
            $new_object = new RealEstateAgency_Object_District();
            $new_object->setGlobalData($globalData);
            $new_object->fillByZendRow($row);
            return $new_object;
        } else {
            return NULL;
        }
    }
    
    /*
    Constructor;
    */
    public static function loadByName($globalData, $object_name) {
        if ( ($object_name == NULL) || ($object_name == '') ) {
            return NULL;
        }
        $db = $globalData->takeConnection();
        $table = new RealEstateAgency_Database_District_Table( array( 'db' => $db ) );
        $where = $db->quoteInto('obj_name = ?', $object_name);
        // RealEstateAgency_Util::printTestString('WHERE: ['.$where.']'); // test string;
        $rowset = $table->fetchAll($where);
        $row = $rowset->current();
        if ($row) {
            $new_object = new RealEstateAgency_Object_District();
            $new_object->setGlobalData($globalData);
            $new_object->fillByZendRow($row);
            return $new_object;
        } else {
            return NULL;
        }
    }
    
        /*
    Constructor;
    */
    public static function loadByNameAndAreaId($globalData, $object_name, $area_id) {
        if ( ($object_name == NULL) || ($object_name == '') ) {
            return NULL;
        }
        $validatorChain = new Zend_Validate();
        $validatorChain->addValidator( new Zend_Validate_Int() );
        if ( ! $validatorChain->isValid($area_id) ) {
            return NULL;
        }
        
        $db = $globalData->takeConnection();
        $table = new RealEstateAgency_Database_District_Table( array( 'db' => $db ) );
        
        $where   = array(
            $db->quoteInto('obj_name = ?', $object_name),
            $db->quoteInto('area = ?', $area_id)
        );
        // RealEstateAgency_Util::printTestString('WHERE: ['.$where.']'); // test string;
        $rowset = $table->fetchAll($where);
        $row = $rowset->current();
        if ($row) {
            $new_object = new RealEstateAgency_Object_District();
            $new_object->setGlobalData($globalData);
            $new_object->fillByZendRow($row);
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
        $object = RealEstateAgency_Object_District::loadById($globalData, $object_id);
        if ($object) {
            $object->delete();
        }
    }
    
    // input data: object name, area id
    public function insert() {
        $object_name = $this->obj_name;
        $area_id = $this->area_id;
        if ( ! $this->isValidName($object_name)) {
            return RealEstateAgency_Const::NOTHING;
        }
        if ( ! $this->isValidAreaId($area_id)) {
            return RealEstateAgency_Const::NOTHING;
        }

        if (RealEstateAgency_Object_District::loadByNameAndAreaId($this->getGlobalData(), $object_name, $area_id)) {
            return RealEstateAgency_Const::ALREADY_SAVED;
        } else {
            $db = $this->getGlobalData()->takeConnection();
            $table = new RealEstateAgency_Database_District_Table( array( 'db' => $db ) );
            $row = $table->createRow();
            $this->toZendRow($row);
            $row->save();
        }
        return RealEstateAgency_Const::OK;
    }
    
    public function update() {
        $previous_object =  RealEstateAgency_Object_District::loadById($this->getGlobalData(), $this->obj_id);
        if ($previous_object) {
            $row = $previous_object->zend_row;
            $this->area_id = $row->area; // keep area identifier !!!
            $this->toZendRow($row);
            $row->save();
        }
    }
    
    public function getId() {
        return $this->obj_id;
    }
    
    public function setId($value) {
        $this->obj_id = $value;
    }
    
    public function getObjectName() {
        return $this->obj_name;
    }
    
    public function setObjectName($value) {
        $this->obj_name = $value;
    }
    
    public function getAreaId() {
        return $this->area_id;
    }
    
    public function setAreaId($value) {
        $this->area_id = $value;
    }
    
    public function getAreaName() {
        return $this->area_name;
    }
    
    public function setAreaName($value) {
        $this->area_name = $value;
    }
    
    public static function isValidAreaId($value) {
        $validator = new Zend_Validate_Int();
        if ( ! $validator->isValid($value) ) {
            return false;
        }
        return true;
    }
    
    public static function isValidName($value) {
        if ( ($value == NULL) || ($value == '') ) {
            return false;
        }
        return true;
    }

}
