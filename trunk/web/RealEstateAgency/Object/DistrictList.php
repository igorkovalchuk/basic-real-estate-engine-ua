<?php

require_once 'RealEstateAgency/Object/District.php';

class RealEstateAgency_Object_DistrictList extends RealEstateAgency_Object_List
{
    private $objects = array();
    
    
    private $area_id = '';
    
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
    
    public function setAreaId($value) {
        $this->area_id = $value;
    }
    
    // Returns: list of objects;
    public function loadBy() {
        
        $area_id = $this->area_id;
        
        $db = $this->getGlobalData()->takeConnection();
        // $table = new RealEstateAgency_District_Table( array( 'db' => $db ) );

        $where = NULL;
        if (($area_id != NULL) && ($area_id != '')) {
            $where = $db->quoteInto('area = ?', $area_id);
        }
        
        $select = $db->select();
        $select->from('district');
        if ($where != NULL) {
            $select->where($where);
        }
        $select->order(array('obj_name'));
        $stmt = $db->query($select);
        $result = $stmt->fetchAll();
        
        // echo "<hr /><pre> HERE ".var_dump ($result)."</pre> <hr/>";     
        
        // $rowCount = count($result);
        // RealEstateAgency_Util::printTestString("Loaded: $rowCount rows"); // test string;
        $this->objects = $this->completeFillByArray($result);
        return;
    }
    
    // It use cache for load additional information from database;
    private function completeFillByArray($array) {
        
        $result = array();
        $globalData = $this->getGlobalData();
        
        // echo "<hr /><pre> HERE ".var_dump ($objectsOfArea)."</pre> <hr/>";    
// echo "start";
        // RealEstateAgency_Object_Cache
        foreach ($array as $index => $hash) {
            

            
            $object = new RealEstateAgency_Object_District();
            $object->setGlobalData($globalData);
            // echo "<hr /><pre> HERE ".var_dump ($hash)."</pre> <hr/>";
// echo get_class($object);
            $object->completeFillByArray($hash);
            $result[] = $object;
        }
        
        // echo "D-FOUND[".count($result)."]";
        
        return $result;
    }
    
    public function loadForShow() {
        
        $area_id = $this->area_id;
        
        $db = $this->getGlobalData()->takeConnection();

        $select = $db->select();
        $select->from('district');
        
        $select->joinLeft(
            'area',
            'district.area=area.obj_id',
            array('area_name' => 'obj_name', 'area_id' => 'obj_id')
        );
        
        if ($area_id) {
            $where = $db->quoteInto('area.obj_id = ?', $area_id);
            $select->where($where);
        }
// echo "SQL HERE " . $select;
        $select->order(array('area_name', 'obj_name'));
        
        $stmt = $db->query($select);
        $result = $stmt->fetchAll();
// echo " RES: " . count($result);        
        $this->objects = $this->completeFillByArray($result);
        return;
    }
    
    
}
