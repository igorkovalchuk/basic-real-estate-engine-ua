<?php

require_once 'RealEstateAgency/Const.php';
require_once 'RealEstateAgency/Util.php';

require_once 'RealEstateAgency/Controller/Base.php';

require_once 'RealEstateAgency/Object/Event.php';

require_once 'Zend/Validate.php';
require_once 'Zend/Validate/Int.php';

class RealEstateAgency_Controller_Login extends RealEstateAgency_Controller_Base
{

    private $admin_page = false;
    private $login_in_progress = false;
    private $cookie_enabled = false;
    
    private $disconnect = false;
    
    private $logged = false;
    private $incorrect_login_message = true;
	private $incorrect_login_message_time = false;
    
    private $nick = '';
    private $keyword = '';
    
    private $user_id = '';
    
    private function setViewData() {
        $view = $this->getGlobalData()->getView();
        $view->logged = $this->logged;
		$view->logged_administrator = $this->isAdmin();
        $view->incorrect_login_message = $this->incorrect_login_message;
		$view->incorrect_login_message_time = $this->incorrect_login_message_time;
    }
    
    private function cleanView() {
    }
    
    // First method called by general controller;
    public function execute() {
        // Action;
        $this->getInput();
        $this->action();
        // This method should be called after commit transaction for show fresh data;
        $this->setViewData();
    }
    
    private function getInput() {
        // Fetch input values;
        
        // Case: administration page;
        if ( array_key_exists('page', $_REQUEST) && ($_REQUEST['page'] != '') ) {
            $page = $_REQUEST['page'];
            if ($page == 'admin') {
                $this->admin_page = true;
            }
        }
        
        if ( $this->admin_page ) {
            if ( RealEstateAgency_Util::isDefinedNonEmptyRequest('login') ) {
                // login in progress;
                $this->login_in_progress = true;
                if ( RealEstateAgency_Util::isDefinedNonEmptyRequest('nick') ) {
                    $this->nick = $_POST['nick'];
                }
                if ( RealEstateAgency_Util::isDefinedNonEmptyRequest('key') ) {
                    $this->keyword = $_POST['key'];
                }
            }
        }
        
        if ( RealEstateAgency_Util::isButton('disconnect') || tools_get_input('disconnect') ) {
            $this->disconnect = true;
        }
        
        if ( $this->login_in_progress ) {
            if ( array_key_exists('cookie_enabled', $_COOKIE) && ($_COOKIE['cookie_enabled'] != '') ) {
                $this->cookie_enabled = true;
            } else {
                $this->cookie_enabled = false;
            }
        }
        
    }
    
