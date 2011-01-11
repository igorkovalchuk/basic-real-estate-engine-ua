package ua.com.m1995.client;

import java.util.Collections;
import java.util.HashSet;
import java.util.Set;

/**
 * See also {@link DBFStructureAdapterAK001} 
 */
public class DBFStructureRowReaderAK001 extends DBFStructureRowReader001 {
	
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
		columns1.add(SQ_KITCHEN);
		columns1.add(INFORMATION);
		columns1.add(RENT_PERIOD);
		columns = Collections.unmodifiableSet(columns1);
	}
	
	protected Set<String> getListOfColumns() {
		return columns;
	}
	
	protected RealEstateObject readAnObject(byte[] bytes, int rowOffset, DBFStructureAdapter adapter) throws ProgramException {
		RealEstateObject object = super.readAnObject(bytes, rowOffset, adapter, columns);
		if (object != null) {
			object.setOperationType(UserInterfaceConstants.OPERATION_TYPE_RENT);
			object.setRealEstateType(INPUT_REAL_ESTATE_OBJECT_TYPE_FLAT);
		}
		return object;		
	}

}
