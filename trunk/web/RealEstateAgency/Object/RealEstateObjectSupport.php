<?php

class RealEstateAgency_Object_RealEstateObjectSupport {

    static public function listOfTypes() {    
        $data = array();
        $data[] = array('id' => '0', 'name' => '...');
        $data[] = array('id' => RealEstateAgency_Const::TYPE_FLAT_NUMBER, 'name' => '��������');
        $data[] = array('id' => RealEstateAgency_Const::TYPE_ROOM_NUMBER, 'name' => '������');
        $data[] = array('id' => RealEstateAgency_Const::TYPE_HOUSE_NUMBER, 'name' => '�������');
		$data[] = array('id' => RealEstateAgency_Const::TYPE_COTTAGE_NUMBER, 'name' => '����');
        $data[] = array('id' => RealEstateAgency_Const::TYPE_COMMERCIAL_NUMBER, 'name' => '���������� ����');
        $data[] = array('id' => RealEstateAgency_Const::TYPE_LAND_NUMBER, 'name' => '�������� ������');
        return $data;
    }

	static public function listOfTypesForRent() {
		return RealEstateAgency_Object_RealEstateObjectSupport::listOfTypes();
    }

    static public function listOfRoomsTypes() {
        $data = array();
        $data[] = array('id' => '0', 'name' => '...');
        $data[] = array('id' => '1', 'name' => '�������');
        $data[] = array('id' => '2', 'name' => '�����');
        $data[] = array('id' => '3', 'name' => '�������-�������');
        return $data;
    }

	static public function listOfRoomsTypesShortly() {
        $data = array();
        $data[] = array('id' => '0', 'name' => '');
        $data[] = array('id' => '1', 'name' => '�������');
        $data[] = array('id' => '2', 'name' => '�����');
        $data[] = array('id' => '3', 'name' => '�.-����.');
        return $data;
    }

    static public function listOfTelephoneTypes() {
        $data = array();
        $data[] = array('id' => '0', 'name' => '...');
        $data[] = array('id' => '1', 'name' => '����');
        $data[] = array('id' => '2', 'name' => '�');
        $data[] = array('id' => '3', 'name' => '�� ���������');
        $data[] = array('id' => '4', 'name' => '��������');
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

