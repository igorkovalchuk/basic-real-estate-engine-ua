<?php
require_once 'Zend/Loader.php';
require_once 'RealEstateAgency/Const.php';
require_once 'RealEstateAgency/GlobalData.php';

require_once 'RealEstateAgency/Object/Counters.php';

class RealEstateAgency_Actions
{    
    
    static public function execute() {
        
        try {
            $globalData = new RealEstateAgency_GlobalData();
            RealEstateAgency_Actions::execute_really($globalData);
        } catch (Exception $ex) {
            session_unset();
            Zend_Loader::loadClass('Zend_View');
            $view = new Zend_View();
            $view->setScriptPath(RealEstateAgency_Const::PATH_TEMPLATE);
            $view->page_error_message = $ex->getMessage();
            echo $view->render('error.php');
        }
    }
    
    static private function execute_really($globalData) {
        
        $login_necessary = false;
        
        Zend_Loader::loadClass('Zend_View');
        $view = new Zend_View();
        $view->setScriptPath(RealEstateAgency_Const::PATH_TEMPLATE);
        
        $globalData->initialize();
        $globalData->setView($view);

        require_once 'RealEstateAgency/Controller/Login.php';
        $loginObject = new RealEstateAgency_Controller_Login();
        $loginObject->setGlobalData($globalData);
        $loginObject->execute();
        
        $logged = $loginObject->isLogged();
		$isAdmin = $loginObject->isAdmin();
        
        $globalData->setLoginObject($loginObject);
		
		$object_counters = new RealEstateAgency_Object_Counters();
		if( ! tools_get_input("remote") ) {
			$object_counters->loadCounters($globalData); // load data and put it in the View.
		}

		$defaultPage = false;

        if ( RealEstateAgency_Util::isDefinedNonEmptyRequest('page') ) {
            $page = $_REQUEST['page'];
            
			if ($page == 'admin') {
				// Login/Logoff page;
                echo $view->render('admin.php');
            } else if (
                        (RealEstateAgency_Const::TYPE_FLAT == $page) ||
                        (RealEstateAgency_Const::TYPE_ROOM == $page) ||
                        (RealEstateAgency_Const::TYPE_HOUSE == $page) ||
                        (RealEstateAgency_Const::TYPE_COTTAGE == $page) ||
						(RealEstateAgency_Const::TYPE_COMMERCIAL == $page) ||
						(RealEstateAgency_Const::TYPE_LAND == $page)

                        ) {
                // Flats/Rooms/Houses/Commercial page;
                require_once 'RealEstateAgency/Controller/ForSearch.php';
                $object = new RealEstateAgency_Controller_ForSearch();
                $globalData->setPageName('search');
                $object->setGlobalData($globalData);
                $object->execute($page);
                echo $view->render('search.php');
			} else if ($page == 'image') {
				$view->object_id = tools_get_input('object_id');
				echo $view->render('images.php');
			} else if ($page == 'delete') {
				if ($logged) {
					$view->object_id = tools_get_input('object_id');
					$view->really = tools_get_input('really');
					$view->global_data = $globalData;
					echo $view->render('delete.php');
				} else {
					$login_necessary = true;
				}
			} else if ($page == 'update') {
				// Update real estate object;
				if ($logged) {
					require_once 'RealEstateAgency/Controller/ForUpdate.php';
					$object = new RealEstateAgency_Controller_ForUpdate();
					$globalData->setPageName('update');
					$object->setGlobalData($globalData);
					$object->execute();
					echo $view->render('update.php');
				} else {
					$login_necessary = true;
				}
            } else if ($page == 'area') {
                // Area;
                if ($isAdmin) {
                    require_once 'RealEstateAgency/Controller/ForArea.php';
                    $object = new RealEstateAgency_Controller_ForArea();
                    $globalData->setPageName('area');
                    $object->setGlobalData($globalData);
                    $object->execute();
                    echo $view->render('area.php');
                } else {
                    $login_necessary = true;
                }
            } else if ($page == 'district') {
                // District;
                if ($isAdmin) {
                    require_once 'RealEstateAgency/Controller/ForDistrict.php';
                    $object = new RealEstateAgency_Controller_ForDistrict();
                    $globalData->setPageName('district');
                    $object->setGlobalData($globalData);
                    $object->execute();
                    echo $view->render('district.php');
                } else {
                    $login_necessary = true;
                }
            } else if ($page == 'settl') {
                // Settlement;
                if ($isAdmin) {
                    require_once 'RealEstateAgency/Controller/ForSettlement.php';
                    $object = new RealEstateAgency_Controller_ForSettlement();
                    $globalData->setPageName('settl');
                    $object->setGlobalData($globalData);
                    $object->execute();
                    echo $view->render('settl.php');
                } else {
                    $login_necessary = true;
                }
            } else if ($page == 'settl_part') {
                // Settlement part;
                if ($isAdmin) {
                    require_once 'RealEstateAgency/Controller/ForSettlementPart.php';
                    $object = new RealEstateAgency_Controller_ForSettlementPart();
                    $globalData->setPageName('settl_part');
                    $object->setGlobalData($globalData);
                    $object->execute();
                    echo $view->render('settl_part.php');
                } else {
                    $login_necessary = true;
                }
            } else if (
                ($page == 'object') 
            ) {
				// New real estate object;
                if ($logged) {
					require_once 'RealEstateAgency/Controller/ForObject.php';
					$object = new RealEstateAgency_Controller_ForObject();
					$globalData->setPageName('object_city');
					$object->setGlobalData($globalData);
					$object->execute();
					echo $view->render('object_city.php');
				} else {
					$login_necessary = true;
				}
            } else {
                // Default;
                $defaultPage = true;
            }
        } else {
            // Default;
            $defaultPage = true;
        }
        
		if ($login_necessary) {
			$defaultPage = true;
        }
		
        if ($defaultPage) {
			require_once 'RealEstateAgency/Controller/ForSearch.php';
			$object = new RealEstateAgency_Controller_ForSearch();
			$globalData->setPageName('search');
			$object->setGlobalData($globalData);
			$object->execute('flat');
			echo $view->render('search.php');
        }
        
    }
    
	private function generateDefaultPage() {
		require_once 'RealEstateAgency/Controller/ForSearch.php';
		$object = new RealEstateAgency_Controller_ForSearch();
		$globalData->setPageName('search');
		$object->setGlobalData($globalData);
		$object->execute('flat');
		$content1 = $view->render('header_1.php');
		$content2 = $view->render('search.php');
		
	}
	
}
