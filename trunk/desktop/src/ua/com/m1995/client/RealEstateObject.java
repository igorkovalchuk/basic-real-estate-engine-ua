package ua.com.m1995.client;


import java.util.HashMap;

import java.util.Map;


public class RealEstateObject {
	
	private String operationType = "";
	private String locationID = "";
	private String locationText = "";
	private String realEstateType = "";
	private String rooms = "";
	private String roomsType = "";
	private String price = "";
	private String cityDistrict = "";
	private String citySubDistrict = "";
	private String street = "";
	private String houseNumber = "";
	private String squareAll = "";
	private String squareLive = "";
	private String squareKitchen = "";
	private String squareLand = "";
	private String floor = "";
	private String floors = "";
	private String numberWC = "";
	private String numberBathes = "";
	private String numberExternal = "";
	private String telephoneType = "";
	private String description = "";
	private String rentPeriod = "";

	/**
	 * Must be null, if no errors;
	 */
	private String errorDescription = null;

	public String getLocationID() {
		return locationID;
	}
	
	public void setLocationID(String locationID) {
		this.locationID = locationID;
	}
	
	
	public String getLocationText() {
		return locationText;
	}
	
	public void setLocationText(String locationText) {
		this.locationText = locationText;
	}
	
	
	public String getRealEstateType() {
		return realEstateType;
	}
	
	public void setRealEstateType(String realEstateType) {
		this.realEstateType = realEstateType;
	}
	
	
	public String getRooms() {
		return rooms;
	}
	
	public void setRooms(String rooms) {
		this.rooms = rooms;
	}
	
	
	public String getRoomsType() {
		return roomsType;
	}
	
	public void setRoomsType(String roomsType) {
		this.roomsType = roomsType;
	}
	
	
	public String getPrice() {
		return price;
	}
	
	public void setPrice(String price) {
		this.price = price;
	}
	
	
	public String getCityDistrict() {
		return cityDistrict;
	}
	
	public void setCityDistrict(String cityDistrict) {
		this.cityDistrict = cityDistrict;
	}
	
	
	public String getCitySubDistrict() {
		return citySubDistrict;
	}
	
	public void setCitySubDistrict(String citySubDistrict) {
		if (citySubDistrict != null)
			citySubDistrict = citySubDistrict.replace('"', ' ');
		this.citySubDistrict = citySubDistrict;
	}
	
	
	public String getStreet() {
		return street;
	}
	
	public void setStreet(String street) {
		this.street = street;
	}
	
	
	public String getHouseNumber() {
		return houseNumber;
	}
	
	public void setHouseNumber(String houseNumber) {
		this.houseNumber = houseNumber;
	}
	
	
	public String getSquareAll() {
		return squareAll;
	}
	
	public void setSquareAll(String squareAll) {
		this.squareAll = squareAll;
	}
	
	
	public String getSquareLive() {
		return squareLive;
	}
	
	public void setSquareLive(String squareLive) {
		this.squareLive = squareLive;
	}
	
	
	public String getSquareKitchen() {
		return squareKitchen;
	}
	
	public void setSquareKitchen(String squareKitchen) {
		this.squareKitchen = squareKitchen;
	}
	
	public String getSquareLand() {
		return squareLand;
	}
	
	public void setSquareLand(String squareLand) {
		this.squareLand = squareLand;
	}
	
	public String getFloor() {
		return floor;
	}
	
	public void setFloor(String floor) {
		this.floor = floor;
	}
	
	
	public String getFloors() {
		return floors;
	}
	
	public void setFloors(String floors) {
		this.floors = floors;
	}
	
	
	public String getNumberWC() {
		return numberWC;
	}
	
	public void setNumberWC(String numberWC) {
		this.numberWC = numberWC;
	}
	
	
	public String getNumberBathes() {
		return numberBathes;
	}
	
	public void setNumberBathes(String numberBathes) {
		this.numberBathes = numberBathes;
	}
	
	
	public String getNumberExternal() {
		return numberExternal;
	}
	
	public void setNumberExternal(String numberExternal) {
		this.numberExternal = numberExternal;
	}
	
	
	public String getTelephoneType() {
		return telephoneType;
	}
	
	public void setTelephoneType(String telephoneType) {
		this.telephoneType = telephoneType;
	}
	
	
	public String getDescription() {
		return description;
	}
	
	public void setDescription(String description) {
		if (description != null) {
			description = description.replace('"', '`');
		}
		this.description = description;
	}
	
