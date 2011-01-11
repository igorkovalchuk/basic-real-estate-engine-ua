package ua.com.m1995.client;

public enum DBFFieldType {

	Number, Characters, Letter, Date;
	
	public char asCharacter() throws ProgramException {
		char result;
		if (this == DBFFieldType.Number) {
			result = 'N';
		} else if (this == DBFFieldType.Characters) {
			result = 'C';
		} else if (this == DBFFieldType.Date) {
			result = 'D';
		} else if (this == DBFFieldType.Letter) {
			result = 'L';
		} else {
			throw new ProgramException(Messages.MESSAGE_INCORRECT_DBF_FORMAT + " [DBFFieldType.asCharacter]");
		}
		return result;
	}
	
	public static DBFFieldType asObject(char value) throws ProgramException {
		DBFFieldType result = null;
		if (value == 'N') {
			result = DBFFieldType.Number;
		} else if (value == 'C') {
			result = DBFFieldType.Characters;
		} else if (value == 'D') {
			result = DBFFieldType.Date;
		} else if (value == 'L') {
			result = DBFFieldType.Letter;
		} else {
			throw new ProgramException(Messages.MESSAGE_INCORRECT_DBF_FORMAT + " [DBFFieldType.asObject(" + value + ")]");
		}
		return result;
	}
	
	
}
