<?php

require_once 'RealEstateAgency/Object/Obj.php';

require_once 'RealEstateAgency/Const.php';

require_once 'RealEstateAgency/Database/Settlement/All.php';

require_once 'Zend/Validate.php';
require_once 'Zend/Validate/Int.php';

class RealEstateAgency_Object_Settlement extends RealEstateAgency_Object_Obj
{
    private $obj_id = NULL;
    private $obj_name = '';
    private $district_id = NULL; // in the database: district
    
    private $area_name = '?';
    private $district_name = '?';
    private $area_id = '';
    
    private $zend_row = NULL;
    
    public function toString() {
        $str = 'RealEstateAgency_Object_Settlement: ';
        $str .= 'obj_id=' . $this->obj_id . '; ';
        $str .= 'obj_name=' . $this->obj_name . '; ';
        $str .= 'district_id=' . $this->district_id . '; ';
        return $str;
    }
    
    function completeFillByArray($row) {
        $this->fillByArray($row);
        $this->district_name = $row['district_name'];
        $this->area_name = $row['area_name'];
        $this->area_id = $row['area_id'];
    }
    
    function fillByArray($row) {
        $this->obj_id = $row['obj_id'];
        $this->obj_name = $row['obj_name'];
        $this->district_id = $row['district'];
    }
    
    function fillByZendRow($row) {
        $this->obj_id = $row->obj_id;
        $this->obj_name = $row->obj_name;
        $this->district_id = $row->district;
        $this->zend_row = $row;
    }
    
    function toZendRow($row) {
        $row->obj_id = $this->obj_id;
        $row->obj_name = $this->obj_name;
        $row->district = $this->district_id;
    }
    
    /*
    Constructor;
    */
    private function loadById_object($globalData, $object_id) {
        $validatorChain = new Zend_Validate();
        $validatorChain->addValidator( new Zend_Validate_Int() );
        if ( ! $validatorChain->isValid($object_id) ) {
            return NULL;
        }
        $db = $globalData->takeConnection();
        $table = new RealEstateAgency_Database_Settlement_Table( array( 'db' => $db ) );
        $where = $db->quoteInto('obj_id = ?', $object_id);
        $rowset = $table->fetchAll($where);
        $row = $rowset->current();
        if ($row) {
            $new_object = new RealEstateAgency_Object_Settlement();
            $new_object->setGlobalData($globalData);
            $new_object->fillByZendRow($row);
            return $new_object;
        } else {
            return NULL;
        }
    }
    
    
    public function loadById($globalData, $object_id) {
        $validatorChain = new Zend_Validate();
        $validatorChain->addValidator( new Zend_Validate_Int() );
        if ( ! $validatorChain->isValid($object_id) ) {
            return NULL;
        }
        $db = $globalData->takeConnection();

        $select = $db->select();
        $select->from('settlement');
        
        $select->joinLeft(
            'district',
            'settlement.district=district.obj_id',
            array('district_name' => 'obj_name')
        );

        $select->joinLeft(
            'area',
            'district.area=area.obj_id',
            array('area_name' => 'obj_name', 'area_id' => 'obj_id')
        );
        
        $where = $db->quoteInto('settlement.obj_id = ?', $object_id);
        $select->where($where);

// echo $select;
        
        $stmt = $db->query($select);
        $result = $stmt->fetchAll();
        $row = current($result);
        
        if ($row) {
            $new_object = new RealEstateAgency_Object_Settlement();
            $new_object->setGlobalData($globalData);
            $new_object->completeFillByArray($row);
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
        $table = new RealEstateAgency_Database_Settlement_Table( array( 'db' => $db ) );
        $where = $db->quoteInto('obj_name = ?', $object_name);
        // RealEstateAgency_Util::printTestString('WHERE: ['.$where.']'); // test string;
        $rowset = $table->fetchAll($where);
        $row = $rowset->current();
        if ($row) {
            $new_object = new RealEstateAgency_Object_Settlement();
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
    public static function loadByNameAndDistrictId($globalData, $object_name, $district_id) {
        if ( ($object_name == NULL) || ($object_name == '') ) {
            return NULL;
        }
        $validatorChain = new Zend_Validate();
        $validatorChain->addValidator( new Zend_Validate_Int() );
        if ( ! $validatorChain->isValid($district_id) ) {
            return NULL;
        }
        
        $db = $globalData->takeConnection();
        $table = new RealEstateAgency_Database_Settlement_Table( array( 'db' => $db ) );
        
        $where   = array(
            $db->quoteInto('obj_name = ?', $object_name),
            $db->quoteInto('district = ?', $district_id)
        );
        // RealEstateAgency_Util::printTestString('WHERE: ['.$where.']'); // test string;
        $rowset = $table->fetchAll($where);
        $row = $rowset->current();
        if ($row) {
            $new_object = new RealEstateAgency_Object_Settlement();
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
        $object = RealEstateAgency_Object_Settlement::loadById_object($globalData, $object_id);
        if ($object) {
            $object->delete();
        }
    }
    
    // input data: object name, district id
    public function insert() {
        $object_name = $this->obj_name;
        $district_id = $this->district_id;
        if ( ! $this->isValidName($object_name)) {
            return RealEstateAgency_Const::NOTHING;
        }
        if ( ! $this->isValidDistrictId($district_id)) {
            return RealEstateAgency_Const::NOTHING;
        }

        if (RealEstateAgency_Object_Settlement::loadByNameAndDistrictId($this->getGlobalData(), $object_name, $district_id)) {
            return RealEstateAgency_Const::ALREADY_SAVED;
        } else {
            $db = $this->getGlobalData()->takeConnection();
            $table = new RealEstateAgency_Database_Settlement_Table( array( 'db' => $db ) );
            $row = $table->createRow();
            $this->toZendRow($row);
            $row->save();
        }
        return RealEstateAgency_Const::OK;
    }
    
    public function update() {
        $previous_object =  RealEstateAgency_Object_Settlement::loadById_object($this->getGlobalData(), $this->obj_id);
        if ($previous_object) {
            $row = $previous_object->zend_row;
            $this->district_id = $row->district; // keep district identifier !!!
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
    
    public function getDistrictId() {
        return $this->district_id;
    }
    
    public function setDistrictId($value) {
        $this->district_id = $value;
    }

    public function getAreaId() {
        return $this->area_id;
    }

    public function getAreaName() {
        return $this->area_name;
    }
    
    public function setAreaName($value) {
        $this->area_name = $value;
    }
    
    public function getDistrictName() {
        return $this->district_name;
    }
    
    public function setDistrictName($value) {
        $this->district_name = $value;
    }
    
    public static function isValidDistrictId($value) {
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
