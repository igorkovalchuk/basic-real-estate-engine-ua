package ua.com.m1995.table;

import java.awt.Dimension;
import java.awt.FlowLayout;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;

import javax.swing.JButton;
import javax.swing.JFrame;
import javax.swing.JOptionPane;
import javax.swing.JScrollPane;
import javax.swing.JTable;
import javax.swing.ListSelectionModel;

import ua.com.m1995.client.Log;
import ua.com.m1995.client.ProgressData;
import ua.com.m1995.client.RealEstateObject;
import ua.com.m1995.client.RealEstateObjectList;
import ua.com.m1995.client.ThreadStopWatch;
import ua.com.m1995.client.ThreadStoreData;

public class UserInterfaceTable {

	private JTable jTable;
	private JButton jButtonStore;
	private JButton jButtonClose;
	private JButton jButtonEdit;
	private JButton jButtonDelete;

	UserInterfaceTable(RealEstateObjectList list) {
		
		String fileNameShort = "";
		if (fileName.length() >= 80) {
			int length = fileName.length();
			fileNameShort = fileName.substring(0, 34) + " ... " + fileName.substring(length - 45, length); 
		} else {
			fileNameShort = fileName;
		}
		
		final JFrame jFrame = new JFrame("Агентство нерухомості ТОВ \"Михаїл\" " + " -  " + fileNameShort);
		
		final RealEstateObjectList currentList = list;
		
		jFrame.getContentPane().setLayout(new FlowLayout());
		jFrame.setSize(1000,700);
		jFrame.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
		
		jTable = new JTable(new UserInterfaceTableModel(list));
		
		UserInterfaceTableModel.setColumnsWidths(jTable);
		
		// jTable.setAutoResizeMode(JTable.AUTO_RESIZE_ALL_COLUMNS);
		jTable.setAutoResizeMode(JTable.AUTO_RESIZE_LAST_COLUMN);
		// jTable.setAutoResizeMode(JTable.AUTO_RESIZE_NEXT_COLUMN);
		// jTable.setAutoResizeMode(JTable.AUTO_RESIZE_SUBSEQUENT_COLUMNS);
		// jTable.setAutoResizeMode(JTable.AUTO_RESIZE_OFF);
		
		jTable.setSelectionMode(ListSelectionModel.SINGLE_SELECTION);
		
		JScrollPane jScrollPane = new JScrollPane(jTable);
		
		jTable.setPreferredScrollableViewportSize( new Dimension(950,600) );
		
		jFrame.getContentPane().add(jScrollPane);
		
		
		/*
		ListSelectionModel listSelectionModel = jTable.getSelectionModel();
		
		listSelectionModel.addListSelectionListener( new ListSelectionListener() {
			public void valueChanged(ListSelectionEvent event) {
				if (! event.getValueIsAdjusting()) {
					int row = jTable.getSelectedRow();
					Log.debug("Selected: " + row);
					RealEstateObject object = listStatic.get(row);
					UserInterfaceObjectEditor editor = new UserInterfaceObjectEditor(object);
					editor.initNewWindow();
				}
			}
		});
		*/
		
		JButton jButtonTest = new JButton("Test");
		jButtonTest.addActionListener( new ActionListener(){

			public void actionPerformed(ActionEvent event) {
				
				final ProgressData pData = new ProgressData();
				
				ThreadStopWatch.use(pData);
				
				pData.max = 100;
				for (int i = 0; i<1000; i++ ) {
					pData.now = i;
					
					for (int j = 0; j<1000000; j++ ) {
						j++;j--;
					}
					//try {Thread.currentThread().sleep(100);}catch(Exception e) {}
				}
				
				//Progress.use();
			}

		});
		jFrame.add(jButtonTest);
		
		
		jButtonEdit = new JButton("Редагувати");
		jButtonEdit.addActionListener( new ActionListener(){
				public void actionPerformed(ActionEvent event) {
					Log.debug("Button: Edit");
					
					int row = jTable.getSelectedRow();
					Log.debug("Selected: " + row);
					if (row != -1) {
						RealEstateObject object = listStatic.get(row);
						UserInterfaceObjectEditor editor = new UserInterfaceObjectEditor(object);
						editor.initNewWindow();
					}
					
				}
			}
		);
		jFrame.add(jButtonEdit);
		
		jButtonDelete = new JButton("Видалити");
		jButtonDelete.addActionListener( new ActionListener(){
				public void actionPerformed(ActionEvent event) {
					int result = JOptionPane.showConfirmDialog(jFrame, "Видалити об'єкт зі списку ?", "", JOptionPane.YES_NO_OPTION);
					Log.debug("Button: Delete" + " " + result);
					if (result == 1) {
						return;
					}
					int row = jTable.getSelectedRow();
					Log.debug("Selected: " + row);
					if (row != -1) {
						listStatic.remove(row);
						jTable.repaint();
					}
					
				}
			}
		);
		jFrame.add(jButtonDelete);

		jButtonStore = new JButton("Запис в Базу Даних");
		jButtonStore.addActionListener( new ActionListener(){
				public void actionPerformed(ActionEvent event) {
					jFrame.dispose();
					Log.debug("Button: Store");
					
					//new ExceptionDialog(new Exception("Message...."));
					
					new ThreadStoreData(currentList, fileName);
					/*
					RealEstateObjectList notStored = Start.storeData(currentList);
					
					if (notStored.size() > 0) {
						UserInterfaceTable.use(notStored, fileName);
					} else {
						JOptionPane.showMessageDialog(null, "Ваші дані збережено.");
						( new File(fileName) ).renameTo(new File(fileName + ".tmp"));
						Log.debug("Exit, because all data has been stored.");
						Start.action();
					}
					*/
				}
			}
		);
		jFrame.add(jButtonStore);
		
		jButtonClose = new JButton("Вихід");
		jButtonClose.addActionListener( new ActionListener(){
				public void actionPerformed(ActionEvent event) {
					int result = JOptionPane.showConfirmDialog(jFrame, "Вийти з програми ?", "", JOptionPane.YES_NO_OPTION);
					Log.debug("Button: Exit" + " " + result);
					if (result == 1) {
						return;
					}
					jFrame.dispose();
					System.exit(0);
				}
			}
		);
		jFrame.add(jButtonClose);
				
		jFrame.setVisible(true);
	}


	static RealEstateObjectList listStatic = null;
	
	static String fileName;
	
	public static void use(RealEstateObjectList list, String fileName) {
		
		listStatic = list;
		UserInterfaceTable.fileName = fileName;
		
		//SwingUtilities.invokeLater(
			//	new Runnable() {
				//	public void run() {
						new UserInterfaceTable(listStatic);
					//}
				//}
		//);
	}
	
}
