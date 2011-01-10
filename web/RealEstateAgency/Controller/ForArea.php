<?php

require_once 'RealEstateAgency/Const.php';
require_once 'RealEstateAgency/Util.php';

require_once 'RealEstateAgency/Object/AreaList.php';

require_once 'RealEstateAgency/Controller/Base.php';

require_once 'Zend/Validate.php';
require_once 'Zend/Validate/Int.php';

/*
Page have two modes: list(i.e. empty string), edit;
empty string - default state and after insert, update, delete;
edit - only after use 'edit' link;

Object may have such actions: new, update, delete, edit;

*/
class RealEstateAgency_Controller_ForArea extends RealEstateAgency_Controller_Base
{
    
    private $object_id = '';
    private $object_name = '';
    private $object_action = '';
    private $page_mode = '';
    private $data_as_list = NULL;
    private $already_saved = false;
    
    private function setViewData() {
        $view = $this->getGlobalData()->getView();
        $view->object_id = $this->object_id;
        $view->object_name = $this->object_name;
        $view->object_action = $this->object_action;
        $view->page_mode = $this->page_mode;
        $view->data_as_list = $this->data_as_list;
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
        $this->getInput();
        $this->action();
        // This method should be called after commit transaction for show fresh data;
        $this->data_as_list = $this->getList();
        $this->setViewData();
    }
    
    private function getInput() {
        // Fetch input values;
        if ( RealEstateAgency_Util::isDefinedNonEmptyRequest('object_name') ) {
            $object_name = $_REQUEST['object_name'];
            $object_name = trim($object_name);
            $this->object_name = $object_name;
        }
        if ( RealEstateAgency_Util::isDefinedNonEmptyRequest('object_id') ) {
            $this->object_id = $_REQUEST['object_id'];
        }
        if ( RealEstateAgency_Util::isDefinedNonEmptyRequest('object_action') ) {
            $this->object_action = $_REQUEST['object_action'];
        }
    }
    
    private function action() {
        
        $object_name = $this->object_name;
        $object_action = $this->object_action;
        
        // Choose action;
        if ( $object_action == 'new' ) {
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
        
        $object = RealEstateAgency_Object_Area::loadById($this->getGlobalData(), $this->object_id);
        if ($object) {
            $this->object_id = $object->getId();
            $this->object_name = $object->getObjectName();
            $this->page_mode = 'edit'; // set other action now;
        }
    }
    
    /*
    input: object_id, object_name
    */
    private function update() {
        $area = new RealEstateAgency_Object_Area();
        $area->setGlobalData( $this->getGlobalData() );
        $area->setId( $this->object_id );
        $area->setObjectName( $this->object_name );
        $area->update();
    }
    
    /*
    input: object_name
    */
    private function insert() {
        $object_name = $this->object_name;
        $area = new RealEstateAgency_Object_Area();
        $area->setGlobalData( $this->getGlobalData() );
        $area->setObjectName( $object_name );
        $result = $area->insert();
        if ($result == RealEstateAgency_Const::ALREADY_SAVED) {
            $this->already_saved = true;
        }
    }
    
    /*
    input: object_id
    */
    private function delete() {
        RealEstateAgency_Object_Area::deleteById($this->getGlobalData(), $this->object_id);
    }
    
    private function getList() {
        $objectsList = new RealEstateAgency_Object_AreaList();
        $objectsList->setGlobalData($this->getGlobalData());
        $objectsList->load();
        
        return $objectsList;
    }
}

