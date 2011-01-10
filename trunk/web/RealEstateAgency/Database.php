<?php
require_once 'Zend/Db.php';
require_once 'Zend/Registry.php';
require_once 'RealEstateAgency/Const.php';
require_once 'RealEstateAgency/ConstDatabase.php';

class RealEstateAgency_Database
{

    static private $enable_profiler = false;
    static private $profiler = NULL;
    
    public function createConnection() {

        $params = array (
            'host'     => RealEstateAgency_ConstDatabase::SERVER,
            'username' => RealEstateAgency_ConstDatabase::NAME,
            'password' => RealEstateAgency_ConstDatabase::KEY,
            'dbname'   => RealEstateAgency_ConstDatabase::DB);

        $db = Zend_Db::factory('PDO_MYSQL', $params);
        // Zend_Registry::set(RealEstateAgency_Const::getAdapterName(), $db);
        
        // $db->query("SET NAMES cp1251 COLLATE cp1251_ukrainian_ci");
        // $db->query("SET NAMES cp1251");
        $db->query("SET CHARACTER SET cp1251");
        // $db->query("SET CHARACTER SET cp1251 COLLATE cp1251_ukrainian_ci");
        
        if ( self::$enable_profiler ) {
            // echo 'PROFILER IS ON <br />';
            $prof = $db->getProfiler();
            $prof->setEnabled(true);
            self::$profiler = $prof;
        } else {
            // echo 'PROFILER IS OFF <br />';
        }
        
        return $db;
    }
    
    static function initializeProfiler() {
        self::$enable_profiler = true;
    }
    
    static function getProfiler() {
        if (self::$enable_profiler) {
            return self::$profiler;
        } else {
            return NULL;
        }
    }

}
