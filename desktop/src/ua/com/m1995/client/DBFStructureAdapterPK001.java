package ua.com.m1995.client;

public class DBFStructureAdapterPK001 extends DBFStructureAdapter {	
	
	/**
	 * Adapter's signature.
	 */
	private static final String[] ARRAY_OF_COLUMNS = {
		"NAME:N3; TYPE:N; OFFSET:1; LENGTH:12; DECIMAL:0;",
		"NAME:KOMN; TYPE:C; OFFSET:13; LENGTH:1; DECIMAL:0;",
		"NAME:PLANIR; TYPE:C; OFFSET:14; LENGTH:2; DECIMAL:0;",
		"NAME:RASPOL; TYPE:C; OFFSET:16; LENGTH:21; DECIMAL:0;",
		"NAME:MASIV; TYPE:C; OFFSET:37; LENGTH:25; DECIMAL:0;",
		"NAME:STREET; TYPE:C; OFFSET:62; LENGTH:30; DECIMAL:0;",
		"NAME:DOM_N; TYPE:C; OFFSET:92; LENGTH:7; DECIMAL:0;",
		"NAME:CENA; TYPE:N; OFFSET:99; LENGTH:9; DECIMAL:0;",
		"NAME:ETAJ; TYPE:N; OFFSET:108; LENGTH:2; DECIMAL:0;",
		"NAME:ETAJA; TYPE:N; OFFSET:110; LENGTH:2; DECIMAL:0;",
		"NAME:DOM; TYPE:C; OFFSET:112; LENGTH:2; DECIMAL:0;",
		"NAME:T; TYPE:C; OFFSET:114; LENGTH:1; DECIMAL:0;",
		"NAME:PL_O; TYPE:N; OFFSET:115; LENGTH:5; DECIMAL:1;",
		"NAME:PL_J; TYPE:N; OFFSET:120; LENGTH:5; DECIMAL:1;",
		"NAME:PL_K; TYPE:N; OFFSET:125; LENGTH:5; DECIMAL:1;",
		"NAME:BALKON; TYPE:C; OFFSET:130; LENGTH:6; DECIMAL:0;",
		"NAME:N1; TYPE:N; OFFSET:136; LENGTH:8; DECIMAL:0;",
		"NAME:N2; TYPE:N; OFFSET:144; LENGTH:8; DECIMAL:0;",
		"NAME:TELEFON; TYPE:N; OFFSET:152; LENGTH:7; DECIMAL:0;",
		"NAME:INFORMATIO; TYPE:C; OFFSET:159; LENGTH:80; DECIMAL:0;",
		"NAME:DATE; TYPE:D; OFFSET:239; LENGTH:8; DECIMAL:0;",
		"NAME:FIRMA; TYPE:C; OFFSET:247; LENGTH:20; DECIMAL:0;",
		"NAME:EX; TYPE:C; OFFSET:267; LENGTH:1; DECIMAL:0;",
		"NAME:S; TYPE:L; OFFSET:268; LENGTH:1; DECIMAL:0;",
		"NAME:S_U; TYPE:C; OFFSET:269; LENGTH:1; DECIMAL:0;",
		"NAME:POL; TYPE:C; OFFSET:270; LENGTH:1; DECIMAL:0;",
		"NAME:KOD; TYPE:N; OFFSET:271; LENGTH:4; DECIMAL:0;"
	};
	
	public String[] getArrayOfColumns() {
		return ARRAY_OF_COLUMNS;
	}
	
	public RealEstateObjectList readData(byte[] bytes) throws ProgramException{
		RealEstateObjectList list = new RealEstateObjectList();
		DBFStructureRowReader reader = new DBFStructureRowReaderPK001();
		reader.read(bytes, list, this);
		return list;
	}
	
}
