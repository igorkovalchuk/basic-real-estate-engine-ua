package ua.com.m1995.table;

import java.awt.Dimension;
import java.util.HashMap;
import java.util.Map;

import javax.swing.JTable;
import javax.swing.table.AbstractTableModel;

import ua.com.m1995.client.RealEstateObject;
import ua.com.m1995.client.RealEstateObjectColumns;
import ua.com.m1995.client.RealEstateObjectList;

public class UserInterfaceTableModel extends AbstractTableModel {

	private static final long serialVersionUID = -1L;

	private static Map<Integer, RealEstateObjectColumns> columns = new HashMap<Integer, RealEstateObjectColumns>();
	
	private static final int COLUMNS_COUNT = 17; 
	
	static {
		columns.put(1, RealEstateObjectColumns.LOCATION_ID);
		columns.put(2, RealEstateObjectColumns.LOCATION_TEXT);
		columns.put(3, RealEstateObjectColumns.REAL_ESTATE_TYPE);
		columns.put(4, RealEstateObjectColumns.ROOMS);
		columns.put(5, RealEstateObjectColumns.ROOMS_TYPE);
		columns.put(6, RealEstateObjectColumns.PRICE);
		columns.put(7, RealEstateObjectColumns.CITY_DISTRICT);
		columns.put(8, RealEstateObjectColumns.CITY_SUB_DISTRICT);
		columns.put(9, RealEstateObjectColumns.STREET);
		columns.put(10, RealEstateObjectColumns.HOUSE_NUMBER);
		columns.put(11, RealEstateObjectColumns.SQUARE_ALL);
		columns.put(12, RealEstateObjectColumns.SQUARE_LIVE);
		columns.put(13, RealEstateObjectColumns.SQUARE_KITCHEN);
		columns.put(14, RealEstateObjectColumns.FLOOR);
		columns.put(15, RealEstateObjectColumns.FLOORS);
		columns.put(16, RealEstateObjectColumns.DESCRIPTION);
	}
	
	private static Map<Integer, String> columnsName = new HashMap<Integer, String>();
	
	static {
		columnsName.put(1, "Адреса,ID");
		columnsName.put(2, "Альтерн.");
		columnsName.put(3, "Тип нерух.");
		columnsName.put(4, "Кімнати");
		columnsName.put(5, "Розд");
		columnsName.put(6, "Ціна");
		columnsName.put(7, "Район");
		columnsName.put(8, "Масив");
		columnsName.put(9, "Вулиця");
		columnsName.put(10, "Будинок");
		columnsName.put(11, "Пл.заг.");
		columnsName.put(12, "Пл.житл.");
		columnsName.put(13, "Пл.кух.");
		columnsName.put(14, "Поверх");
		columnsName.put(15, "Поверхів");
		columnsName.put(16, "Додаткова інформація");
	}
	
	RealEstateObjectList list = null;
	
	UserInterfaceTableModel(RealEstateObjectList list) {
		this.list = list;
	}
	
	public static void setColumnsWidths(JTable jTable) {
		
		jTable.getTableHeader().setPreferredSize(new Dimension(950,30));
		
		jTable.getColumnModel().getColumn(0).setMaxWidth(1);
		jTable.getColumnModel().getColumn(1).setPreferredWidth(30); // id
		jTable.getColumnModel().getColumn(2).setPreferredWidth(55); // altern.
		jTable.getColumnModel().getColumn(3).setPreferredWidth(45); // type
		jTable.getColumnModel().getColumn(4).setPreferredWidth(15); // rooms
		jTable.getColumnModel().getColumn(5).setPreferredWidth(40); // rooms type
		jTable.getColumnModel().getColumn(6).setPreferredWidth(55); // price
		jTable.getColumnModel().getColumn(7).setPreferredWidth(45); // district
		jTable.getColumnModel().getColumn(8).setPreferredWidth(45); // sub-district
		jTable.getColumnModel().getColumn(9).setPreferredWidth(70); // street
		jTable.getColumnModel().getColumn(10).setPreferredWidth(40); // house
		
		jTable.getColumnModel().getColumn(11).setPreferredWidth(35); // square
		jTable.getColumnModel().getColumn(12).setPreferredWidth(35); // square
		jTable.getColumnModel().getColumn(13).setPreferredWidth(35); // square
		
		jTable.getColumnModel().getColumn(14).setPreferredWidth(20); // floor
		jTable.getColumnModel().getColumn(15).setPreferredWidth(20); // floors
		
		jTable.getColumnModel().getColumn(16).setPreferredWidth(360); // additional data
	}
	
	public int getColumnCount() {
		return COLUMNS_COUNT;
	}

	public Object getValueAt(int rowIndex, int columnIndex) {
		Object result = null;
		if (rowIndex >= list.size()) {
			result = "";
		} else {
			RealEstateObject object = list.get(rowIndex);
			RealEstateObjectColumns column = columns.get(columnIndex);
			if (column != null) {
				result = object.getValue(column,true);
			}
		}
		return result;
	}
	
    public void setValueAt(Object aValue, int rowIndex, int columnIndex) {
    }
	
	public int getRowCount() {
		return list.size();
	}
	
    public boolean isCellEditable(int rowIndex, int columnIndex) {
    	return false;
    }
	
    public String getColumnName(int column) {
    	String name = columnsName.get(column);
    	if (name == null)
    		name = "";
    	return name;
    }
    
}
