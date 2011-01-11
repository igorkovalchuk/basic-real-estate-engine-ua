package ua.com.m1995.client;

public class Constants {

	static final boolean DEVELOPMENT = false;
	
	/**
	 * Testing mode, don't change the database.
	 */
	static final boolean DO_NOT_SAVE = false;
	
	static final String USER_WORK_BASE_DIR = "c:/agency-tov-m/";
	
	static final String USER_UNARCHIVER = "cmd /c " + USER_WORK_BASE_DIR + "agency.bat";
	
	static final String USER_DIRECTORY = USER_WORK_BASE_DIR + "agencydata";
	
	static final String USER_ERROR_FILE = USER_WORK_BASE_DIR + "error.log"; 
	
	//static final String FASCADE_URL = "http://localhost/test/index.php";
	//static final String USER_NAME = "ktki";
	//static final String USER_KEY = "pPoclheetly-3";
	
	static final String FASCADE_URL = "http://www.anm.ho.ua/index.php";
	static final String USER_NAME = "ktki";
	static final String USER_KEY = "gjktnGxtks-3";
	
	/**
	 * Logging level. Where 0 = off, 1 = error, 2 = warn, 3 = info, 4 = debug;
	 */
	static final int LOGGING_LEVEL = 3;
	
}
