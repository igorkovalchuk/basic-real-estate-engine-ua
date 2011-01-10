<?php

require_once 'Zend/Validate/Float.php';

class RealEstateAgency_Util
{
    
    static function printTestString($str) {
        // echo "<br /><i>$str</i><br />\n";
    }
    
    // RealEstateAgency_Util::isDefinedNonEmptyRequest()
    static function isDefinedNonEmptyRequest($str) {
        if ( array_key_exists($str, $_REQUEST) && ($_REQUEST[$str] != '') ) {
            return true;
        } else {
            return false;
        }
    }
    
    // RealEstateAgency_Util::isButton()
    static function isButton($str) {
        if ( array_key_exists($str, $_POST) ) {
            return true;
        } else {
            return false;
        }
    }
    
	static function url(array $data) {
		return RealEstateAgency_Util::urlOfScript($data, 'index');
	}
	
    // RealEstateAgency_Util::url(array())
    static function urlOfScript(array $data, $script) {
        $prefix = RealEstateAgency_Const::URL . $script . '.php?';
        $str = '';
        $first = true;
        
        $session_id = session_id();
        if ($session_id) {
            if ( array_key_exists('cookie_enabled', $_COOKIE) && ($_COOKIE['cookie_enabled'] != '') ) {
                // we do not need changes in url for session id;
            } else {
                $data['SessionID'] = $session_id;
            }
        }
        
        foreach ($data as $key => $value) {
            if ($first) {
                $first = false;
            } else {
                $str .= '&';
            }
            $str .= $key . '=' . urlencode($value);
        }
        
        $str = htmlentities($str, ENT_QUOTES, 'cp1251');
        
        return $prefix . $str;
    }
    
    // RealEstateAgency_Util::startTag_a(array(), array())
    // $data - key/value pairs for build href;
    // $attr - html attributes as key/value;
    static function startTag_a(array $data, array $attr) {
        $str = '';
        $url = RealEstateAgency_Util::url($data);
        $str = '<a href="' . $url . '"';
        foreach ($attr as $key => $value) {
            $str .= ' ' . $key . '="' . $value . '"';
        }
        $str .= '>';
        return $str;
    }
    
    static function endTag_a() {
        return '</a>';
    }
    
    /**
     * data - a hash with keys: 'id', 'name'
     *
     * Note: please do not use NULL for css strings;
     */
    static function htmlSelect($select_name, $css_for_select, array $data, $selected_id, $default_string, $css_for_option) {
        if ( $css_for_select != '' ) {
            $css_for_select = ' ' . $css_for_select . ' ';
        }
        if ( $css_for_option != '' ) {
            $css_for_option = ' ' . $css_for_option . ' ';
        }
        $list = '';
        $found = false;
        foreach ($data as $index => $hash) {
            $id = $hash['id'];
            $name = $hash['name'];
            $list .= '<option value="' . htmlspecialchars($id) . '" ';
            if ($selected_id == $id) {
                $list .= 'selected="selected"';
                $found = true;
            }
            $list .= $css_for_option;
            $list .= '>' . htmlspecialchars($name) . '</option>'."\n";
        }
        $first = '';
        if ( ($default_string != NULL) && ($default_string != '') ) {
            $first .= '<option value="" ';
            if ( ! $found ) {
                $first .= 'selected="selected"';
            }
            $first .= '>' . htmlspecialchars($default_string) . '</option>'."\n";
        }
        $select1 = '<select name="'.$select_name.'"' . $css_for_select . '>' . "\n";
        $select2 = "</select>\n";
        return $select1.$first.$list.$select2;
    }
    
    // RealEstateAgency_Util::setSessionVar($var_name, $var_value)
    static function setSessionVar($var_name, $var_value) {
        if (is_array($_SESSION)) {
            $_SESSION[$var_name] = $var_value;
        } else {
            throw new Exception('can not set session variable, because no session');
        }
    }
    
    // RealEstateAgency_Util::getSessionVar($var_name)
    static function getSessionVar($var_name) {
        if (is_array($_SESSION)) {
            if ( array_key_exists($var_name, $_SESSION) ) {
                return $_SESSION[$var_name];
            } else {
                return NULL;
            }
        } else {
            throw new Exception('can not get session variable, because no session');
        }
    }
    
    // RealEstateAgency_Util::getUserDate($timestamp)
    static function getUserDate($time) {
        if (! $time) {
            $time = 0;
        }
        // var_dump( setlocale(LC_ALL, 'Ukrainian_Ukraine') );
        $date = ( strftime("%A, %d.%m.%Y, %H:%M:%S", $time) );
        // $date = iconv( 'WINDOWS-1251', 'UTF-8', $date );
        return $date;
    }
    
    // RealEstateAgency_Util::dateToDatabase($timestamp)
    // Input: unix timestamp. Return string like: 2007-01-01 00:00:00
    static function dateToDatabase($timestamp) {
        if (! $timestamp) {
            $timestamp = 0;
        }
        $date = ( strftime("%Y-%m-%d %H:%M:%S", $timestamp) );
        return $date;
    }
    
