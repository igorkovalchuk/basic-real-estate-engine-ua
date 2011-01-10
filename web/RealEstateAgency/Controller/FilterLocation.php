<?php

require_once 'RealEstateAgency/Const.php';
require_once 'RealEstateAgency/Util.php';

require_once 'RealEstateAgency/Object/AreaList.php';
require_once 'RealEstateAgency/Object/Area.php';
require_once 'RealEstateAgency/Object/DistrictList.php';
require_once 'RealEstateAgency/Object/District.php';
require_once 'RealEstateAgency/Object/SettlementList.php';
require_once 'RealEstateAgency/Object/Settlement.php';

require_once 'RealEstateAgency/Controller/Base.php';

require_once 'Zend/Validate.php';
require_once 'Zend/Validate/Int.php';

// require_once 'RealEstateAgency/Controller/FilterLocation.php';
/*
Main target: extract (one by one) from page filter values of:
area identifier
district identifier
settlement identifier
city part identifier

But, this class is only for filter tasks - i.e. get filter parameters, no more !
*/
class RealEstateAgency_Controller_FilterLocation extends RealEstateAgency_Controller_Base
{
    
    private $list_of_areas = NULL; // object;
    private $list_of_districts = NULL; // object;
    private $list_of_settlements = NULL; // object;
    
    private $area_id = '';
    private $district_id = '';
    private $settlement_id = '';
    
    private $area_name = '?';
    private $district_name = '?';
    private $settlement_name = '?';
    
    private $sections = 0; // binary mask for select filter sections for show;
    private $sectionsReady = 0; // binary mask for show how many filter sections already on the screen;
    
    private $filter_action = ''; // reset some sections: for example - reset 'district' section for re-select it;
    private $filter_ready = false; // flag for show that all sections of filter already selected;
    
    private function setViewData() {
        $globalData = $this->getGlobalData();
        $pageName = $globalData->getPageName();
        $view = $globalData->getView();
        
        $globalData->setViewVariable('area_id', $this->area_id, $pageName);
        $globalData->setViewVariable('district_id', $this->district_id, $pageName);
        $globalData->setViewVariable('settlement_id', $this->settlement_id, $pageName);
        
        $view->area_name = $this->area_name;
        $view->district_name = $this->district_name;
        $view->settlement_name = $this->settlement_name;
        
        $view->list_of_areas = $this->list_of_areas;
        $view->list_of_districts = $this->list_of_districts;
        $view->list_of_settlements = $this->list_of_settlements;
        
        $view->sections_ready = $this->sectionsReady;
        $view->filter_ready = $this->filter_ready;

    }
    
    public function readFilter() {
        $this->getSectionsNumber();
        $this->getInput();
        $this->resetFilter();
        $this->verifyFilter();
    }
    
    // This method should be called after database transaction for show fresh data;
    public function drawFilter() {
        
        
        
        $this->verifyFilter_second();
        
        // echo "DRAW FILTER: area_id = " . $this->getAreaId() . ' S=' .$this->sections . ' SR=' . $this->sectionsReady;
        
        $this->loadData();
        $this->setViewData();
    }
    
    // Read values from get/post/session parameters;
    private function getInput() {
        $globalData = $this->getGlobalData();
        $pageName = $globalData->getPageName();
        
        if ( RealEstateAgency_Util::isDefinedNonEmptyRequest('filter_action') ) {
            // filter action;
            $this->filter_action = $_REQUEST['filter_action'];
        }
        
        if ($this->sections & RealEstateAgency_Const::FILTER_AREA) {
            // select area for show districts/other information;
            $value = $globalData->getViewVariable('area_id', $pageName);
            if ($value) {
                // TODO: please verify input value;
                $this->area_id = $value;
            }
        }
        if ($this->sections & RealEstateAgency_Const::FILTER_DISTRICT) {
            // select area, select district for show settlements/other information;
            $value = $globalData->getViewVariable('district_id', $pageName);
            if ( $value ) {
                // TODO: please verify input value;
                $this->district_id = $value;
            }
        }
        if ($this->sections & RealEstateAgency_Const::FILTER_SETTLEMENT) {
            // select area, select district, select settlement for show other information;
            $value = $globalData->getViewVariable('settlement_id', $pageName);
            if ( $value ) {
                // TODO: please verify input value;
                $this->settlement_id = $value;
            }
        }
        
        
    }
    
    
    private function getSectionsNumber() {
        $globalData = $this->getGlobalData();
        $page = $globalData->getPageName();
        if ($page == 'area') {
            throw new Exception('For this page we not need in filter.');
        } else if ($page == 'district') {
            $this->sections = RealEstateAgency_Const::FILTER_AREA;
        } else if ($page == 'settl') {
            $this->sections = 
                RealEstateAgency_Const::FILTER_AREA | 
                RealEstateAgency_Const::FILTER_DISTRICT;
        } else if ( ($page == 'settl_part') || ($page == 'street') ) {
            $this->sections = 
                RealEstateAgency_Const::FILTER_AREA | 
                RealEstateAgency_Const::FILTER_DISTRICT |
                RealEstateAgency_Const::FILTER_SETTLEMENT;

        } else {
            throw new Exception('Filter, incorrect name of page.');
        }
    }
    
    
    private function resetFilter() {
        $filter_action = $this->filter_action;
        if ($filter_action) {
            if ($filter_action == 'reset_area') {
                $this->area_id = '';
                $this->district_id = '';
                $this->settlement_id = '';
            } else if ($filter_action == 'reset_district') {
                $this->district_id = '';
                $this->settlement_id = '';
            } else if ($filter_action == 'reset_settlement') {
                $this->settlement_id = '';
            }
        }
    }
    
