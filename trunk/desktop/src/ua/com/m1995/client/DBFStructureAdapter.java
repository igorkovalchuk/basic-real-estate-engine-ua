package ua.com.m1995.client;

import java.util.LinkedHashMap;
import java.util.Map;

abstract public class DBFStructureAdapter {

	private static final int SOFTWARE_VERSION = 0x30;
	private static final String SOFTWARE_VERSION_DESCRIPTION = "Visual FoxPro w. DBC"; 
	private static final int LANGUAGE = 0xc9;
	private static final String LANGUAGE_DESCRIPTION = "Russian Windows";

	private Map<String, DBFColumn> columnsMap = new LinkedHashMap<String, DBFColumn>();
	
	private int recordLength = 0;
	
	private int numberOfRecords = 0;
	
	abstract public RealEstateObjectList readData(byte[] bytes) throws ProgramException;
	abstract public String[] getArrayOfColumns();
	
	public static int getSoftwareVersion() {
		return SOFTWARE_VERSION;
	}
	
	public static String getSoftwareVersionDescription() {
		return SOFTWARE_VERSION_DESCRIPTION;
	}
	
	public static int getLanguageDriverID() {
		return LANGUAGE;
	}
	
	public static String getLanguageDriverDescription() {
		return LANGUAGE_DESCRIPTION;
	}
	
	public DBFColumn getColumn(String name) throws ProgramException {
		if (! columnsMap.containsKey(name)) {
			throw new ProgramException(Messages.MESSAGE_INCORRECT_DBF_FORMAT + " [No such column, " + name + "]");
		}
		return columnsMap.get(name);
	}
	
	public void setColumnsMap(Map<String, DBFColumn> values) {
		this.columnsMap = values;
	}
	
	public int getRecordLength() {
		return recordLength;
	}
	public void setRecordLength(int recordLength) {
		this.recordLength = recordLength;
	}

	private String headerSignature = null;

	private int headerColumnsNumber = getArrayOfColumns().length;
		
	public String getHeaderSignature() {
		if (headerSignature == null) {
			String[] arrayOfColumns = getArrayOfColumns();
			StringBuffer signatures = new StringBuffer();
			int n = getColumnsNumber();
			for (int i=0; i<n; i++) {
				signatures.append(arrayOfColumns[i].toString());
			}
			headerSignature = signatures.toString();
		}
		return headerSignature;
	}
	
	public int getColumnsNumber() {
		return headerColumnsNumber;
	}
	
	public int getHeaderLength() {
		int headerLength = 32 + getColumnsNumber() * 32 + 264;
		return headerLength;
	}

	public void setNumberOfRecords(int value) {
		numberOfRecords = value;
	}
	
	public int getNumberOfRecords() {
		return numberOfRecords;
	}

}
