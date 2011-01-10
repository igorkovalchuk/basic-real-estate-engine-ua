<?php

require_once 'RealEstateAgency/Database.php';

class RealEstateAgency_TestUtil
{

	static private $start_time = NULL;

    static public function useProfiler() {
        RealEstateAgency_Database::initializeProfiler();
		self::$start_time = microtime(1);
    }
    
    static public function printVerificationData() {
        $str = '';
		$str .= ". . . . . . . . . . . . . . . . . . . .";
		$str .= '<br />' . "\n" . "Duration: ";
		$str .= microtime(1) - self::$start_time;
		$str .= '<br />' . "\n";
        if (isset($_SESSION)) {
            $str .= RealEstateAgency_TestUtil::hash2string($_SESSION, 'Session');
        }
        if (isset($_COOKIE)) {
            $str .= RealEstateAgency_TestUtil::hash2string($_COOKIE, 'Cookies');
        }
        if (isset($_GET)) {
            $str .= RealEstateAgency_TestUtil::hash2string($_GET, 'Get data');
        }
        if (isset($_POST)) {
            $str .= RealEstateAgency_TestUtil::hash2string($_POST, 'Post data');
        }
        if (isset($_SERVER)) {
            // $str .= RealEstateAgency_TestUtil::hash2string($_SERVER, 'Server');
        }
        echo $str;
    }
    
    static private function hash2string(array $data, $name) {
        // if (! isset($data) ) {
           // return '';
        // }
        $line = ". . . . . . . . . . . . . . . . . . . .";
        $str = '';
        $str .= $line . '<br />' . "\n";
        $str .= $name . ': ' . '<br />'. "\n";
        foreach ($data as $key => $value) {
            $str .= $key . ' = ' . $value . '<br />' . "\n";
        }
        $str .= $line . '<br />' . "\n";
        return $str;
    }
    
    static public function printProfilerData() {
        $profiler = RealEstateAgency_Database::getProfiler();
        
        if (! $profiler) {
            return;
        }
        
        $line = ". . . . . . . . . . . . . . . . . . . .";
        echo "$line\n";
        echo "Database profiler information:\n";
        $totalTime    = $profiler->getTotalElapsedSecs();
        $queryCount   = $profiler->getTotalNumQueries();
        $longestTime  = 0;
        $longestQuery = null;
        foreach ($profiler->getQueryProfiles() as $query) {
            // echo "Query: [" . $query->getQuery() . "]\n";
            if ($query->getElapsedSecs() > $longestTime) {
                $longestTime  = $query->getElapsedSecs();
                $longestQuery = $query->getQuery();
            }
        }
        // echo "$line\n";
        echo 'Executed ' . $queryCount . ' queries in ' . $totalTime . ' seconds' . "\n";
        // echo 'Average query length: ' . $totalTime / $queryCount . ' seconds' . "\n";
        // echo 'Queries per second: ' . $queryCount / $totalTime . "\n";
        echo 'Longest query length: ' . $longestTime . "\n";
        // echo "Longest query: " . $longestQuery . "\n";
        echo "$line\n";
    }

}
