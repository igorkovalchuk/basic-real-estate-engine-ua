<?php

require_once 'RealEstateAgency/Const.php';
require_once 'RealEstateAgency/Util.php';


class RealEstateAgency_Object_Counters
{

	/**
	 * 1. Get counters from the database.
	 * 2. Store/cache it in the Session.
	 * 3. Every 3 minutes refresh these counters from the database.
	 * Note: we don't put globalData in properties because of circular variables (globalData->getView())  - we use this object directly on page/view.
	 */
	public function loadCounters($globalData) {

		if (RealEstateAgency_Const::FROZEN) {
			return;
		}

		$counters = $globalData->getViewVariable('counters');
		if ($counters) {
			// Refresh or not;
			$counters_time = $globalData->getViewVariable('counters_time');
			if ( (time() - $counters_time) > 180 ) {
				$this->load($globalData);
			} else {
				$globalData->getView()->counters = $counters;
			}
		} else {
			// Load from the database;
			$this->load($globalData);
		}
	}
    
	private function load($globalData) {
		$db = $globalData->takeConnection();
		// mysql> select op_type, type, count(*) counter from r_e_object group by type;
		// +---------+------+----------+
		// | op_type | type | counter |
		// +---------+------+----------+
		// |       0 |    1 |      135 |
		// |       0 |    3 |        1 |
		// +---------+------+----------+

		$period = RealEstateAgency_Const::SEARCH_PERIOD_MAX;
		$current_time = time();
		$current_time -= $period * 24 * 60 * 60;
		$current_time = tools_date2database($current_time);

		$stmt = $db->query('SELECT op_type operation, type, count(*) counter from r_e_object where updated >= \'' . $current_time . '\' group by operation, type');
		$counters = $stmt->fetchAll();
		$globalData->setViewVariable('counters', $counters);
		$globalData->setViewVariable('counters_time', time());
	}


	public static function getCounter($counters, $operation_type, $real_estate_type) {

		if (! $counters) {
			return '';
		}

		foreach ($counters as $index => $array) {
				$operation = $array['operation'];
				if ( strcmp($operation, $operation_type) == 0 ) {
					$type = $array['type'];
					if ( strcmp($type, $real_estate_type) == 0 ) {
						$counter = $array['counter'];
						return "(" . $counter . ")";
					}
				}
		}
		return '';
	}

}