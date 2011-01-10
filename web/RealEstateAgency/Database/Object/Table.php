<?php
require_once 'RealEstateAgency/Database/Base/Table.php';
class RealEstateAgency_Database_Object_Table extends RealEstateAgency_Database_Base_Table
{
    protected $_name = 'r_e_object';
    protected $_primary = 'obj_id';
    protected $_sequence = true;
    protected $_rowClass = 'RealEstateAgency_Database_Object_Row';
    protected $_rowsetClass = 'RealEstateAgency_Database_Object_Rowset';
}

