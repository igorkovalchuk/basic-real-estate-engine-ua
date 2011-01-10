<?php

require_once 'RealEstateAgency/Object/List.php';
require_once 'RealEstateAgency/Object/Settlement.php';

class RealEstateAgency_Object_SettlementList extends RealEstateAgency_Object_List
{
    private $objects = array();
    private $districts = array();
    
    private $area_id = '';
    private $district_id = '';
    
    public function getList() {
        return $this->objects;
    }
    
    public function getArray() {
        $result = array();
        $objects = $this->objects;
        foreach ($objects as $index => $object) {
            $hash = array();
            $hash['id'] = $object->getId();
            $hash['name'] = $object->getObjectName();
            $result[] = $hash;
        }
        return $result;
    }
    
    public function setDistrictList($list) {
        $this->districts = $list;
    }
    
    public function setDistrictId($value) {
        $this->district_id = $value;
    }
    
    public function setAreaId($value) {
        $this->area_id = $value;
    }
    
    // Returns: list of objects;
    public function loadBy2() {
        $db = $this->getGlobalData()->takeConnection();
        
        $id = $this->district_id;
        $areaID = $this->area_id;
        
        $where = NULL;
        
        if (($id != NULL) && ($id != '')) {
            $where = $db->quoteInto('district = ?', $id);
        }
        
        $select = $db->select();
        $select->from('settlement');

        if ($where != NULL) {
            $select->where($where);
        }
        $select->order(array('obj_name'));
        $stmt = $db->query($select);
        $result = $stmt->fetchAll();
        $this->objects = $this->completeFillByArray($result);
        return;
    }
    
    public function loadBy() {
        // throw new Exception("Навчись виконувати join запити для Settlement.");
        // $sql = "SELECT settlement.*, district.obj_name AS district_name, area.obj_name AS area_name 
// FROM settlement 
// LEFT JOIN (district, area) 
// ON (settlement.district=district.obj_id AND district.area=area.obj_id)
// WHERE area.obj_id=4";
        
        $district_id = $this->district_id;
        $area_id = $this->area_id;
        
        $db = $this->getGlobalData()->takeConnection();

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

        if ($district_id) {
            $select->where('district.obj_id = ?', $district_id);
        } else if ($area_id) {
            $select->where('area.obj_id = ?', $area_id);
        }
        
        $select->order(array('area_name', 'district_name'));
        
        // echo $select;
        
        $stmt = $db->query($select);
        $result = $stmt->fetchAll();
        // echo '<pre>';
        // var_dump($result);
        // echo '</pre>';
        
        $this->objects = $this->completeFillByArray($result);
        return;
    }
    
    // It use cache for load additional information from database;
    private function completeFillByArray($array) {
        
        $result = array();
        $globalData = $this->getGlobalData();
        $objectsOfDistrict = $this->districts;

        foreach ($array as $index => $hash) {
            $object = new RealEstateAgency_Object_Settlement();
            $object->setGlobalData($globalData);
            $object->completeFillByArray($hash);
            $result[] = $object;
        }
        return $result;
    }
    
}
