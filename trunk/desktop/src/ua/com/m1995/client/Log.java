package ua.com.m1995.client;

import java.io.BufferedWriter;
import java.io.FileWriter;
import java.io.IOException;

public class Log {
	
	public static void error(Object message) {
		if (Constants.LOGGING_LEVEL >= 1)
			print("[ERROR]" + message, 1);
	}

	public static void warn(Object message) {
		if (Constants.LOGGING_LEVEL >= 2)
			print("[WARNING] " + message, 2);
	}

	public static void info(Object message) {
		if (Constants.LOGGING_LEVEL >= 3)
			print("[INFO] " + message, 3);
	}

	public static void debug(Object message) {
		if (Constants.LOGGING_LEVEL >= 4)
			print("[DEBUG] " + message, 4);
	}

	private static void print(Object message, int level) {
		System.out.println(message + " [" + ( new java.util.Date() ).toString() + "]" );
		
		if (message == null)
			return;
		
		if (level <= 2) {
			 try {
			    BufferedWriter out = new BufferedWriter(new FileWriter(Constants.USER_ERROR_FILE, true));
			    out.write(message.toString() + "\n");
			    out.close();
			 } catch (IOException e) {
			    	e.printStackTrace();
			 }
		}
	}

}
