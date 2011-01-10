<?php

require_once 'RealEstateAgency/Const.php';

require_once 'RealEstateAgency/Object/Obj.php';

require_once 'RealEstateAgency/Database/Area/All.php';

require_once 'Zend/Validate.php';
require_once 'Zend/Validate/Int.php';

class RealEstateAgency_Object_Area extends RealEstateAgency_Object_Obj
{
    
    private $obj_id = NULL;
    private $obj_name = '';
    private $country = NULL;
    
    private $zend_row = NULL;
    
    public function toString() {
        $str = 'RealEstateAgency_Object_Area: ';
        $str .= 'obj_id=' . $this->obj_id . '; ';
        $str .= 'obj_name=' . $this->obj_name . '; ';
        return $str;
    }
    
    function fillByArray($row) {
        $this->obj_id = $row['obj_id'];
        $this->obj_name = $row['obj_name'];
    }
    
    function fillByZendRow($row) {
        $this->obj_id = $row->obj_id;
        $this->obj_name = $row->obj_name;
        $this->zend_row = $row;
    }
    
    private function toZendRow($row) {
        $row->obj_id = $this->obj_id;
        $row->obj_name = $this->obj_name;
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
        $table = new RealEstateAgency_Database_Area_Table( array( 'db' => $db ) );
        $where = $db->quoteInto('obj_id = ?', $object_id);
        $rowset = $table->fetchAll($where);
        $row = $rowset->current();
        if ($row) {
            $new_object = new RealEstateAgency_Object_Area();
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
        $table = new RealEstateAgency_Database_Area_Table( array( 'db' => $db ) );
        $where = $db->quoteInto('obj_name = ?', $object_name);
        // RealEstateAgency_Util::printTestString('WHERE: ['.$where.']'); // test string;
        $rowset = $table->fetchAll($where);
        $row = $rowset->current();
        if ($row) {
            $new_object = new RealEstateAgency_Object_Area();
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
        $object = RealEstateAgency_Object_Area::loadById($globalData, $object_id);
        if ($object) {
            $object->delete();
        }
    }
    
    public function insert() {
        $object_name = $this->obj_name;
        if (RealEstateAgency_Object_Area::loadByName($this->getGlobalData(), $object_name)) {
            return RealEstateAgency_Const::ALREADY_SAVED;
        } else {
            $db = $this->getGlobalData()->takeConnection();
            $table = new RealEstateAgency_Database_Area_Table( array( 'db' => $db ) );
            $row = $table->createRow();
            $this->toZendRow($row);
            $row->save();
        }
        return RealEstateAgency_Const::OK;
    }
    
    public function update() {
        $previous_object =  RealEstateAgency_Object_Area::loadById($this->getGlobalData(), $this->obj_id);
        if ($previous_object) {
            $row = $previous_object->zend_row;
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

}
