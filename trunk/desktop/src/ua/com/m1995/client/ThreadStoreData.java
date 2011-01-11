package ua.com.m1995.client;

import java.io.File;

import javax.swing.JOptionPane;


import ua.com.m1995.table.UserInterfaceTable;

public class ThreadStoreData {

	Thread thrd;
	
	public ThreadStoreData(RealEstateObjectList currentList, String fileName) {
		
		final RealEstateObjectList currentListFinal = currentList;
		final String fileNameFinal = fileName;
		
		Runnable myThread = new Runnable() {
			
			public void run() {
				
				RealEstateObjectList notStored = Start.storeData(currentListFinal);
				
				if (notStored.size() > 0) {
					UserInterfaceTable.use(notStored, fileNameFinal);
				} else {
					JOptionPane.showMessageDialog(null, "Ваші дані збережено.");
					( new File(fileNameFinal) ).renameTo(new File(fileNameFinal + ".tmp"));
					Log.debug("Exit, because all data has been stored.");
					Start.action();
				}
				
			}
			
		};

		thrd = new Thread(myThread);
		thrd.start();
	}
	
	
}
