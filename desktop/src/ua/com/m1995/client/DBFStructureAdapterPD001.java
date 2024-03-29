package ua.com.m1995.client;

public class DBFStructureAdapterPD001 extends DBFStructureAdapter {	
	
	/**
	 * Adapter's signature.
	 */
	private static final String[] ARRAY_OF_COLUMNS = {
		"NAME:N3; TYPE:N; OFFSET:1; LENGTH:12; DECIMAL:0;",
		"NAME:NAZ; TYPE:C; OFFSET:13; LENGTH:3; DECIMAL:0;",
		"NAME:KOMN; TYPE:C; OFFSET:16; LENGTH:1; DECIMAL:0;",
		"NAME:PLANIR; TYPE:C; OFFSET:17; LENGTH:2; DECIMAL:0;",
		"NAME:RASPOL; TYPE:C; OFFSET:19; LENGTH:21; DECIMAL:0;",
		"NAME:STREET; TYPE:C; OFFSET:40; LENGTH:30; DECIMAL:0;",
		"NAME:DOM_N; TYPE:C; OFFSET:70; LENGTH:20; DECIMAL:0;",
		"NAME:CENA; TYPE:N; OFFSET:90; LENGTH:9; DECIMAL:0;",
		"NAME:METR; TYPE:N; OFFSET:99; LENGTH:5; DECIMAL:1;",
		"NAME:MG; TYPE:N; OFFSET:104; LENGTH:5; DECIMAL:1;",
		"NAME:PL_K; TYPE:N; OFFSET:109; LENGTH:5; DECIMAL:1;",
		"NAME:ZEM; TYPE:N; OFFSET:114; LENGTH:7; DECIMAL:1;",
		"NAME:ETAJ; TYPE:N; OFFSET:121; LENGTH:2; DECIMAL:0;",
		"NAME:ETAJA; TYPE:N; OFFSET:123; LENGTH:2; DECIMAL:0;",
		"NAME:DOM; TYPE:C; OFFSET:125; LENGTH:2; DECIMAL:0;",
		"NAME:OB; TYPE:C; OFFSET:127; LENGTH:3; DECIMAL:0;",
		"NAME:SA; TYPE:C; OFFSET:130; LENGTH:4; DECIMAL:0;",
		"NAME:FO; TYPE:C; OFFSET:134; LENGTH:4; DECIMAL:0;",
		"NAME:SOST; TYPE:C; OFFSET:138; LENGTH:4; DECIMAL:0;",
		"NAME:T; TYPE:C; OFFSET:142; LENGTH:1; DECIMAL:0;",
		"NAME:INFO; TYPE:C; OFFSET:143; LENGTH:80; DECIMAL:0;",
		"NAME:N1; TYPE:N; OFFSET:223; LENGTH:8; DECIMAL:0;",
		"NAME:N2; TYPE:N; OFFSET:231; LENGTH:8; DECIMAL:0;",
		"NAME:TELEFON; TYPE:N; OFFSET:239; LENGTH:7; DECIMAL:0;",
		"NAME:FIRMA; TYPE:C; OFFSET:246; LENGTH:20; DECIMAL:0;",
		"NAME:MASIV; TYPE:C; OFFSET:266; LENGTH:25; DECIMAL:0;",
		"NAME:DATS; TYPE:D; OFFSET:291; LENGTH:8; DECIMAL:0;",
		"NAME:EX; TYPE:C; OFFSET:299; LENGTH:1; DECIMAL:0;",
		"NAME:S; TYPE:L; OFFSET:300; LENGTH:1; DECIMAL:0;",
		"NAME:KOD; TYPE:N; OFFSET:301; LENGTH:4; DECIMAL:0;"
	};
	
	public String[] getArrayOfColumns() {
		return ARRAY_OF_COLUMNS;
	}
	
	public RealEstateObjectList readData(byte[] bytes) throws ProgramException{
		RealEstateObjectList list = new RealEstateObjectList();
		DBFStructureRowReader reader = new DBFStructureRowReaderPD001();
		reader.read(bytes, list, this);
		return list;
	}
	
}
