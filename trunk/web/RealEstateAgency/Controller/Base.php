<?php

class RealEstateAgency_Controller_Base
{
    
    private $globalData = NULL;
    
    public function setGlobalData($object) {
        $this->globalData = $object;
    }
    
    protected function getGlobalData() {
        return $this->globalData;
    }
    
    
}