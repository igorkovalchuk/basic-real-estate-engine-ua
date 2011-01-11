package ua.com.m1995.client;

public class Utilities {

	public static int byte2int(byte value) {
		if (value < 0) {
			return (int)(256 + value);
		} else {
			return (int) value;
		}
	}
	
	/**
	 * Example, hex code: 05 01
	 * @param value1 here 05
	 * @param value2 here 01
	 * @return 01 * 256 + 05
	 */
	public static int bytes2int(byte value1, byte value2) {
		return (byte2int(value1) + byte2int(value2) * 256); 
	}
	
	/**
	 * Example, hex code: 05 03 00 01
	 * @param value1 here 05
	 * @param value2 here 03
	 * @param value3 here 00
	 * @param value4 here 01
	 * @return (03 * 256 + 05) + (01 * 256 + 00) * 65536
	 */
	public static int bytes2int(byte value1, byte value2, byte value3, byte value4) {
		return (bytes2int(value1,value2) + bytes2int(value3,value4) * 65536); 
	}
	
}
