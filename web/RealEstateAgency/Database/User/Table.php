<?phprequire_once 'RealEstateAgency/Database/Base/Table.php';class RealEstateAgency_Database_User_Table extends RealEstateAgency_Database_Base_Table{    protected $_name = 'systemuser';    protected $_primary = 'user_reg_id';    protected $_sequence = true;    protected $_rowClass = 'RealEstateAgency_Database_User_Row';    protected $_rowsetClass = 'RealEstateAgency_Database_User_Rowset';}