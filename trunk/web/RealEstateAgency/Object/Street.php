<?php

require_once 'RealEstateAgency/Object/Obj.php';

require_once 'RealEstateAgency/Const.php';

require_once 'RealEstateAgency/Database/Street/All.php';

require_once 'Zend/Validate.php';
require_once 'Zend/Validate/Int.php';

class RealEstateAgency_Object_Street extends RealEstateAgency_Object_Obj
{
    private $obj_id = NULL;
    private $obj_name = '';
    private $parent_id = '';
    
    private $zend_row = NULL;
    
    public function toString() {
        $str = 'RealEstateAgency_Object_Street: ';
        $str .= 'obj_id=' . $this->obj_id . '; ';
        $str .= 'obj_name=' . $this->obj_name . '; ';
        $str .= 'settlement_id=' . $this->parent_id . '; ';
        return $str;
    }
    
    function fillByArray($row) {
        $this->obj_id = $row['obj_id'];
        $this->obj_name = $row['obj_name'];
        $this->parent_id = $row['settlement'];
    }
    
    function fillByZendRow($row) {
        $this->obj_id = $row->obj_id;
        $this->obj_name = $row->obj_name;
        $this->parent_id = $row->settlement;
        $this->zend_row = $row;
    }
    
    function toZendRow($row) {
        $row->obj_id = $this->obj_id;
        $row->obj_name = $this->obj_name;
        $row->settlement = $this->parent_id;
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
        $table = new RealEstateAgency_Database_Street_Table( array( 'db' => $db ) );
        $where = $db->quoteInto('obj_id = ?', $object_id);
        $rowset = $table->fetchAll($where);
        $row = $rowset->current();
        if ($row) {
            $new_object = new RealEstateAgency_Object_Street();
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
        $table = new RealEstateAgency_Database_Street_Table( array( 'db' => $db ) );
        $where = $db->quoteInto('obj_name = ?', $object_name);
        $rowset = $table->fetchAll($where);
        $row = $rowset->current();
        if ($row) {
            $new_object = new RealEstateAgency_Object_Street();
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
    public static function loadByNameAndParentId($globalData, $object_name, $parent_id) {
        if ( ($object_name == NULL) || ($object_name == '') ) {
            return NULL;
        }
        $validatorChain = new Zend_Validate();
        $validatorChain->addValidator( new Zend_Validate_Int() );
        if ( ! $validatorChain->isValid($parent_id) ) {
            return NULL;
        }
        
        $db = $globalData->takeConnection();
        $table = new RealEstateAgency_Database_Street_Table( array( 'db' => $db ) );
        
        $where   = array(
            $db->quoteInto('obj_name = ?', $object_name),
            $db->quoteInto('settlement = ?', $parent_id)
        );
        $rowset = $table->fetchAll($where);
        $row = $rowset->current();
        if ($row) {
            $new_object = new RealEstateAgency_Object_Street();
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
        $object = RealEstateAgency_Object_Street::loadById($globalData, $object_id);
        if ($object) {
            $object->delete();
        }
    }
    
    // input data: object name, parent id
    public function insert() {
        $object_name = $this->obj_name;
        $parent_id = $this->parent_id;
        if ( ! $this->isValidName($object_name)) {
            return RealEstateAgency_Const::NOTHING;
        }
        if ( ! $this->isValidParentId($parent_id)) {
            return RealEstateAgency_Const::NOTHING;
        }

        if (RealEstateAgency_Object_Street::loadByNameAndParentId($this->getGlobalData(), $object_name, $parent_id)) {
            return RealEstateAgency_Const::ALREADY_SAVED;
        } else {
            $db = $this->getGlobalData()->takeConnection();
            $table = new RealEstateAgency_Database_Street_Table( array( 'db' => $db ) );
            $row = $table->createRow();
            $this->toZendRow($row);
            $row->save();
        }
        return RealEstateAgency_Const::OK;
    }
    
    public function update() {
        $previous_object =  RealEstateAgency_Object_Street::loadById($this->getGlobalData(), $this->obj_id);
        if ($previous_object) {
            $row = $previous_object->zend_row;
            $this->parent_id = $row->settlement; // keep parent identifier !!!
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
    
    public function getSettlementId() {
        return $this->parent_id;
    }
    
    public function setSettlementId($value) {
        $this->parent_id = $value;
    }

    public static function isValidParentId($value) {
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
    
    public function test() {
        
        require_once 'RealEstateAgency/GlobalData.php';
        
        $globalData = new RealEstateAgency_GlobalData();
        
        $object = new RealEstateAgency_Object_Street();
        $object->setGlobalData($globalData);
        $object->obj_id = '';
        $object->obj_name = 'TEST_STREET';
        $object->insert();
        
        // $object2 = $this->loadById($globalData, 1);
        
    }

}

if (false) {
    $object = new RealEstateAgency_Object_Street();
    $object->test();
}


