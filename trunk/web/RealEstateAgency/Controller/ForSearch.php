<?php

require_once 'RealEstateAgency/Const.php';
require_once 'RealEstateAgency/Util.php';

require_once 'RealEstateAgency/Object/RealEstateObject.php';
require_once 'RealEstateAgency/Object/RealEstateObjectList.php';
require_once 'RealEstateAgency/Object/SettlementList.php';

require_once 'RealEstateAgency/Object/SettlementPartList.php';

require_once 'RealEstateAgency/Object/SearchFilter.php';

require_once 'Zend/Validate.php';
require_once 'Zend/Validate/Int.php';

require_once 'RealEstateAgency/Controller/Base.php';

class RealEstateAgency_Controller_ForSearch extends RealEstateAgency_Controller_Base
{
    
    private $object_action = '';
    private $location_id = NULL;
    private $location_text = NULL;
    private $action = '';
    
    public function execute($page) {
        
		$globalData = $this->getGlobalData();
		
        $view = $this->getGlobalData()->getView();
		
        if (RealEstateAgency_Const::TYPE_FLAT == $page) {
            
        } else if (RealEstateAgency_Const::TYPE_ROOM == $page) {
            
        } else if (RealEstateAgency_Const::TYPE_HOUSE == $page) {
        
		} else if (RealEstateAgency_Const::TYPE_COTTAGE == $page) {
		
        } else if (RealEstateAgency_Const::TYPE_COMMERCIAL == $page) {
        
		} else if (RealEstateAgency_Const::TYPE_LAND == $page) {
		
        } else {
            return;
        }
        
		$rent1 = tools_get_input('rent');
		$rent2 = tools_get_input('op_type');
		$operation_type = 0;
		if ( ($rent2 == 1) || ($rent1 == 1) ) {
			$operation_type = 1;
		}
		
		$view->page = $page;
		
		$search_period = $globalData->getViewVariable('search_period', 'search');
		$search_price_1 = $globalData->getViewVariable('search_price_1', 'search');
		$search_price_2 =  $globalData->getViewVariable('search_price_2', 'search');
		$search_rooms = $globalData->getViewVariable('search_rooms', 'search');
		$search_city_district = $globalData->getViewVariable('search_city_district', 'search');
		$search_position = tools_get_input('search_position');
		
        $list = new RealEstateAgency_Object_RealEstateObjectList();
        $list->setGlobalData($this->getGlobalData());
		$list->setSearch($page);
		
		$filter = new RealEstateAgency_Object_SearchFilter();
		
		$filter->setOperationType($operation_type);
		$filter->setPeriod($search_period);
		$filter->setPriceFrom($search_price_1);
		$filter->setPriceTo($search_price_2);
		$filter->setRooms($search_rooms);
		$filter->setCityDistrict($search_city_district);
		$filter->setPosition($search_position);
		$filter->setLimit(RealEstateAgency_Const::OBJECTS_ON_PAGE);
		$filter->prepare();
		
        $list->loadBy($filter);
        
		$view->op_type = $filter->getOperationType();
		// $view->search_period = $filter->getPeriod();
		$view->search_price_1 = $filter->getPriceFrom();
		$view->search_price_2 = $filter->getPriceTo();
		$view->search_rooms = $filter->getRooms();
		$view->search_city_district = $filter->getCityDistrict();
		$view->search_position = $filter->getPosition();
		
		$globalData->setViewVariable('search_period', $filter->getPeriod(), 'search');
		$globalData->setViewVariable('search_price_1', $filter->getPriceFrom(), 'search');
		$globalData->setViewVariable('search_price_2', $filter->getPriceTo(), 'search');
		$globalData->setViewVariable('search_rooms', $filter->getRooms(), 'search');
		$globalData->setViewVariable('search_city_district', $filter->getCityDistrict(), 'search');
		
        $view->list_of_settlements = $list;
    }
    
    
}