    private function action() {
        
        // set special cookie, for verify that cookies enabled or no;
        setcookie('cookie_enabled','1',time() + 60 * 60 * 24,'/');
        
        $this->incorrect_login_message = false;
        $this->logged = false;
        
        // echo ('session start1');
        session_name("SessionID");
        
        $difference = RealEstateAgency_Const::SESSION_TIMEOUT;
        // echo ('session start2: ' . session_id());

		if ( $this->login_in_progress ) {
			$errors = tools_log_get_number_of_errors_by_time($this->getGlobalData(), time() - 60 * 60);
			if ($errors > RealEstateAgency_Const::MAX_LOGIN_ATTEMPTS_FOR_ALL_USERS) {
				$this->incorrect_login_message_time = true;
				tools_log_warn($this->getGlobalData(), RealEstateAgency_Const::LOG_LOGIN_BLOCKED, "...");
				return;
			}
		}
		
        if ( $this->login_in_progress ) {
            if ( $this->verifyUser() ) {
                session_start();
                //session_set_cookie_params ( 15*1, '/' );
                $this->logged = true;
                $_SESSION['started'] = time();
                $_SESSION['logged'] = true;
                $_SESSION['user_id'] = $this->user_id;
                $_SESSION['updated'] = time();
                
                $_SESSION['stamp'] = $this->getClientSignature();
                
            } else {
                $this->incorrect_login_message = true;
				tools_log_error($this->getGlobalData(), RealEstateAgency_Const::LOG_INCORRECT_LOGIN, "...");
            }
        } else {
			// Upload the session if possible;

				session_start();
                // session_set_cookie_params ( 15*1, '/' );
                if ( RealEstateAgency_Util::getSessionVar('logged') ) {
                    if ( RealEstateAgency_Util::getSessionVar('updated') ) {
                        $time1 = RealEstateAgency_Util::getSessionVar('updated');
                        $time2 = time();
                        if ( ($time2 - $time1) > $difference ) {
                            $_SESSION['logged'] = false;
                        } else {
                            $_SESSION['updated'] = time();
                        }
                        
                        if ( $this->getClientSignature() != RealEstateAgency_Util::getSessionVar('stamp') ) {
                            // echo "<span style=\"color:red;\">"."Session corrupted !"."</span>";
                            $_SESSION['logged'] = false;
                        }
                    } else {
                        throw new Exception('Session was not updated.');
                    }
                }
                
//                $s_data = array();
//                $s_data = session_get_cookie_params();
// echo "Date: " . RealEstateAgency_Util::getUserDate(time())."<br />";
// echo "SESSION RELOADED <br />" .
//        "Lifetime " . $s_data['lifetime'] . "<br />" . 
//        "Started: " . RealEstateAgency_Util::getSessionVar('started') . "<br />" .
//        "Updated: " . RealEstateAgency_Util::getUserDate( RealEstateAgency_Util::getSessionVar('updated') ). "<br />" .
//        "<br />";
                
//                $_SESSION['time'] = time();
                if ($this->disconnect) {
                    $_SESSION['logged'] = false;
                    session_unset();
                    $this->logged = false;
                } else {
                    if ( array_key_exists('logged', $_SESSION) && ($_SESSION['logged'] != '') ) {
                        $this->logged = true;
                    }
                }

		}
        
        // if ( $this->logged && ( ! $_SESSION['cookie_enabled'] ) ) {
           // $timeout = $_SESSION['id_timeout'];
           // $timeout++;
            // if ($timeout == 3) {
               // $timeout = 1;
               // session_regenerate_id();
            // }
            // $_SESSION['id_timeout'] = $timeout;
        // }

    }
    
    
    
    private function verifyUser() {
        
        $globalData = $this->getGlobalData();
        $db = $globalData->takeConnection();
        
		$nick = $this->nick;
		if ( ($nick == NULL) || (strlen($nick) > 50) ) {
			$nick = '1';
		}
		
		$key = $this->keyword;
		if ( ($key == NULL) || (strlen($key) > 50) ) {
			$key = '1';
		}
		
		$key_sha1 = sha1($key);
		
        $where = $db->quoteInto('login_name = ?', $nick);
        $select = $db->select()->from('users')->where($where);
        $stmt = $db->query($select);
        $result = $stmt->fetchAll();
        
        $user = current($result);
        if ($user) {
            $password = $user['password'];
            if ($password == $key_sha1) {
                $this->user_id = $user['user_reg_id'];
                return true;
            }
        }
        return false;
    }
    
    public function isLogged() {
        return $this->logged;
    }
    
    public function getLoggedUserID() {
		if (! isset($_SESSION)) {
			return NULL;
		}
        if (tools_get_session_var('logged')) {
            return tools_get_session_var('user_id');
        } else {
            return NULL;
        }
    }
    
	public function isAdmin() {
		if (! isset($_SESSION)) {
			return false;
		}
		if (tools_get_session_var('logged')) {
            $id = tools_get_session_var('user_id');
			if (1 == $id) {
				return true;
			}
		}
		return false;
	}
	
    private function getClientSignature() {
        if ( ! isset($_SERVER) ) {
            return '';
        }
        $attribute = RealEstateAgency_Util::getSessionVar('started');
        
        $str = 'Stamp is: ' . $attribute .';';
        if ( isset( $_SERVER['HTTP_ACCEPT'] ) ) {
            $str .= $_SERVER['HTTP_ACCEPT'].';';
        }
        // if ( isset( $_SERVER['HTTP_ACCEPT_LANGUAGE'] ) ) {
            // $str .= $_SERVER['HTTP_ACCEPT_LANGUAGE'];
        // }
        if ( isset( $_SERVER['HTTP_ACCEPT_ENCODING'] ) ) {
            $str .= $_SERVER['HTTP_ACCEPT_ENCODING'].';';
        }
        if ( isset( $_SERVER['HTTP_USER_AGENT'] ) ) {
            $str .= $_SERVER['HTTP_USER_AGENT'].';';
        }
        return md5($str);
        // HTTP_ACCEPT
        // HTTP_ACCEPT_LANGUAGE
        // HTTP_ACCEPT_ENCODING
        // HTTP_USER_AGENT
    }
    
}

