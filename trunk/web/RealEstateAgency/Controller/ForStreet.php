<?php

require_once 'RealEstateAgency/Const.php';
require_once 'RealEstateAgency/Util.php';


require_once 'RealEstateAgency/Controller/FilterLocation.php';

require_once 'RealEstateAgency/Object/Street.php';
require_once 'RealEstateAgency/Object/StreetList.php';

require_once 'RealEstateAgency/Controller/Base.php';

require_once 'Zend/Validate.php';
require_once 'Zend/Validate/Int.php';

/*
Page have two modes: list(i.e. empty string), edit;
empty string - default state and after insert, update, delete;
edit - only after use 'edit' link;

Object may have such actions: new, update, delete, edit;

*/
class RealEstateAgency_Controller_ForStreet extends RealEstateAgency_Controller_Base
{
    
    private $filter = NULL;
    
    private $object_id = '';
    private $object_name = '';
    private $object_action = '';
    private $page_mode = '';

    private $already_saved = false;

    private $button_name = '';

    private function setViewData() {
        $view = $this->getGlobalData()->getView();
        $view->object_id = $this->object_id;
        $view->object_name = $this->object_name;
        $view->object_action = $this->object_action;
        $view->page_mode = $this->page_mode;
        $view->already_saved = $this->already_saved;
    }
    
    private function cleanView() {
        $this->object_id = '';
        $this->object_name = '';
        $this->object_action = '';
        $this->page_mode = '';
    }
    
    // First method called by general controller;
    public function execute() {
        // $globalData = $this->getGlobalData();
        // Action;
        
        $filter = new RealEstateAgency_Controller_FilterLocation();
        $this->filter = $filter;
        $filter->setGlobalData($this->getGlobalData());
        $filter->readFilter();
        
        $this->getInput();
        $this->action();
        // This method should be called after commit transaction for show fresh data;
        
        $filter->drawFilter();
        
        $this->loadData();
        
        $this->setViewData();
    }
    
    private function getInput() {
        // Fetch input values;
        if ( RealEstateAgency_Util::isDefinedNonEmptyRequest('object_name') ) {
            // TODO: please verify input value;
            $object_name = $_REQUEST['object_name'];
            $object_name = trim($object_name);
            $this->object_name = $object_name;
        }
        if ( RealEstateAgency_Util::isDefinedNonEmptyRequest('object_id') ) {
            // TODO: please verify input value;
            $this->object_id = $_REQUEST['object_id'];
        }
        if ( RealEstateAgency_Util::isDefinedNonEmptyRequest('object_action') ) {
            // TODO: please verify input value;
            $this->object_action = $_REQUEST['object_action'];
        }

        if ( RealEstateAgency_Util::isButton('do_select') ) {
            $this->button_name = 'select';
        }
        
    }
    
    private function action() {
        
        $object_name = $this->object_name;
        $object_action = $this->object_action;
        
        // Choose action;
        if ($this->button_name == 'select') {
            $this->cleanView();
            return;
        } else if ( $object_action == 'new' ) {
            // new [by submit]
            RealEstateAgency_Util::printTestString('INSERT'); // test string;
            if ($object_name == '') {
                return;
            }
            $this->insert();
            $this->cleanView();
        } else if ( $object_action == 'update' ) {
            // updated [by submit]
            RealEstateAgency_Util::printTestString('UPDATE'); // test string;
            if ($object_name == '') {
                return;
            }
            $this->update();
            $this->cleanView();
        } else if ( $object_action == 'delete' ) {
            // delete [by link]
            RealEstateAgency_Util::printTestString('DELETE'); // test string;
            $this->delete();
            $this->cleanView();
        } else if ( $object_action == 'edit' ) {
            // edit [by link]
            RealEstateAgency_Util::printTestString('EDIT'); // test string;
            $this->edit();
        } else {
            // just list;
            RealEstateAgency_Util::printTestString('LIST'); // test string;
            $this->cleanView();
        }
        return;
    }
    
    /*
    input: object_id
    */
    private function edit() {
        $object = RealEstateAgency_Object_Street::loadById($this->getGlobalData(), $this->object_id);
        if ($object) {
            $this->object_id = $object->getId();
            $this->object_name = $object->getObjectName();
            $this->page_mode = 'edit'; // set other action now;
        }
    }
    
    /*
    input: object_id, object_name
    warning: do not change an area identifier !
    */
    private function update() {
        $object = new RealEstateAgency_Object_Street();
        $object->setGlobalData( $this->getGlobalData() );
        $object->setId( $this->object_id );
        $object->setObjectName( $this->object_name );
        $object->update();
    }
    
    /*
    input: object_name, parent_id
    */
    private function insert() {
        
        $object_name = $this->object_name;
        $settlement_id = $this->filter->getSettlementId();
        
        $object = new RealEstateAgency_Object_Street();
        $object->setGlobalData( $this->getGlobalData() );
        $object->setObjectName( $object_name );
        $object->setSettlementId( $settlement_id );
        $result = $object->insert();
        if ($result == RealEstateAgency_Const::ALREADY_SAVED) {
            $this->already_saved = true;
        }
    }
    
    /*
    input: object_id
    */
    private function delete() {
        RealEstateAgency_Object_Street::deleteById($this->getGlobalData(), $this->object_id);
    }

    
    private function loadData() {
        $globalData = $this->getGlobalData();
        $view = $globalData->getView();
        $filter = $this->filter;
        
        if ( ! $filter->isReady() ) {
            return;
        }
        
        $list_3 = new RealEstateAgency_Object_StreetList();
        $list_3->setGlobalData($globalData);
        
        if (! $filter->getSettlementId() ) {
            throw new Exception('List of streets. Incorrect settlement identifier.');
        }
        
        $list_3->setSettlementId($filter->getSettlementId());
        $list_3->loadBy();
        $view->list_of_streets = $list_3;
    }
}

