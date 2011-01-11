package ua.com.m1995.client;

abstract public class DBFStructureRowReader {
	
	protected final static String INPUT_REAL_ESTATE_OBJECT_TYPE_FLAT = "1";
	protected final static String INPUT_REAL_ESTATE_OBJECT_TYPE_ROOM = "2";
	protected final static String INPUT_REAL_ESTATE_OBJECT_TYPE_HOUSE = "3";
	protected final static String INPUT_REAL_ESTATE_OBJECT_TYPE_HOUSE_LAND = "4";
	protected final static String INPUT_REAL_ESTATE_OBJECT_TYPE_COMMERCIAL = "5";
	protected final static String INPUT_REAL_ESTATE_OBJECT_TYPE_LAND = "6";
	
	protected final static String INPUT_ROOMS_TYPE_UNKNOWN = "0";
	protected final static String INPUT_ROOMS_TYPE_SEPARATE = "1";
	protected final static String INPUT_ROOMS_TYPE_JOINED = "2";
	protected final static String INPUT_ROOMS_TYPE_JOINED_AND_SEPARATE= "3";
	
	abstract public void read(byte[] bytes, RealEstateObjectList list, DBFStructureAdapter adapter) throws ProgramException;
}