    static function databaseToDate($str) {
        if (! $str) {
            return 0;
        }
        if (strlen($str) != 19) {
            throw new Exception('Can not get date from the database: ['.$str.']');
        }
        $year = (int) substr($str, 0, 4); // YYYY
        $mon = (int) substr($str, 5, 2); // MM
        $day = (int) substr($str, 8, 2); // DD
        $hour = (int) substr($str, 11, 2); // HH
        $min = (int) substr($str, 14, 2); // MM
        $sec = (int) substr($str, 17, 2); // SS

        $date = mktime ($hour, $min, $sec, $mon, $day, $year);

        if ( ($date == false) || ($date < 0) ) {
            throw new Exception('Can not get date from the database value ['.$str.']');
        }
        return $date;
    }
    
}

function tools_verify_int($value) {
    $validatorChain = new Zend_Validate();
    $validatorChain->addValidator( new Zend_Validate_Int() );
    if ($validatorChain->isValid($value)) {
        return true;      
    }
    return false;
}

function tools_verify_positive_int($value) {
    $validatorChain = new Zend_Validate();
    $validatorChain->addValidator( new Zend_Validate_Int() );
    if ($validatorChain->isValid($value)) {
        if ($value >= 0) {
			return true;
		}
    }
    return false;
}

// New version doesn't allow negative values.
// Old version still doesn't allow 01 or 01.10 or 10. or 10.0 etc.
function tools_verify_float($value) {
    //$validatorChain = new Zend_Validate();
    //$validatorChain->addValidator( new Zend_Validate_Float() );
    //if ($validatorChain->isValid($value)) {
        //return true;
    //}
    //return false;
	
    $value = trim($value);
    // $value1 = str_replace(',', '.', $value);
	
	$check = str_replace(',', '.', $value);
	
	if (strcmp($check, "") == 0) {
		return false;
	}
	
	if (strcmp($check, ".") == 0) {
		return false;
	}
	
	$check = strtr($check, "0123456789", "          ");
	$check = trim($check);
	
	if (strcmp($check, "") == 0) {
		return true;
	}
	
	if (strcmp($check, ".") == 0) {
		return true;
	}
	
	return false;
	
	/*
	
    $value2 = strval(floatval($value1));
	
    $value2=  str_replace(',', '.', $value2);
    if (strcmp($value1,$value2) == 0) {
        return true;
    } else {
        return false;
    }
	
	*/
}

function tools_database2date($value) {
    return RealEstateAgency_Util::databaseToDate($value);
}

function tools_date2database($value) {
    return RealEstateAgency_Util::dateToDatabase($value);
}

function tools_url(array $data) {
    return RealEstateAgency_Util::url($data);
}

/**
 * Get parameter from $_REQUEST, if any;
 * Return NULL, if none
 */
function tools_get_input($name) {
    if ( array_key_exists($name, $_REQUEST) ) {
        $result = $_REQUEST[$name];
        $result = trim($result);
        if ($result == '') {
            return NULL;
        }
        return $result;
    } else {
        return NULL;
    }
}

function tools_is_button($name) {
    return RealEstateAgency_Util::isButton($name);
}

function tools_startTag_a(array $data, array $attr) {
    return RealEstateAgency_Util::startTag_a($data, $attr);
}

function tools_endTag_a() {
    return RealEstateAgency_Util::endTag_a();
}

function tools_validation_error($parameter,$array) {
    if ($array == NULL) {
        return '';
    }
    if ( array_key_exists($parameter, $array) ) {
        return tools_validation_error_string($parameter, $array[$parameter]);
    } else {
        return '';
    }
}

function tools_validation_error_string($parameter, $string) {
    if ( ($string == NULL) || ($string == '') ) {
        return '';
    }
	$id = "v_e_" . $parameter;
	
    return "&nbsp;<b><span style=\"color:red;\">" . $string . "</span></b>" .
			"<input type=\"hidden\" name=\"" . $id . "\" value=\"error\" />";
}

function tools_get_session_var($var_name) {
    return RealEstateAgency_Util::getSessionVar($var_name);
}

/**
 * Get a filename extension.
 */
function tools_get_ext($filename) {
	$basename = basename($filename);
	if ( ($basename == NULL) || ($basename == '') ) {
		return '';
	}
	$pos = strrpos ($basename, '.');
	if ( ($pos === false) || ($pos == 0) ) {
		return '';
	}
	$result = substr($basename, $pos);
	if (strlen($result) <= 1) {
		return '';
	}
	$result = substr($result, 1);
	return $result;
}

function tools_is_allowable_ext($ext) {
	if ( ('jpeg' == $ext) || ('jpg' == $ext) || ('png' == $ext) || ('gif' == $ext) ) {
		return true;
	}
	return false;
}

function tools_get_allowable_ext_string() {
	return 'jpeg, jpg, png, gif';
}


function tools_image_url($name) {
        $data = array('name' => $name);
		return RealEstateAgency_Util::urlOfScript($data, 'showimage');
}

function tools_get_search_city_districts() {
	$data = array(
		0 => array('id'=>0, 'name'=>'...'),
		1 => array('id'=>1, 'name'=>'Голосіївський'),
		2 => array('id'=>2, 'name'=>'Дарницький'),
		3 => array('id'=>3, 'name'=>'Деснянський'),
		4 => array('id'=>4, 'name'=>'Дніпровський'),
		5 => array('id'=>5, 'name'=>'Оболонський'),
		6 => array('id'=>6, 'name'=>'Печерський'),
		7 => array('id'=>7, 'name'=>'Подольский'),
		8 => array('id'=>8, 'name'=>'Святошиньский'),
		9 => array('id'=>9, 'name'=>'Соломеньский'),
		10 => array('id'=>10, 'name'=>'Шевченківський')
	);
	return $data;
}