	public String toTestString() {
		StringBuffer result = new StringBuffer();
		
		
		result.append("[OT:" + this.getOperationType() + "]");
		result.append("[TYPE:" + this.getRealEstateType() + "]");
		
		result.append("[" + this.getLocationText() + "]");
		
		result.append("[L.ID:" + this.getLocationID() + "]");
		result.append("[D.ID:" + this.getCityDistrict() + "/");
		result.append("" + this.getCitySubDistrict() + "]");
		result.append("[" + this.getStreet() + "]");
		result.append("[" + this.getHouseNumber() + "]");
		
		result.append("[Price: " + this.getPrice() + "]");
		
		result.append("[" + this.getRooms() + "]");
		result.append("[" + this.getRoomsType() + "]");
		
		result.append("[" + this.getFloor() + "/");
		result.append("" + this.getFloors() + "]");
		
		result.append("[SQ.A: " + this.getSquareAll() + "]");
		result.append("[SQ.L: " + this.getSquareLive() + "]");
		result.append("[SQ.K: " + this.getSquareKitchen() + "]");
		result.append("[SQ.LN: " + this.getSquareLand() + "]");
		result.append("[R.PER: " + this.getRentPeriod() + "]");
		
		result.append("[" + this.getDescription() + "]");
		
		return result.toString();
	}
	
	public Map<String, String> mapper() {
		Map<String, String> result = new HashMap<String, String>();

		result.put(FormConstants.FORM_IDENTIFIER_OPERATION_TYPE, this.getOperationType());
		result.put(FormConstants.FORM_IDENTIFIER_LOCATION_ID, this.getLocationID());
		result.put(FormConstants.FORM_IDENTIFIER_LOCATION_TEXT, this.getLocationText());
		result.put(FormConstants.FORM_IDENTIFIER_REAL_ESTATE_TYPE, this.getRealEstateType());
		result.put(FormConstants.FORM_IDENTIFIER_ROOMS, this.getRooms());
		result.put(FormConstants.FORM_IDENTIFIER_ROOMS_TYPE, this.getRoomsType());
		result.put(FormConstants.FORM_IDENTIFIER_PRICE, this.getPrice());
		result.put(FormConstants.FORM_IDENTIFIER_CITY_DISTRICT, this.getCityDistrict());
		result.put(FormConstants.FORM_IDENTIFIER_CITY_SUB_DISTRICT, this.getCitySubDistrict());
		result.put(FormConstants.FORM_IDENTIFIER_STREET, this.getStreet());
		result.put(FormConstants.FORM_IDENTIFIER_HOUSE_NUMBER, this.getHouseNumber());
		result.put(FormConstants.FORM_IDENTIFIER_SQUARE_ALL, this.getSquareAll());
		result.put(FormConstants.FORM_IDENTIFIER_SQUARE_LIVE, this.getSquareLive());
		result.put(FormConstants.FORM_IDENTIFIER_SQUARE_KITCHEN, this.getSquareKitchen());
		result.put(FormConstants.FORM_IDENTIFIER_SQUARE_LAND, this.getSquareLand());
		result.put(FormConstants.FORM_IDENTIFIER_FLOOR, this.getFloor());
		result.put(FormConstants.FORM_IDENTIFIER_FLOORS, this.getFloors());
		result.put(FormConstants.FORM_IDENTIFIER_NUMBER_WC, this.getNumberWC());
		result.put(FormConstants.FORM_IDENTIFIER_NUMBER_BATHES, this.getNumberBathes());
		result.put(FormConstants.FORM_IDENTIFIER_NUMBER_EXTERNAL, this.getNumberExternal());
		result.put(FormConstants.FORM_IDENTIFIER_TELEPHONE_TYPE, this.getTelephoneType());
		result.put(FormConstants.FORM_IDENTIFIER_DESCRIPTION, this.getDescription());
		result.put(FormConstants.FORM_IDENTIFIER_RENT_PERIOD, this.getRentPeriod());

		return result;
	}
	
	private static String [] patterns = {
		"00000000000",	
		"0000-0000000",
		"0000-000-0000",
		"0000-000-00-00",
		"0000000",
		"000-0000",
		"000-00-00",
		"0-000-000",
		"000 0000",
		"000 00 00",
		"0 000 000"
	};
	
	static {
		int size = patterns.length;
		for(int i=0; i<size; i++)
			patterns[i] = patterns[i].replaceAll("\\d", "\\\\d");
	}
	
	/**
	 * Just remove any string that looks like the telephone number.
	 * @see RealEstateObject#patterns
	 */
	void removeTelephoneNumber() {
		String value = getDescription();
				
		// See java.util.regex.Pattern
		
		int size = patterns.length;
		for(int i=0; i<size; i++)
			value = value.replaceAll(patterns[i], "");
		
		if (value.startsWith(",")) {
			value = value.trim().substring(1);
		}

		this.setDescription(value);
	}

