package ua.com.m1995.client;

import java.io.ByteArrayOutputStream;
import java.io.UnsupportedEncodingException;

public class DBFColumn {

	private String name = "";
	private DBFFieldType fieldType = null;
	private int offset = 0;
	private int fieldLength = 0;
	private int decimalCount = 0;
	
	public void init(byte[] bytes, int address) throws ProgramException {
		
		StringBuffer columnName = new StringBuffer();
		byte characterByte;
		
		for (int i=0; i < 11; i++) {
			characterByte = bytes[address + i];
			if (characterByte == 0) {
				break;
			}
			columnName.append( (char) characterByte );
		}
		this.name = columnName.toString();
		
		char type = (char) bytes[address + 11];
		fieldType = DBFFieldType.asObject(type);
		
		offset = Utilities.bytes2int(
				bytes[address + 12], bytes[address + 13],
				bytes[address + 14], bytes[address + 15] );
		
		fieldLength = Utilities.byte2int( bytes[address + 16] );
		
		decimalCount = Utilities.byte2int( bytes[address + 17] );
		
	}

	
	public String getSignature() throws ProgramException {
		return "NAME:" + name + "; TYPE:" + fieldType.asCharacter() + "; OFFSET:" + offset + "; LENGTH:" + fieldLength + "; DECIMAL:" + decimalCount + ";";
	}


	public String getName() {
		return name;
	}


	public DBFFieldType getFieldType() {
		return fieldType;
	}


	public int getOffset() {
		return offset;
	}


	public int getFieldLength() {
		return fieldLength;
	}


	public int getDecimalCount() {
		return decimalCount;
	}
	
	/**
	 * When user deletes a record, DBF Database usually doesn't delete
	 * such record physically from a database file, 
	 * but just it sets a flag 'this record is deleted'.
	 * 
	 * @param bytes
	 * @param rowOffset
	 * @return true, if it is still normal active record.
	 */
	public static boolean isActiveRecord(byte[] bytes, int rowOffset) {
		if ( 32 == bytes[rowOffset]) {
			return true;
		}
		return false;
	}
	
	public String readData(byte[] bytes, int rowOffset) throws ProgramException {
		StringBuffer buffer1 = new StringBuffer();
		ByteArrayOutputStream buffer2 = new ByteArrayOutputStream();
		String resultString = "";
		
		int length = this.getFieldLength();
		int offset = this.getOffset() + rowOffset;
		
		try {
		
		if (DBFFieldType.Number == fieldType) {
			for (int i=0; i<length; i++) {
				if (bytes[offset + i] == 0)
					break;
				buffer1.append((char) bytes[offset + i] );
			}
			resultString = buffer1.toString();
		} else if (DBFFieldType.Characters == fieldType) {
			for (int i=0; i<length; i++) {
				if (bytes[offset + i] == 0)
					break;
				buffer2.write(bytes[offset + i]);
				//result.append((char) Utilities.byte2int(bytes[offset + i]) );
			}
			resultString = buffer2.toString("Cp1251");
		} else if (DBFFieldType.Letter == fieldType) {
			for (int i=0; i<length; i++) {
				if (bytes[offset + i] == 0)
					break;
				buffer2.write(bytes[offset + i]);
				//result.append((char) bytes[offset + i] );
			}
			resultString = buffer2.toString("Cp1251");
		} else if (DBFFieldType.Date == fieldType) {
			Log.error("Can't read Date. Not implemented.");
		} else {
			throw new ProgramException(Messages.MESSAGE_INCORRECT_DBF_FORMAT + " [Reading data]");
		}
		
		} catch (UnsupportedEncodingException e) {
			throw new ProgramException(Messages.MESSAGE_INCORRECT_DBF_FORMAT + " [UnsupportedEncodingException]", e);
		}
		
		return resultString;
	}
	
}
