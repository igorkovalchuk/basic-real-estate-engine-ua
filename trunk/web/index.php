<?php

ob_start(); // appropriate ob_end_flush() function called after that we set session cookie;
// Set locale;
setlocale(LC_ALL, 'Ukrainian_Ukraine.1251');

require("RealEstateAgency/template/header_1.php");
require_once 'RealEstateAgency/Actions.php';
RealEstateAgency_Actions::execute();