	public String getValue(RealEstateObjectColumns key, boolean userView) {
		String result;
		if (RealEstateObjectColumns.LOCATION_ID == key) {
			result = getLocationID();
			if (userView) {
				result = UserInterfaceConstants.getLocation(result);
			}
			return result;
		} else if (RealEstateObjectColumns.LOCATION_TEXT == key) {
			return getLocationText();
		} else if (RealEstateObjectColumns.REAL_ESTATE_TYPE == key) {
			result = getRealEstateType();
			if (userView) {
				result = UserInterfaceConstants.getRealEstateTypeByID(result);
			}
			return result;
		} else if (RealEstateObjectColumns.ROOMS == key) {
			return getRooms();
		} else if (RealEstateObjectColumns.ROOMS_TYPE == key) {
			result = getRoomsType();
			if (userView) {
				result = UserInterfaceConstants.getRoomsTypeByID(result);
			}
			return result;
		} else if (RealEstateObjectColumns.PRICE == key) {
			return getPrice();
		} else if (RealEstateObjectColumns.CITY_DISTRICT == key) {
			result = getCityDistrict();
			if (userView) {
				result = UserInterfaceConstants.getDistrictNameByID(result);
			}
			return result;
		} else if (RealEstateObjectColumns.CITY_SUB_DISTRICT == key) {
			return getCitySubDistrict();
		} else if (RealEstateObjectColumns.STREET == key) {
			return getStreet();
		} else if (RealEstateObjectColumns.HOUSE_NUMBER == key) {
			return getHouseNumber();
		} else if (RealEstateObjectColumns.SQUARE_ALL == key) {
			return getSquareAll();
		} else if (RealEstateObjectColumns.SQUARE_LIVE == key) {
			return getSquareLive();
		} else if (RealEstateObjectColumns.SQUARE_KITCHEN == key) {
			return getSquareKitchen();
		} else if (RealEstateObjectColumns.SQUARE_LAND == key) {
			return getSquareLand();
		} else if (RealEstateObjectColumns.FLOOR == key) {
			return getFloor();
		} else if (RealEstateObjectColumns.FLOORS == key) {
			return getFloors();
		} else if (RealEstateObjectColumns.DESCRIPTION == key) {
			return getDescription();
		} else if (RealEstateObjectColumns.RENT_PERIOD == key) {
			return getRentPeriod();
		} else {
			Log.error("Incorrect column's key: " + key);
			return null;
		}
	}
	
	public void setValue(RealEstateObjectColumns key, String value) {
		
		if (RealEstateObjectColumns.LOCATION_ID == key) {
			setLocationID(value);
		} else if (RealEstateObjectColumns.LOCATION_TEXT == key) {
			setLocationText(value);
		} else if (RealEstateObjectColumns.REAL_ESTATE_TYPE == key) {
			setRealEstateType(value);
		} else if (RealEstateObjectColumns.ROOMS == key) {
			setRooms(value);
		} else if (RealEstateObjectColumns.ROOMS_TYPE == key) {
			setRoomsType(value);
		} else if (RealEstateObjectColumns.PRICE == key) {
			setPrice(value);
		} else if (RealEstateObjectColumns.CITY_DISTRICT == key) {
			setCityDistrict(value);
		} else if (RealEstateObjectColumns.CITY_SUB_DISTRICT == key) {
			setCitySubDistrict(value);
		} else if (RealEstateObjectColumns.STREET == key) {
			setStreet(value);
		} else if (RealEstateObjectColumns.HOUSE_NUMBER == key) {
			setHouseNumber(value);
		} else if (RealEstateObjectColumns.SQUARE_ALL == key) {
			setSquareAll(value);
		} else if (RealEstateObjectColumns.SQUARE_LIVE == key) {
			setSquareLive(value);
		} else if (RealEstateObjectColumns.SQUARE_KITCHEN == key) {
			setSquareKitchen(value);
		} else if (RealEstateObjectColumns.FLOOR == key) {
			setFloor(value);
		} else if (RealEstateObjectColumns.FLOORS == key) {
			setFloors(value);
		} else if (RealEstateObjectColumns.DESCRIPTION == key) {
			setDescription(value);
		} else if (RealEstateObjectColumns.RENT_PERIOD == key) {
			setRentPeriod(value);
		} else {
			Log.error("Incorrect column's key: " + key);
		}
	}

	public String getErrorDescription() {
		return errorDescription;
	}

	public void setErrorDescription(String errorDescription) {
		this.errorDescription = errorDescription;
	}

	public String getOperationType() {
		return operationType;
	}

	public void setOperationType(String operationType) {
		this.operationType = operationType;
	}

	public String getRentPeriod() {
		return rentPeriod;
	}

	public void setRentPeriod(String rentPeriod) {
		this.rentPeriod = rentPeriod;
	}


}
