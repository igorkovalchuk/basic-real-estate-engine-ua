<?php

require_once 'RealEstateAgency/Object/List.php';
require_once 'RealEstateAgency/Object/Area.php';

/*
        Some objects in the database are complex objects and consist from several database tables;
        so we need represent all textual data to end user;
*/
class RealEstateAgency_Object_AreaList extends RealEstateAgency_Object_List
{
    
    private $objects = array();
    
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
    
    public function findObjectById($area_id) {
        if ($area_id == NULL) {
            return NULL;
        }
        $list = $this->getList();
        foreach ($list as $index => $object) {
            if ($object->getId() == $area_id) {
                return $object;
            }
        }
        return NULL;
    }
    
    public function load() {
        $db = $this->getGlobalData()->takeConnection();
        $select = $db->select()->from('area')->order(array('obj_name'));
        $stmt = $db->query($select);
        $result = $stmt->fetchAll();
        $this->fillByArray($result);
        return;
    }
    
    private function fillByArray($rowset) {
        $result = array();
        $globalData = $this->getGlobalData();
        
        foreach ($rowset as $index => $row) {
            $object = new RealEstateAgency_Object_Area();
            $object->setGlobalData($globalData);
            $object->fillByArray($row);
            $result[] = $object;
        }
        $this->objects = $result;
    }
    
}
