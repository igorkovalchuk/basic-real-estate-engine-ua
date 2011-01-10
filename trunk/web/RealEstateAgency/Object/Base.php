<?php

class RealEstateAgency_Object_Base
{
    
    private $globalData = NULL;
    
    public function setGlobalData($object) {
        $this->globalData = $object;
    }
    
    protected function getGlobalData() {
        return $this->globalData;
    }

	public function cleanup() {
		$this->globalData = NULL;
	}

}