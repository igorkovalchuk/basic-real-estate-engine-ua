<?php

require_once 'RealEstateAgency/Const.php';
require_once 'RealEstateAgency/Object/RealEstateObject.php';
require_once 'RealEstateAgency/Object/List.php';
require_once 'RealEstateAgency/Object/SearchFilter.php';
require_once 'RealEstateAgency/Util.php';

class RealEstateAgency_Object_RealEstateObjectList extends RealEstateAgency_Object_List
{
    private $objects = array();
    
    private $search = NULL;
	
	private $counter = 0;
    
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
    
    public function setSearch($search) {
        $this->search = $search;
    }
	
	public function getCounter() {
		return $this->counter;
	}
	
	/**
	 * filter - RealEstateAgency_Object_SearchFilter
	 */
    public function loadBy($filter) {
        
		$operationType = $filter->getOperationType();
		
		$period = $filter->getPeriod();
		$price_1 = $filter->getPriceFrom();
		$price_2 = $filter->getPriceTo();
		$rooms = $filter->getRooms();
		$city_district = $filter->getCityDistrict();
		$position = $filter->getPosition();
		$limit = $filter->getLimit();
		//if ($limit != NULL) {
			//$limit++;
		//}
		
        $db = $this->getGlobalData()->takeConnection();
		
        $select = $db->select();
        $select->from('r_e_object');

		$counter = $db->select();
		$counter->from('r_e_object', array('counter' => 'COUNT(*)'));

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
        
		$select->where('op_type = ?', $operationType);
		$counter->where('op_type = ?', $operationType);
		
		$search = $this->search;
		
        if ($search) {
			
            if (RealEstateAgency_Const::TYPE_FLAT == $search) {
                //$select->where('settlement_id = ?', RealEstateAgency_Const::MAIN_SETTLEMENT_ID);
                $select->where('type = ?', RealEstateAgency_Const::TYPE_FLAT_NUMBER);
				$counter->where('type = ?', RealEstateAgency_Const::TYPE_FLAT_NUMBER);
                $select->order(array('area_name', 'rooms', 'district_name', 'settlement_name', 'settlement_part_name', 'price'));
            } else if (RealEstateAgency_Const::TYPE_ROOM == $search) {
                $select->where('type = ?', RealEstateAgency_Const::TYPE_ROOM_NUMBER);
				$counter->where('type = ?', RealEstateAgency_Const::TYPE_ROOM_NUMBER);
                $select->order(array('area_name', 'district_name', 'settlement_name', 'settlement_part_name', 'price'));
            } else if (RealEstateAgency_Const::TYPE_COMMERCIAL == $search) {
                // Commercial;
                $select->where('type = ?', RealEstateAgency_Const::TYPE_COMMERCIAL_NUMBER);
				$counter->where('type = ?', RealEstateAgency_Const::TYPE_COMMERCIAL_NUMBER);
                $select->order(array('area_name', 'district_name', 'settlement_name', 'settlement_part_name', 'price'));
            } else if (RealEstateAgency_Const::TYPE_HOUSE == $search) {
                // Private house;
                $select->where('type = ?', RealEstateAgency_Const::TYPE_HOUSE_NUMBER);
				$counter->where('type = ?', RealEstateAgency_Const::TYPE_HOUSE_NUMBER);
                $select->order(array('area_name', 'district_name', 'settlement_name', 'settlement_part_name', 'price'));
            } else if (RealEstateAgency_Const::TYPE_COTTAGE == $search) {
				// Cottage;
				$select->where('type = ?', RealEstateAgency_Const::TYPE_COTTAGE_NUMBER);
				$counter->where('type = ?', RealEstateAgency_Const::TYPE_COTTAGE_NUMBER);
                $select->order(array('area_name', 'district_name', 'settlement_name', 'settlement_part_name', 'price'));
			} else if (RealEstateAgency_Const::TYPE_LAND == $search) {
				// Land;
				$select->where('type = ?', RealEstateAgency_Const::TYPE_LAND_NUMBER);
				$counter->where('type = ?', RealEstateAgency_Const::TYPE_LAND_NUMBER);
                $select->order(array('area_name', 'district_name', 'settlement_name', 'settlement_part_name', 'price'));
			} else {
				return;
			}
        }
		
		if ($period != NULL) {
			$current_time = time();
			$current_time -= $period * 24 * 60 * 60;
			$current_time = tools_date2database($current_time);
			$select->where('updated >= ?', $current_time);
			$counter->where('updated >= ?', $current_time);
		}
		
		if ($rooms != NULL) {
			$select->where('rooms = ?', $rooms);
			$counter->where('rooms = ?', $rooms);
		}
		
		if ( ($city_district !== NULL) && ($city_district != 0) ) {
			$select->where('settl_area_id = ?', $city_district);
			$counter->where('settl_area_id = ?', $city_district);
		}
		
		if ($price_1 != NULL) {
			$select->where('price >= ?', $price_1);
			$counter->where('price >= ?', $price_1);
		}
		
		if ($price_2 != NULL) {
			$select->where('price <= ?', $price_2);
			$counter->where('price <= ?', $price_2);
		}
		
        //if ($district_id) {
          //  $where = $db->quoteInto('district.obj_id = ?', $district_id);
           // $select->where($where);
        //} else if ($area_id) {
          //  $where = $db->quoteInto('area.obj_id = ?', $area_id);
           // $select->where($where);
        //}
		
        //$select->order(array('area_name', 'district_name', 'obj_name'));
        
        // echo $select;
		
		if (($position !== NULL) && ($limit != NULL)) {
			$select->limit($limit,$position);
		}

		if (RealEstateAgency_Const::FROZEN) {
			$result_counter = 0;
			$result = array();
		} else {
			$stmt = $db->query($select);
			$result = $stmt->fetchAll();
	
			// 0,0014 seconds = 0,0018 seconds with count(*).
			$stmt_counter = $db->query($counter);
			$result_counter = 0;
			if ($row_counter = $stmt_counter->fetch()) {
				$result_counter = $row_counter['counter'];
			}
		}

		$this->counter = $result_counter;

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
        //$objectsOfDistrict = $this->districts;

        foreach ($array as $index => $hash) {
            $object = new RealEstateAgency_Object_RealEstateObject();
            $object->setGlobalData($globalData);
            $object->completeFillByArray($hash);
            $result[] = $object;
        }
        return $result;
    }
    
}
