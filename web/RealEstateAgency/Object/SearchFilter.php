<?php

require_once 'RealEstateAgency/Util.php';
require_once 'RealEstateAgency/Const.php';

class RealEstateAgency_Object_SearchFilter 
{
	
	private $operation_type = 0;
	private $period = NULL;
	private $price_1 = NULL;
	private $price_2 = NULL;
	private $rooms = NULL;
	private $city_district = 0;
	private $position = 0;
	private $limit = NULL;
	
	public function getPeriod() {
        return $this->period;
    }
	
    public function setPeriod($value) {
		$result = RealEstateAgency_Const::SEARCH_PERIOD;
		if ( tools_verify_positive_int($value) ) {
			$result = $value;
			if ($result == 0) {
				$result = 1;
			}
			if ($result > RealEstateAgency_Const::SEARCH_PERIOD_MAX) {
				$result = RealEstateAgency_Const::SEARCH_PERIOD_MAX;
			}
		}
        $this->period = $result;
    }
	
	
	public function getPriceFrom() {
        return $this->price_1;
    }
	
	public function setPriceFrom($value) {
		$result = NULL;
		if ( tools_verify_positive_int($value) ) {
			$result = $value;
		}
        $this->price_1 = $result;
    }
	
	
	public function getPriceTo() {
        return $this->price_2;
    }
	
	public function setPriceTo($value) {
		$result = NULL;
		if ( tools_verify_positive_int($value) ) {
			$result = $value;
		}
        $this->price_2 = $result;
    }
	
	
	public function getRooms() {
        return $this->rooms;
    }
	
    public function setRooms($value) {
		$result = NULL;
		if ( tools_verify_positive_int($value) ) {
			$result = $value;
			if ($result > 999) {
				$result = 999;
			}
		}
        $this->rooms = $result;
    }
	
	public function setCityDistrict($value) {
		if ( tools_verify_positive_int($value) ) {
			$this->city_district = $value;
		}
	}
	
	public function getCityDistrict() {
		return $this->city_district;
	}
	
	public function getOperationType() {
        return $this->operation_type;
    }
	
	public function setOperationType($value) {
		$result = 0;
		if (1 == $value) {
			$result = 1;
		}
        $this->operation_type = $result;
    }
	
	public function getPosition() {
        return $this->position;
    }
	
	public function setPosition($value) {
		$result = 0;
		if (tools_verify_positive_int($value)) {
			$result = $value;
			if ($value > 1000000) {
				$result = 0;
			}
		}
        $this->position = $result;
    }
	
	public function getLimit () {
		return $this->limit;
	}
	
	public function setLimit($value) {
		$result = NULL;
		if ( tools_verify_positive_int($value) ) {
			$result = $value;
			if ($value > 500) {
				$result = NULL;
			}
		}
        $this->limit = $result;
    }
	
	public function prepare() {
		if ( ($this->price_1 != NULL) && ($this->price_2 != NULL) ) {
			if ($this->price_1 > $this->price_2) {
				$price = $this->price_1;
				$this->price_1 = $this->price_2;
				$this->price_2 = $price;
			}
		}
	}
	
}