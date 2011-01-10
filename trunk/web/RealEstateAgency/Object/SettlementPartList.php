<?php

require_once 'RealEstateAgency/Object/SettlementPart.php';

class RealEstateAgency_Object_SettlementPartList extends RealEstateAgency_Object_List
{
    private $objects = array();
    
    private $settlement_id = '';
    
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
    
    public function setSettlementId($value) {
        $this->settlement_id = $value;
    }
    
    // Returns: list of objects;
    public function loadBy() {
        $db = $this->getGlobalData()->takeConnection();
        
        $id = $this->settlement_id;
        
        $where = NULL;
        if (($id != NULL) && ($id != '')) {
            $where = $db->quoteInto('settlement = ?', $id);
        }
        
        $select = $db->select();
        $select->from('settlement_part');

        if ($where != NULL) {
            $select->where($where);
        }
        $select->order(array('obj_name'));
        $stmt = $db->query($select);
        $result = $stmt->fetchAll();
        $this->objects = $this->completeFillByArray($result);
        return;
    }
    
    
    // It use cache for load additional information from database;
    private function completeFillByArray($array) {
        
        $result = array();
        $globalData = $this->getGlobalData();

        foreach ($array as $index => $hash) {
            $object = new RealEstateAgency_Object_SettlementPart();
            $object->setGlobalData($globalData);
            $object->fillByArray($hash);
            $result[] = $object;
        }
        return $result;
    }
    
}
