<?php

// require_once 'RealEstateAgency/Const.php';
class RealEstateAgency_Const
{

    const OK = 0;
    const ALREADY_SAVED = 2;
    const NOTHING = 4; // nothing was done, because some data was incorrect, e.t.c.

	# Enable or disable expensive database operations.
	const FROZEN = 0;

	const URL = "http://localhost/anm/";
	# const URL = "http://10.100.100.30/test/";
	
    const PATH_TEMPLATE = 'c:/Projects/agency/RealEstateAgency/template'; // Attention: locally defined path !
	
	const UPLOAD_IMAGES_DIR = 'c:/Projects/agency/uploads/';
	const MAX_FILE_SIZE = 100000; // Image upload limit;
	const MAX_IMAGES = 9;
	
    const SESSION_TIMEOUT = 900; // 15 min;
    
	const OBJECTS_ON_PAGE = 25;
	const SEARCH_PERIOD = 31;
	const SEARCH_PERIOD_MAX = 31;
	
    const FILTER_AREA = 1;
    const FILTER_DISTRICT = 2;
    const FILTER_SETTLEMENT = 4;
    const FILTER_PART = 8;
    
    const MAIN_SETTLEMENT_ID = 5;
	
	
	
	const TYPE_FLAT = 'flat';
	const TYPE_FLAT_NUMBER = 1;
	const TYPE_ROOM = 'room';
	const TYPE_ROOM_NUMBER = 2;
	const TYPE_HOUSE = 'house';
	const TYPE_HOUSE_NUMBER = 3;
	const TYPE_COTTAGE = 'cottage';
	const TYPE_COTTAGE_NUMBER = 4;
	const TYPE_COMMERCIAL = 'commercial';
	const TYPE_COMMERCIAL_NUMBER = 5;
	const TYPE_LAND = 'land';
	const TYPE_LAND_NUMBER = 6;
	
	const LOG_ERROR = 0;
	const LOG_WARN = 1;
	const LOG_INFO = 2;
	const LOG_DEBUG = 3;
	
	const MAX_LOGIN_ATTEMPTS_FOR_ALL_USERS = 10; // per one hour;
	
	const LOG_INCORRECT_LOGIN = 'login failed';
	const LOG_LOGIN_BLOCKED = 'login blocked';
	
    // static public function getAdapterName() {
       // return 'RealEstateAgency_its_database';
    // }

    // static public function getCacheName() {
       // return 'RealEstateAgency_its_db_cache';
    // }

}