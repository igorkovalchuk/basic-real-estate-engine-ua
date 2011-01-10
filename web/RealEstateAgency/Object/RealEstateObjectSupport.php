<?php

class RealEstateAgency_Object_RealEstateObjectSupport {

    static public function listOfTypes() {    
        $data = array();
        $data[] = array('id' => '0', 'name' => '...');
        $data[] = array('id' => RealEstateAgency_Const::TYPE_FLAT_NUMBER, 'name' => 'квартира');
        $data[] = array('id' => RealEstateAgency_Const::TYPE_ROOM_NUMBER, 'name' => 'кімната');
        $data[] = array('id' => RealEstateAgency_Const::TYPE_HOUSE_NUMBER, 'name' => 'будинок');
		$data[] = array('id' => RealEstateAgency_Const::TYPE_COTTAGE_NUMBER, 'name' => 'дача');
        $data[] = array('id' => RealEstateAgency_Const::TYPE_COMMERCIAL_NUMBER, 'name' => 'нежитловий фонд');
        $data[] = array('id' => RealEstateAgency_Const::TYPE_LAND_NUMBER, 'name' => 'земельна ділянка');
        return $data;
    }

	static public function listOfTypesForRent() {
		return RealEstateAgency_Object_RealEstateObjectSupport::listOfTypes();
    }

    static public function listOfRoomsTypes() {
        $data = array();
        $data[] = array('id' => '0', 'name' => '...');
        $data[] = array('id' => '1', 'name' => 'роздільні');
        $data[] = array('id' => '2', 'name' => 'суміжні');
        $data[] = array('id' => '3', 'name' => 'суміжньо-роздільні');
        return $data;
    }

	static public function listOfRoomsTypesShortly() {
        $data = array();
        $data[] = array('id' => '0', 'name' => '');
        $data[] = array('id' => '1', 'name' => 'роздільні');
        $data[] = array('id' => '2', 'name' => 'суміжні');
        $data[] = array('id' => '3', 'name' => 'с.-розд.');
        return $data;
    }

    static public function listOfTelephoneTypes() {
        $data = array();
        $data[] = array('id' => '0', 'name' => '...');
        $data[] = array('id' => '1', 'name' => 'немає');
        $data[] = array('id' => '2', 'name' => 'є');
        $data[] = array('id' => '3', 'name' => 'на блокіраторі');
        $data[] = array('id' => '4', 'name' => 'таксофон');
        return $data;        
    }

	static public function getRoomsTypeShortly($number) {
		$data = RealEstateAgency_Object_RealEstateObjectSupport::listOfRoomsTypesShortly();
		foreach ($data as $index => $hash) {
			$id = $hash['id'];
			$name = $hash['name'];
			if ($id == $number) {
				return $name;
			}
		}
		return '';
	}
	
}

