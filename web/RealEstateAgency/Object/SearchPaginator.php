<?php

require_once 'RealEstateAgency/Const.php';
require_once 'RealEstateAgency/Util.php';


class RealEstateAgency_Object_SearchPaginator
{

	public static function drawPaginator($search_counter, $url_parameters, $data_as_list_count) {

		$objects = RealEstateAgency_Const::OBJECTS_ON_PAGE;
		
		$navigation = "";

		if ($objects >= $search_counter) {
			return ""; // no paginator;
		}

		$search_position = $url_parameters[search_position];
		$pages = floor( ( $search_counter + $objects ) / $objects );
		$page = floor( $search_position / $objects ); // first page = 0;

		//echo ("((( {" . $search_position . "} " . $pages . " " . $page . ")))");

		$numbers = array(
			$page - 100,
			$page - 50,
			$page - 10,
			$page - 2,
			$page - 1,
			$page,
			$page + 1,
			$page + 2,
			$page + 10,
			$page + 50,
			$page + 100
		);

		$max = 0;
		$min = $pages - 1;
		foreach ($numbers as $i => $value) {
			if ( ($value < 0) || ($value >= $pages) ) {
				$numbers[$i] = NULL;
			} else {
				if ($max < $value) {
					$max = $value;
				}
				if ($min > $value) {
					$min = $value;
				}
			}
		}
		
		//echo (" min = $min max = $max ");
		
		if (0 < $min) {
			array_unshift($numbers, 0); 
		}

		if ( ($pages - 1) > $max) {
			array_push($numbers, $pages - 1); 
		}
		
		//foreach ($numbers as $i => $value) {
			//echo "{ $i - $value } ";
		//}
		
		$previous = 0;
		$link = NULL;
		foreach ($numbers as $i => $value) {
			if ($value !== NULL) {
				$link = RealEstateAgency_Object_SearchPaginator::page($page, $pages, $url_parameters, $value);
				if ($link) {
					if ( ($previous >= 0) and ( $value > ($previous + 1) ) ) {
						$navigation .= ".......";
					}
					$navigation .= $link;
				}
				$previous = $value;
			}
		}
		
		if ($navigation != "") {
			$navigation = "Сторінка:&nbsp;" . $navigation;
		}

		return $navigation;
	}

	public static function page($active_page, $pages, $url_parameters, $page) {

		if ( ( $page < 0 ) || ( $page >= $pages ) ) {
			return "";
		}

		$url_parameters[search_position] = $page * RealEstateAgency_Const::OBJECTS_ON_PAGE;

		$href = '';
		
		if ($active_page != $page) {
			$href .= '&nbsp;&nbsp;<a href="' . tools_url($url_parameters) . '">';
		} else {
			$href .= ' (<b> ';
		}

		$href .= $page + 1;

		if ($active_page != $page) {
			$href .= '</a>&nbsp;&nbsp;';
		} else {
			$href .= ' </b>) ';
		}
		return $href;
	}
	
	public static function drawPaginatorOld($search_counter, $url_parameters, $data_as_list_count) {

		$search_position = $url_parameters[search_position];
		$navigation = NULL;

		if ($search_position != 0) {
			$search_position = $search_position - RealEstateAgency_Const::OBJECTS_ON_PAGE;
			$url_parameters[search_position] = $search_position;
			$navigation .= '<a href="' . tools_url($url_parameters) . '">';
			$navigation .= '&nbsp;Назад';
			$navigation .= '</a>';
			$navigation .= '&nbsp;&nbsp;&nbsp;';
		}
		if ($data_as_list_count > RealEstateAgency_Const::OBJECTS_ON_PAGE) {
			$search_position = $search_position + RealEstateAgency_Const::OBJECTS_ON_PAGE;
			$url_parameters[search_position] = $search_position;
			$navigation .= '<a href="' . tools_url($url_parameters) . '">';
			$navigation .= 'Далі';
			$navigation .= '</a>';
		}
		return $navigation;
	}

}
