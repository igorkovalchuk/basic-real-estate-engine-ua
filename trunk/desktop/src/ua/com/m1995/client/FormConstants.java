package ua.com.m1995.client;

import java.util.Collections;
import java.util.HashMap;
import java.util.Map;

public class FormConstants {
	
	/**
	 * Form Identifiers. Login.
	 */
	
	/**
	 * Login flag.
	 */
	static final String FORM_IDENTIFIER_LOGON_FLAG = "login";
	
	static final String FORM_IDENTIFIER_LOGON_USER_NAME = "nick";
	
	static final String FORM_IDENTIFIER_LOGON_PASSWORD = "key";
	
	/**
	 * Form Identifiers. Real Estate Object.
	 */
	
	static final String FORM_IDENTIFIER_LOCATION_ID = "location_id";
	
	static final String FORM_IDENTIFIER_LOCATION_TEXT = "location_text";
	
	static final String FORM_IDENTIFIER_OPERATION_TYPE = "op_type";
	
	/**
	 * Flat, house, etc.
	 */
	static final String FORM_IDENTIFIER_REAL_ESTATE_TYPE = "r_e_type";
	
	/**
	 * Number of rooms.
	 */
	static final String FORM_IDENTIFIER_ROOMS = "rooms";
	
	/**
	 * Rooms, separate or joined.
	 */
	static final String FORM_IDENTIFIER_ROOMS_TYPE = "rooms_type";
	
	static final String FORM_IDENTIFIER_PRICE = "price";
	
	/**
	 * Example: Dniprovskyi
	 */
	static final String FORM_IDENTIFIER_CITY_DISTRICT = "city_district";
	
	/**
	 * Example: Rusanivka - the part of Dniprovskyi district of Kyiv city
	 */
	static final String FORM_IDENTIFIER_CITY_SUB_DISTRICT = "city_sub_district";

	static final String FORM_IDENTIFIER_STREET = "street";
	
	static final String FORM_IDENTIFIER_HOUSE_NUMBER = "house_num";
	
	/**
	 * Square of the whole real estate object.
	 */
	static final String FORM_IDENTIFIER_SQUARE_ALL = "sq_all";
	
	/**
	 * Square of the live area of the real estate object.
	 */
	static final String FORM_IDENTIFIER_SQUARE_LIVE = "sq_live";
	
	/**
	 * Square of the kitchen.
	 */
	static final String FORM_IDENTIFIER_SQUARE_KITCHEN = "sq_kitchen";
	
	/**
	 * Square of the land.
	 */	
	static final String FORM_IDENTIFIER_SQUARE_LAND = "sq_land";
	
	static final String FORM_IDENTIFIER_FLOOR = "floor";
	
	static final String FORM_IDENTIFIER_FLOORS = "floors";
	
	static final String FORM_IDENTIFIER_NUMBER_WC = "wc_num";
	
	static final String FORM_IDENTIFIER_NUMBER_BATHES = "bath_num";
	
	static final String FORM_IDENTIFIER_NUMBER_EXTERNAL = "external";
	
	static final String FORM_IDENTIFIER_TELEPHONE_TYPE = "tel_type";
	
	static final String FORM_IDENTIFIER_DESCRIPTION = "description";
	
	static final String FORM_IDENTIFIER_RENT_PERIOD = "rent_period";
	
	private static Map<String, String> validation = new HashMap<String, String>();
	
	static {
		validation.put(FORM_IDENTIFIER_LOCATION_ID, "Ідентифікатор об'єкту");
		validation.put(FORM_IDENTIFIER_LOCATION_TEXT, "Адреса об'єкту");
		validation.put(FORM_IDENTIFIER_REAL_ESTATE_TYPE, "Тип нерухомості");
		validation.put(FORM_IDENTIFIER_ROOMS, "Кількість кімнат");
		validation.put(FORM_IDENTIFIER_ROOMS_TYPE, "Кімнати, роздільні або суміжні");
		validation.put(FORM_IDENTIFIER_PRICE, "Вартість");
		validation.put(FORM_IDENTIFIER_CITY_DISTRICT, "Район");
		validation.put(FORM_IDENTIFIER_CITY_SUB_DISTRICT,"Масив");
		validation.put(FORM_IDENTIFIER_STREET, "Вулиця");
		validation.put(FORM_IDENTIFIER_HOUSE_NUMBER, "Номер будинку");
		validation.put(FORM_IDENTIFIER_SQUARE_ALL, "Загальна площа");
		validation.put(FORM_IDENTIFIER_SQUARE_LIVE, "Жила площа");
		validation.put(FORM_IDENTIFIER_SQUARE_KITCHEN, "Площа кухні");
		validation.put(FORM_IDENTIFIER_FLOOR, "Поверх");
		validation.put(FORM_IDENTIFIER_FLOORS, "Поверхів");
		validation.put(FORM_IDENTIFIER_NUMBER_WC, "Кількість санвузлів");
		validation.put(FORM_IDENTIFIER_NUMBER_BATHES, "Кількість ванн та/або душів");
		validation.put(FORM_IDENTIFIER_NUMBER_EXTERNAL, "Кількість балконів та лоджій");
		validation.put(FORM_IDENTIFIER_TELEPHONE_TYPE, "Наявність телефону");
		validation.put(FORM_IDENTIFIER_DESCRIPTION, "Додаткова інформація");
		validation = Collections.unmodifiableMap(validation);
	}
	
	static Map<String,String> getValidationPrefixes() {
		return validation;
	}
	
	//static final int FORM_VALUE_ROOMS_TYPE_UNKNOWN = 0;
	//static final int FORM_VALUE_ROOMS_TYPE_SEPARATE = 1;
	//static final int FORM_VALUE_ROOMS_TYPE_JOINED = 2;
	//static final int FORM_VALUE_ROOMS_TYPE_SJ = 3;
	
}
