<?php

require_once 'RealEstateAgency/Database.php';
require_once 'RealEstateAgency/Object/Cache.php';

class RealEstateAgency_GlobalData
{
    
    private $view = NULL;
    
    private $db = NULL; // database connection;
    
    private $cache = NULL; // internal object for cache;
    
    private $pageName = ''; // name of the current web page, for keep difference for php-session parameters;
    
    private $loginObject = NULL;
    
    public function initialize() {
        
    }
    
    private function startConnection() {
        $this->db = RealEstateAgency_Database::createConnection();
    }
    
    public function takeConnection() {
        if ( ! $this->db ) {
            $this->startConnection();
        }
        return $this->db;
    }
    
    public function setView($view) {
        $this->view = $view;
    }
    
    public function getView() {
        return $this->view;
    }
    
    public function getCache() {
        if ( ! $this->cache) {
            $this->cache = new RealEstateAgency_Object_Cache();
        }
        $result = $this->cache;
        return $result;
    }
    
    // Name of variable - especially for store in session for different web-pages;
    private function getVariableName($var_name_1, $page) {
        $var_name_2 = NULL;
        if ($page) {
            $var_name_2 = 'page_' . $page .'_'.$var_name_1;
        } else {
            $var_name_2 = 'page_' . 'default' .'_'.$var_name_1;
        }
        return $var_name_2;
    }
    
    public function setViewVariable($var_name_1, $var_value, $page = '') {
        $view = $this->getView();
        $var_name_2 = $this->getVariableName($var_name_1, $page);
        $view->$var_name_1 = $var_value;
        if ( isset($_SESSION) ) {
            $_SESSION[$var_name_2] = $var_value;
        }
    }

    public function isDefinedViewVariable($var_name_1, $page = '') {
        // 1) Request;
        // 2) Session;
        $value = false;
        $var_name_2 = $this->getVariableName($var_name_1, $page);
        
        if ( array_key_exists($var_name_1, $_REQUEST) ) {
            $value = true;
        } else if ($_SESSION) {
            if ( array_key_exists($var_name_2, $_SESSION) ) {
                $value = true;
            }
        }
        return $value;
    }

    public function getViewVariable($var_name_1, $page = '') {
        // 1) Request;
        // 2) Session;
        $value = NULL;
        $var_name_2 = $this->getVariableName($var_name_1, $page);
        
        if ( array_key_exists($var_name_1, $_REQUEST) ) {
            $value = $_REQUEST[$var_name_1];
        } else if (isset($_SESSION)) {
            if ( array_key_exists($var_name_2, $_SESSION) ) {
                $value = $_SESSION[$var_name_2];
            }
        }
        return $value;
    }

    public function setPageName($value) {
        $this->pageName = $value;
    }
    
    public function getPageName() {
        return $this->pageName;
    }

    public function setLoginObject($object) {
        $this->loginObject = $object;
    }
    
    public function getLoginObject() {
        return $this->loginObject;
    }

}
