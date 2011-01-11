package ua.com.m1995.client;

import java.util.Collection;
import java.util.Iterator;
import java.util.LinkedHashMap;
import java.util.List;
import java.util.ArrayList;
import java.util.Map;

public class UserInterfaceConstants {

	// Location in the database;
	public final static String KYIV_LOCATION_ID = "100";
	
	public final static String KYIV_LOCATION_NAME = "Київ";
	
	public final static String OPERATION_TYPE_SELL = "0";
	public final static String OPERATION_TYPE_RENT = "1";
	
	private static Map<String, String> districtsOfKyiv = new LinkedHashMap<String, String>();
	private static Map<String, String> districtsOfKyivReversed = new LinkedHashMap<String, String>();	

	static {
		districtsOfKyiv.put("1", "Голосіївський");
		districtsOfKyiv.put("2", "Дарницький");
		districtsOfKyiv.put("3", "Деснянський");
		districtsOfKyiv.put("4", "Дніпровський");
		districtsOfKyiv.put("5", "Оболонський");
		districtsOfKyiv.put("6", "Печерський");
		districtsOfKyiv.put("7", "Подольский");
		districtsOfKyiv.put("8", "Святошинський");
		districtsOfKyiv.put("9", "Соломенський");
		districtsOfKyiv.put("10", "Шевченківський");
		Collection<String> values = districtsOfKyiv.keySet();
		Iterator<String> i = values.iterator();
		while(i.hasNext()) {
			String key = i.next();
			String value = districtsOfKyiv.get(key);
			districtsOfKyivReversed.put(value, key);
		}
	}

	public static String getDistrictNameByID(String id) {
		return districtsOfKyiv.get(id);
	}
	
	public static String getDistrictIDByName(String name) {
		return districtsOfKyivReversed.get(name); 
	}
	
	/**
	 * @return list of names of districts
	 */
	public static List<String> getDistricts() {
		List<String> result = new ArrayList<String>();
		Iterator<String> i = districtsOfKyivReversed.keySet().iterator();
		while(i.hasNext()) {
			result.add(i.next());
		}
		return result;
	}
		
	public static String getLocation(String id) {
		if (KYIV_LOCATION_ID.equals(id)) {
			return "Київ";
		} else {
			return id;
		}
	}
	
	private static Map<String, String> realEstateType = new LinkedHashMap<String, String>();
	private static Map<String, String> realEstateTypeReversed = new LinkedHashMap<String, String>();
	
	static {
		realEstateType.put("1", "квартира");
		realEstateType.put("2", "кімната");
		realEstateType.put("3", "дім");
		realEstateType.put("4", "дача");
		realEstateType.put("5", "комерційна");
		realEstateType.put("6", "земля");
		Collection<String> values = realEstateType.keySet();
		Iterator<String> i = values.iterator();
		while(i.hasNext()) {
			String key = i.next();
			String value = realEstateType.get(key);
			realEstateTypeReversed.put(value, key);
		}
	}
	
	public static List<String> getRealEstateTypes() {
		List<String> result = new ArrayList<String>();
		Iterator<String> i = realEstateTypeReversed.keySet().iterator();
		while(i.hasNext()) {
			result.add(i.next());
		}
		return result;
	}
	
	public static String getRealEstateTypeByID(String id) {
		return realEstateType.get(id);
	}
	
	public static String getRealEstateTypeIDByName(String name) {
		return realEstateTypeReversed.get(name);
	}
	
	private static Map<String,String> roomsType = new LinkedHashMap<String,String>();
	private static Map<String,String> roomsTypeReversed = new LinkedHashMap<String,String>();
	
	static {
		roomsType.put("0", "");
		roomsType.put("1", "роздільні");
		roomsType.put("2", "суміжні");
		roomsType.put("3", "с.-розд.");
		Collection<String> values = roomsType.keySet();
		Iterator<String> i = values.iterator();
		while(i.hasNext()) {
			String key = i.next();
			String value = roomsType.get(key);
			roomsTypeReversed.put(value, key);
		}
	}

	public static List<String> getRoomsTypes() {
		List<String> result = new ArrayList<String>();
		Iterator<String> i = roomsTypeReversed.keySet().iterator();
		while(i.hasNext()) {
			result.add(i.next());
		}
		return result;
	}

	public static String getRoomsTypeByID(String id) {
		return roomsType.get(id);
	}
	
	public static String getRoomsTypeIDByName(String name) {
		return roomsTypeReversed.get(name);
	}
	
}
