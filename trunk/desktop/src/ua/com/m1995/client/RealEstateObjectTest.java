package ua.com.m1995.client;

import junit.framework.TestCase;

public class RealEstateObjectTest extends TestCase {

	public static void main(String[] args) {
		junit.textui.TestRunner.run(RealEstateObjectTest.class);
	}
	
	protected void setUp() throws Exception {
		super.setUp();
	}

	protected void tearDown() throws Exception {
		super.tearDown();
	}

	public void testRegularExpressions() throws Exception {
		RealEstateObject object = new RealEstateObject();
		object.setDescription(
				",Description 1234567 123 1234 123-1234 81231234567 8123-1234567 123-45-67 ."
				//"1234567, 123 1234 123-1234 81231234567 8123-1234567 123-45-67"
		);
		
		object.removeTelephoneNumber();
		
		Log.debug(object.getDescription());
		
		boolean result = object.getDescription().matches(".*\\d.*");
		assertFalse(result);
		
		
	}
	
}
