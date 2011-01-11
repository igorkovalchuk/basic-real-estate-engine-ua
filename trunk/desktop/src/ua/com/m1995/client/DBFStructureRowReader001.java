package ua.com.m1995.client;

import java.util.HashMap;
import java.util.Map;
import java.util.Set;

/**
 * See also {@link DBFStructureAdapterAK001} 
 */
abstract public class DBFStructureRowReader001 extends DBFStructureRowReader {
	
	protected final static String DBF_ROOMS_TYPE_SEPARATE = "р";
	protected final static String DBF_ROOMS_TYPE_JOINED = "с";
	protected final static String DBF_ROOMS_TYPE_JOINED_AND_SEPARATE= "ср";
	
	protected final static Map<String,Integer> areasOfCountry = new HashMap<String,Integer>();
	
	// Map DBF name of district to Web-form input value (number);
	protected final static Map<String,Integer> districtsOfKyiv = new HashMap<String,Integer>();
	
	static {
		// areasOfCountry.put("Киевская обл.", 1);
		// "Львовская обл."
		// "Полтавская обл."
		// "Сумская обл."
	}
	
	static {
		districtsOfKyiv.put("Голосеевский", 1);
		districtsOfKyiv.put("Дарницкий", 2);
		districtsOfKyiv.put("Деснянский", 3);
		districtsOfKyiv.put("Днепровский", 4);
		districtsOfKyiv.put("Оболонский", 5);
		districtsOfKyiv.put("Печерский", 6);
		districtsOfKyiv.put("Подольский", 7);
		districtsOfKyiv.put("Святошинский", 8);
		districtsOfKyiv.put("Соломенский", 9);
		districtsOfKyiv.put("Шевченковский", 10);	
	}
	
	protected static final String ROOMS = "KOMN";
	protected static final String ROOMS_TYPE = "PLANIR";
	
	protected static final String DISTRICT_OR_LOCATION = "RASPOL";
	protected static final String SUB_DISTRICT = "MASIV";
	
	protected static final String STREET = "STREET";
	protected static final String HOUSE_NUMBER = "DOM_N";
	
	protected static final String PRICE = "CENA";
	
	protected static final String FLOOR = "ETAJ";
	protected static final String FLOORS = "ETAJA";
	
	protected static final String SQ_ALL = "PL_O";
	protected static final String SQ_LIVE = "PL_J";
	protected static final String SQ_KITCHEN = "PL_K";
	
	protected static final String SQ_ALL_2 = "METR";
	protected static final String SQ_LIVE_2 = "MG";
	
	protected static final String SQ_LAND = "ZEM";
	
	protected static final String INFORMATION = "INFORMATIO";
	
	protected static final String INFORMATION_2 = "INFO";
	
	protected static final String RENT_PERIOD = "SA";
	
	protected static final String AGENCY = "FIRMA";
	
	protected static final String DIRECT = "EX";
	protected static final String INSERT_OR_REMOVE = "S";
	
	public void read(byte[] bytes, RealEstateObjectList list, DBFStructureAdapter adapter) throws ProgramException{
		int recordLength = adapter.getRecordLength();
		int headerLength = adapter.getHeaderLength();
		int rowOffset = headerLength;
		
		int n = adapter.getNumberOfRecords();
		
		for(int i=0; i<n; i++) {
			RealEstateObject object = readAnObject(bytes, rowOffset, adapter);
			if (object != null)
				list.add(object);
			rowOffset += recordLength;
		}
	}
	
	abstract protected Set<String> getListOfColumns();
	
	abstract protected RealEstateObject readAnObject(byte[] bytes, int rowOffset, DBFStructureAdapter adapter) throws ProgramException;
	