    /*
    Verify:
    1) correct filter or no;
    2) decide which sections already selected;
    3) decide filter is ready or no;
    */
    private function verifyFilter() {
        $message = 'Incorrect input.';
        if ($this->settlement_id) {
            if ( (! $this->district_id) || (! $this->area_id) ) {
                throw new Exception($message);
            }
        } else if ($this->district_id) {
            if (! $this->area_id) {
                throw new Exception($message);
            }
        }
    }
    
    private function verifyFilter_second() {
        $this->verifyFilter(); // second necessary attempt;

        if ($this->settlement_id) {
            $this->sectionsReady =
                RealEstateAgency_Const::FILTER_AREA | 
                RealEstateAgency_Const::FILTER_DISTRICT |
                RealEstateAgency_Const::FILTER_SETTLEMENT;
        } else if ($this->district_id) {
            $this->sectionsReady =
                RealEstateAgency_Const::FILTER_AREA | 
                RealEstateAgency_Const::FILTER_DISTRICT;
        } else if ($this->area_id) {
            $this->sectionsReady = RealEstateAgency_Const::FILTER_AREA;
        }
        
        if ($this->sections == $this->sectionsReady) {
            $this->filter_ready = true;
        }

    }
    
    /*
    Where data was already selected - we show only name in selected section;
    Where data was not already selected - we show list;
    */
    private function loadData() {
        $globalData = $this->getGlobalData();
        $sections = $this->sections;
        $sectionsReady = $this->sectionsReady;
        
        if ($sectionsReady & RealEstateAgency_Const::FILTER_AREA) {
            // load name of this section;
            $object = RealEstateAgency_Object_Area::loadById($globalData, $this->area_id);
            if ($object) {
                

                
                $this->area_name = $object->getObjectName();
            }
        } else {
            // load list for selection, if necessary;
            if ($sections & RealEstateAgency_Const::FILTER_AREA) {
                $this->loadAreasList();
            }
        }
        
        if ($sectionsReady & RealEstateAgency_Const::FILTER_DISTRICT) {
            // load name of this section;
            $object = RealEstateAgency_Object_District::loadById($globalData, $this->district_id);
            if ($object) {
                $this->district_name = $object->getObjectName();
            }
        } else {
            // load list for selection, if necessary; and if all previous sections are ready;
            if ($sections & RealEstateAgency_Const::FILTER_DISTRICT) {
                if ($sectionsReady & RealEstateAgency_Const::FILTER_AREA) {
                    $this->loadAreasList();
                    $this->loadDistrictsList();
                }
            }
        }
        
        if ($sectionsReady & RealEstateAgency_Const::FILTER_SETTLEMENT) {
            // load name of this section;
            $object = RealEstateAgency_Object_Settlement::loadById($globalData, $this->settlement_id);
            if ($object) {
                $this->settlement_name = $object->getObjectName();
            }
        } else {
            // load list for selection, if necessary; and if all previous sections are ready;
            if ($sections & RealEstateAgency_Const::FILTER_SETTLEMENT) {
                if ($sectionsReady & RealEstateAgency_Const::FILTER_DISTRICT) {
                    if ($sectionsReady & RealEstateAgency_Const::FILTER_AREA) {
                        $this->loadAreasList();
                        $this->loadDistrictsList();
                        $this->loadSettlementsList();
                    }
                }
            }
        }

    }
    
    
    public function isReady() {
        return $this->filter_ready;
    }
    
    public function getAreaId() {
        return $this->area_id;
    }
    
    public function setAreaId($value) {
        $this->area_id = $value;
    }
    
    
    public function getDistrictId() {
        return $this->district_id;
    }
    
    public function setDistrictId($value) {
        $this->district_id = $value;
    }
    
    
    public function getSettlementId() {
        return $this->settlement_id;
    }

    public function setSettlementId($value) {
        $this->settlement_id = $value;
    }
    
    
    /*
    Load all areas from database;
    */
    private function loadAreasList() {
        
        
        
        $objectsList = new RealEstateAgency_Object_AreaList();
        $objectsList->setGlobalData($this->getGlobalData());
        $objectsList->load();
        $this->list_of_areas = $objectsList;
        return $objectsList;
    }
    
    /*
    Load districts from database by area identifier;
    */
    private function loadDistrictsList() {
        $objectsList = new RealEstateAgency_Object_DistrictList();
        $objectsList->setGlobalData($this->getGlobalData());
        // $objectsList->setAreaList($this->list_of_areas);
        $objectsList->setAreaId($this->area_id);
        $objectsList->loadBy();
        $this->list_of_districts = $objectsList;
        return $objectsList;
    }
    
    /*
    Load settlements from database by district identifier;
    */
    private function loadSettlementsList() {
        $objectsList = new RealEstateAgency_Object_SettlementList();
        $objectsList->setGlobalData($this->getGlobalData());
        // $objectsList->setAreaList($this->list_of_areas);
        // $objectsList->setDistrictList($this->list_of_districts);
        $objectsList->setDistrictId($this->district_id);
        $objectsList->loadBy();
        $this->list_of_settlements = $objectsList;
        return $objectsList;
    }
    
}

