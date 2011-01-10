<?php

require_once 'RealEstateAgency/TestUtil.php';

class RealEstateAgency_Test
{

    static public function test() {
        
        RealEstateAgency_TestUtil::useProfiler();
        
        // require_once 'some file for test';
        
        RealEstateAgency_TestUtil::printProfilerData();
    }

}

RealEstateAgency_Test::test();
