package ua.com.m1995.client;

public class AdapterSelector {

	private static Class[] classes = {DBFStructureAdapterPK001.class, DBFStructureAdapterAK001.class, DBFStructureAdapterAC001.class, DBFStructureAdapterPD001.class};
	
	
	DBFStructureAdapter getAdapter(int columnsNumber, String signature) throws ProgramException {
		DBFStructureAdapter result = null;
		int n = classes.length;
		Class clazz;
		try {
			for(int i = 0; i < n; i++){
				clazz = classes[i];
				DBFStructureAdapter adapter = (DBFStructureAdapter) clazz.newInstance();
				if (adapter.getColumnsNumber() == columnsNumber) {
					if (adapter.getHeaderSignature().equals(signature)) {
						result = adapter;
						break;
					}
				}
			}
		} catch (InstantiationException e) {
			throw new ProgramException("Internal software error.", e);
		} catch (IllegalAccessException e) {
			throw new ProgramException("Internal software error.", e);
		}
		
		if (result == null) {
			throw new ProgramException(Messages.MESSAGE_INCORRECT_DBF_FORMAT + " [No such adapter]");
		}
		
		return result;
	}
	
}
