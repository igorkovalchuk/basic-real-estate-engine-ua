package ua.com.m1995.client;



import java.io.BufferedReader;
import java.io.FileNotFoundException;
import java.io.IOException;
import java.io.InputStreamReader;
import java.util.Iterator;

import javax.swing.JOptionPane;
import javax.swing.UIManager;
import javax.swing.UnsupportedLookAndFeelException;

import ua.com.m1995.table.UserInterfaceTable;

import com.meterware.httpunit.WebConversation;

public class Start {

	public static void main(String[] args) {
		
		getAndUnarchiveFiles();
		
		//setLookAndFeel();
		
		action();
	}
	
		
	public static void action() {
		
		String fileName = "";
		
		try {
		
			//if(true)
				//System.exit(0);
			
			DBFFileByteReader reader = new DBFFileByteReader();
			
			byte[] bytes = reader.start();
			
			if (bytes == null) {
				JOptionPane.showMessageDialog(null, "Ви натиснули CANCEL. Вихід з програми.");
				System.exit(0);
			}
			
			Log.debug("File reading, done.");
			
			DBFStructureHeaderReader structure = new DBFStructureHeaderReader();
			DBFStructureAdapter dbfAdapter = structure.init(bytes);
			Log.debug("Reading DBF header structure, done.");
			
			RealEstateObjectList list = dbfAdapter.readData(bytes);
			
			if (list.size() == 0)
				System.exit(0);
			
			fileName = reader.getFileName();
			
			list.removeTelephoneNumbers();
			
			UserInterfaceTable.use(list, fileName);

		} catch(FileNotFoundException e) {
			e.printStackTrace();
			Log.error(e);
			new ExceptionDialog(e);
		} catch(ProgramException e) {
			e.printStackTrace();
			Log.error(e);
			new ExceptionDialog(e);
		}
		
	}


	public static RealEstateObjectList storeData(RealEstateObjectList list) {

		ProgressData pData = new ProgressData();
		
		pData.max = list.size();
		
		ThreadStopWatch.use(pData);
		
		Iterator<RealEstateObject> i = list.iterator();
		while(i.hasNext()) {
			RealEstateObject object = i.next();
			object.setErrorDescription("Загальна помилка запису на сервер.");
		}
		
		int progress = 0;
		try {
		
			WebConversation webConversation = new WebConversation();
			Logon.logon(webConversation);
			Log.debug("Logon, done.");
			
			i = list.iterator();
			
			while(i.hasNext()) {
				
				
				RealEstateObject object = i.next();
				Log.debug("Store: " + object.toTestString());
				WebRequestStoreDataPK.store(webConversation, object);
				
				progress++;
				pData.now = progress;
				
				if (progress == 5) {
					// break;
				}
			}
		
			Logon.logoff(webConversation);
		
		} catch(ProgramException e) {
			new ExceptionDialog(e);
		}
		
		pData.active = false;
		
		RealEstateObjectList notStored = new RealEstateObjectList();
		i = list.iterator();
		
		while(i.hasNext()) {
			RealEstateObject object = i.next();
			if (object.getErrorDescription() != null) {
				notStored.add(object);
			}
		}
		
		//notStored.add(list.get(0)); // Test.
		
		return notStored;
	}
	
	private static void setLookAndFeel() {
		
		try {
			UIManager.setLookAndFeel("com.sun.java.swing.plaf.windows.WindowsLookAndFeel");
		} catch (UnsupportedLookAndFeelException e) {
			//throw new RuntimeException(e);
		} catch (IllegalAccessException e) {
			//throw new RuntimeException(e);
		} catch (InstantiationException e) {
			//throw new RuntimeException(e);
		} catch (ClassNotFoundException e) {
			//throw new RuntimeException(e);
		}
	}
	
	private static void getAndUnarchiveFiles() {
		
		try {
			
			Process p = Runtime.getRuntime().exec(Constants.USER_UNARCHIVER);
			
			String line;
			
			BufferedReader is = new BufferedReader(new InputStreamReader(p.getInputStream()));
			
			while( (line = is.readLine()) != null ) {
				Log.debug(line);
			}
			
			try {
				p.waitFor();
			} catch (InterruptedException e) {
				e.printStackTrace();
				Log.error(e);
			}
			
		} catch (IOException e) {
			e.printStackTrace();
			Log.error(e);
		}
		
		// Log.debug(Thread.currentThread().getId() + " - thread id");
		
		/*
		try { 
			Thread.sleep(5000);
		} catch (InterruptedException e) {
			e.printStackTrace();
			Log.error(e);
		}
		*/
		
	}
	
	
}
