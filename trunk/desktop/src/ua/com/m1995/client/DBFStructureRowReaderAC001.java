package ua.com.m1995.client;

import java.util.Collections;
import java.util.HashSet;
import java.util.Set;

/**
 * See also {@link DBFStructureAdapterAC001} 
 */
public class DBFStructureRowReaderAC001 extends DBFStructureRowReader001 {
	
	static final Set<String> columns;
	
	static {
		Set<String> columns1 = new HashSet<String>();
		columns1.add(ROOMS);
		columns1.add(ROOMS_TYPE);
		columns1.add(DISTRICT_OR_LOCATION);
		columns1.add(SUB_DISTRICT);
		columns1.add(STREET);
		columns1.add(HOUSE_NUMBER);
		columns1.add(PRICE);
		columns1.add(FLOOR);
		columns1.add(FLOORS);
		columns1.add(SQ_ALL);
		columns1.add(SQ_LIVE);
		columns1.add(SQ_LAND);
		columns1.add(INFORMATION);
		columns1.add(RENT_PERIOD);
		columns = Collections.unmodifiableSet(columns1);
	}
	
	protected Set<String> getListOfColumns() {
		return columns;
	}
	
	private static final String TYPE_SHORTLY = "NAZ";
	private static final String TYPE_FULL = "OB";
	private static final String RENT_OR_SELL = "FO";
	
	protected RealEstateObject readAnObject(byte[] bytes, int rowOffset, DBFStructureAdapter adapter) throws ProgramException {
		RealEstateObject object = super.readAnObject(bytes, rowOffset, adapter, columns);
		if (object != null) {
			
			DBFColumn column;
			
			column = adapter.getColumn(RENT_OR_SELL);
			String rentOrSell = column.readData(bytes, rowOffset).trim();
			
			if ("סהאל".equals(rentOrSell)) {
				object.setOperationType(UserInterfaceConstants.OPERATION_TYPE_RENT);
			} else if ("ןנמה".equals(rentOrSell)) {
				object.setOperationType(UserInterfaceConstants.OPERATION_TYPE_SELL);
			} else {
				Log.warn("Unknown operation type, (file 'AC'): " + rentOrSell);
				object.setOperationType(UserInterfaceConstants.OPERATION_TYPE_SELL);
			}
			
			column = adapter.getColumn(TYPE_FULL);
			String typeFull = column.readData(bytes, rowOffset).trim();
			
			column = adapter.getColumn(TYPE_SHORTLY);
			String type = column.readData(bytes, rowOffset).trim();
			
			if ("מפס".equals(type)) {
				object.setRealEstateType(INPUT_REAL_ESTATE_OBJECT_TYPE_COMMERCIAL);
			} else if ("חול".equals(type)) {
				object.setRealEstateType(INPUT_REAL_ESTATE_OBJECT_TYPE_LAND);
			} else if ("בען".equals(type)) {
				object.setRealEstateType(INPUT_REAL_ESTATE_OBJECT_TYPE_COMMERCIAL);
			} else if ("ןנן".equals(type)) {
				object.setRealEstateType(INPUT_REAL_ESTATE_OBJECT_TYPE_COMMERCIAL);
			} else {
				Log.warn("Unknown real estate object type, (file 'AC'): " + type);
				object.setRealEstateType(INPUT_REAL_ESTATE_OBJECT_TYPE_COMMERCIAL);
			}
			
			String description = typeFull + "; " + object.getDescription();
			object.setDescription(description);
			
			if (
					object.getOperationType().equals(UserInterfaceConstants.OPERATION_TYPE_RENT) &&
					object.getRealEstateType().equals(INPUT_REAL_ESTATE_OBJECT_TYPE_LAND)
			) {
				Log.warn("Unsupported combination: rent land");
			}
		}
		
		return object;		
	}

}
