package ua.com.m1995.client;

import java.util.LinkedHashMap;
import java.util.Map;

/**
 * Represents DBF file header and it's columns 
 */
public class DBFStructureHeaderReader {

	// private int numberOfRecords = 0;
	private int headerLength = 0;
	private int eachRecordLength = 0;
	private StringBuffer signature = new StringBuffer();
	
	DBFStructureAdapter init(byte[] bytes) throws ProgramException {

		Map<String, DBFColumn> columnsMap = new LinkedHashMap<String, DBFColumn>();
		
		int software = Utilities.byte2int(bytes[0]);
		if (software == DBFStructureAdapter.getSoftwareVersion()) {
			Log.debug("Version : " + DBFStructureAdapter.getSoftwareVersionDescription());
		} else {
			throw new ProgramException(Messages.MESSAGE_INCORRECT_DBF_FORMAT + " [Software, " + software + "]");
		}
		
		Log.debug("Date of last update: " + 
				Utilities.byte2int(bytes[3]) + " " + 
				Utilities.byte2int(bytes[2]) + " " + 
				(Utilities.byte2int(bytes[1]) + 2000));
		
		int numberOfRecords = Utilities.bytes2int(bytes[4],bytes[5],bytes[6],bytes[7]);
		Log.debug("Number of records in data file: " + numberOfRecords);
		
		headerLength = Utilities.bytes2int(bytes[8],bytes[9]);
		Log.debug("Length of header structure: " + headerLength);
		
		eachRecordLength = Utilities.bytes2int(bytes[10],bytes[11]);
		Log.debug("Length of each record: " + eachRecordLength);
		
		int language = Utilities.byte2int(bytes[29]);
		if (language == DBFStructureAdapter.getLanguageDriverID()) {
			Log.debug("Language driver: " + DBFStructureAdapter.getLanguageDriverDescription());
		} else {
			throw new ProgramException(Messages.MESSAGE_INCORRECT_DBF_FORMAT + " [Language, " + language + "]");
		}
		
		int columnsBytes = (headerLength - 264 - 32);
		int columns = columnsBytes / 32;
		Log.debug("Columns: " + columns);
		
		if ((columns * 32) != columnsBytes) {
			throw new ProgramException(Messages.MESSAGE_INCORRECT_DBF_FORMAT + " [Columns]");
		}
				
		int address;
		for(int i = 1; i <= columns; i++) {
			address = i * 32;
			DBFColumn column = new DBFColumn();
			column.init(bytes, address);
			this.addColumn(column, columnsMap);
			signature.append( column.getSignature() );
		}
		
		DBFStructureAdapter dbfConstants = new AdapterSelector().getAdapter(columns, signature.toString());

		dbfConstants.setColumnsMap(columnsMap);
		dbfConstants.setRecordLength(eachRecordLength);
		dbfConstants.setNumberOfRecords(numberOfRecords);
		
		return dbfConstants;
	}


	private void addColumn(DBFColumn column, Map<String, DBFColumn> columnsMap) throws ProgramException {
		String name = column.getName();
		if (columnsMap.containsKey(name)) {
			throw new ProgramException(Messages.MESSAGE_INCORRECT_DBF_FORMAT + " [Duplicate column]");
		}
		columnsMap.put(name, column);
		Log.debug(column.getSignature());
	}
	
}