	protected RealEstateObject readAnObject(byte[] bytes, int rowOffset, DBFStructureAdapter adapter, Set<String> columns) throws ProgramException {
		
		DBFColumn column;
		RealEstateObject object = new RealEstateObject();
		
		if (columns.contains(ROOMS)) {
			column = adapter.getColumn(ROOMS);
			object.setRooms(column.readData(bytes, rowOffset).trim());
		}
		
		if (columns.contains(ROOMS_TYPE)) {
			column = adapter.getColumn(ROOMS_TYPE);
			String roomsType = column.readData(bytes, rowOffset).trim();
			if (DBF_ROOMS_TYPE_SEPARATE.equals(roomsType)) {
				roomsType = INPUT_ROOMS_TYPE_SEPARATE; 
			} else if (DBF_ROOMS_TYPE_JOINED.equals(roomsType)) {
				roomsType = INPUT_ROOMS_TYPE_JOINED;
			} else if (DBF_ROOMS_TYPE_JOINED_AND_SEPARATE.equals(roomsType)) {
				roomsType = INPUT_ROOMS_TYPE_JOINED_AND_SEPARATE;
			} else {
				roomsType = INPUT_ROOMS_TYPE_UNKNOWN;
			}
			object.setRoomsType(roomsType);
		}
		
		boolean isCity = false;
		
		if (columns.contains(DISTRICT_OR_LOCATION)) {
			column = adapter.getColumn(DISTRICT_OR_LOCATION);
		
			String districtOrLocation = column.readData(bytes, rowOffset).trim();
			if (districtsOfKyiv.containsKey(districtOrLocation)) {
				isCity = true;
				object.setLocationID(UserInterfaceConstants.KYIV_LOCATION_ID);
				object.setCityDistrict(districtsOfKyiv.get(districtOrLocation).toString());
				column = adapter.getColumn(SUB_DISTRICT);
				object.setCitySubDistrict(column.readData(bytes, rowOffset).trim());
			} else {
				column = adapter.getColumn(SUB_DISTRICT);
				object.setLocationText(districtOrLocation);
			}
		}
		
		if (columns.contains(STREET)) {
			column = adapter.getColumn(STREET);
			String street = column.readData(bytes, rowOffset).trim();
			if (isCity) {
				String data[] = street.split("/");
				street = data[0];
			}
			object.setStreet(street);
		}
		
		if (columns.contains(HOUSE_NUMBER)) {
			column = adapter.getColumn(HOUSE_NUMBER);
			object.setHouseNumber(column.readData(bytes, rowOffset).trim());
		}
		
		if (columns.contains(PRICE)) {
			column = adapter.getColumn(PRICE);
			object.setPrice(column.readData(bytes, rowOffset).trim());
		}
		
		if (columns.contains(FLOOR)) {
			column = adapter.getColumn(FLOOR);
			object.setFloor(column.readData(bytes, rowOffset).trim());
		}
		
		if (columns.contains(FLOORS)) {
			column = adapter.getColumn(FLOORS);
			object.setFloors(column.readData(bytes, rowOffset).trim());
		}
		
		if (columns.contains(SQ_ALL)) {
			column = adapter.getColumn(SQ_ALL);
			object.setSquareAll(column.readData(bytes, rowOffset).trim());
		}
		
		if (columns.contains(SQ_LIVE)) {
			column = adapter.getColumn(SQ_LIVE);
			object.setSquareLive(column.readData(bytes, rowOffset).trim());
		}
		
		if (columns.contains(SQ_ALL_2)) {
			column = adapter.getColumn(SQ_ALL_2);
			object.setSquareAll(column.readData(bytes, rowOffset).trim());
		}
		
		if (columns.contains(SQ_LIVE_2)) {
			column = adapter.getColumn(SQ_LIVE_2);
			object.setSquareLive(column.readData(bytes, rowOffset).trim());
		}
		
		if (columns.contains(SQ_KITCHEN)) {
			column = adapter.getColumn(SQ_KITCHEN);
			object.setSquareKitchen(column.readData(bytes, rowOffset).trim());
		} else {
			object.setSquareKitchen("0");
		}
		
		if (columns.contains(SQ_LAND)) {
			column = adapter.getColumn(SQ_LAND);
			object.setSquareLive(column.readData(bytes, rowOffset).trim());
		}
		
		if (columns.contains(INFORMATION)) {
			column = adapter.getColumn(INFORMATION);
			object.setDescription(column.readData(bytes, rowOffset).trim().replace(",", ", "));
		}
		
		if (columns.contains(INFORMATION_2)) {
			column = adapter.getColumn(INFORMATION_2);
			object.setDescription(column.readData(bytes, rowOffset).trim().replace(",", ", "));
		}
		
		if (columns.contains(RENT_PERIOD)) {
			column = adapter.getColumn(RENT_PERIOD);
			object.setRentPeriod(column.readData(bytes, rowOffset).trim());
		}
		
		column = adapter.getColumn(INSERT_OR_REMOVE);
		String insertOrRemove = column.readData(bytes, rowOffset).trim();
		boolean isInsert = false;
		if ("T".equals(insertOrRemove)) {
			isInsert = true;
		}
		
		column = adapter.getColumn(DIRECT);
		String isDirectValue = column.readData(bytes, rowOffset).trim();
		boolean isDirect = false;
		if ("A".equals(isDirectValue)) {
			isDirect = true;
		}
		
		if (! isDirect) {
			column = adapter.getColumn(AGENCY);
			 String name = column.readData(bytes, rowOffset).trim();
			 if ("Михаил".equals(name)) {
				 isDirect = true;
			 }
		}
		
		boolean isActive = DBFColumn.isActiveRecord(bytes, rowOffset);
		
		if (isDirect && isInsert && isActive) {
			Log.debug(object.toTestString());
			return object;
		} else {
			return null;
		}
	}
		
}
