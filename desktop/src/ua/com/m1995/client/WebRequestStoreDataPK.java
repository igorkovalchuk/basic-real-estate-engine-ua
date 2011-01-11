package ua.com.m1995.client;

import java.io.IOException;
import java.net.MalformedURLException;
import java.net.SocketException;
import java.net.UnknownHostException;
import java.util.Iterator;
import java.util.Map;
import java.util.Set;

import org.xml.sax.SAXException;

import com.meterware.httpunit.HTMLElement;
import com.meterware.httpunit.HttpNotFoundException;
import com.meterware.httpunit.PostMethodWebRequest;
import com.meterware.httpunit.WebConversation;
import com.meterware.httpunit.WebRequest;
import com.meterware.httpunit.WebResponse;

public class WebRequestStoreDataPK {

	public static void store(WebConversation wc, RealEstateObject object) throws ProgramException{
		
		WebRequest wr = new PostMethodWebRequest(Constants.FASCADE_URL);
		wr.setParameter("page", "object");
		wr.setParameter("action", "submit");
		wr.setParameter("remote", "1");
		wr.setParameter("just_save", "just_save");

		if (Constants.DO_NOT_SAVE)
			wr.setParameter("do_not_save", "do_not_save");
		
		Map<String , String> data = RealEstateObjectMapper.toRequestPK(object);
		
		Set<Map.Entry<String,String>> entrySet = data.entrySet();
		Iterator <Map.Entry<String,String>> i = entrySet.iterator();
		
		while(i.hasNext()) {
			Map.Entry<String, String> entry = i.next();
			//Log.debug("DATA: " + entry.getKey() + " = " + entry.getValue());
			wr.setParameter(entry.getKey(), entry.getValue());
		}
		
		
		try {
			
			WebResponse response = wc.sendRequest(wr);

			// Log.debug(response.getText());
			
			HTMLElement[] elements = response.getElementsWithName("done");
    		if (elements.length == 1) {
    			// ok
    			Log.debug("Ok - stored to web.");
    			object.setErrorDescription(null);
    			
    		} else {
    			
    			object.setErrorDescription("Server side error");
    			
    			Map<String, String> map = FormConstants.getValidationPrefixes();
    			Iterator <Map.Entry<String,String>> j = map.entrySet().iterator();
    			
    			StringBuffer errors = new StringBuffer();
    			
    			while(j.hasNext()) {
    				Map.Entry<String, String> entry = j.next();
    				String key = "v_e_" + entry.getKey();
    				String message = entry.getValue();
    				
    				HTMLElement[] validationElements = response.getElementsWithName(key);
    				if (validationElements.length == 1) {
    					errors.append(message).append(";");
    					Log.error(object.toTestString());
    					Log.error(message);
    				}
    			}
    			
    			if (! errors.toString().equals("")) {
    				object.setErrorDescription(errors.toString());
    			}
    			
    			Log.debug("Error - storing to web.");
    			
    		}
    		
    		
 
    	} catch (HttpNotFoundException e) {
    		throw new ProgramException(Messages.MESSAGE_CANT_CONNECT_TO_SERVER, e);
    	} catch (UnknownHostException e) {
    		throw new ProgramException(Messages.MESSAGE_CANT_CONNECT_TO_SERVER, e);
    	} catch (SocketException e) {
    		throw new ProgramException(Messages.MESSAGE_CANT_CONNECT_TO_SERVER, e);
    	} catch (MalformedURLException e) {
    		throw new ProgramException(Messages.MESSAGE_CANT_CONNECT_TO_SERVER, e);
    	} catch (SAXException e) {
    		throw new ProgramException(Messages.MESSAGE_CANT_READ_SERVER_DATA, e);
    	} catch (IOException e) {
    		throw new ProgramException(Messages.MESSAGE_CANT_READ_SERVER_DATA, e);
    	}
    	
	}
	
    //WebForm form = response.getFormWithID( "pool" );
    //assertNotNull( "No form found with ID 'pool'", form );
    //assertEquals( "Number of submit buttons", 2, form.getSubmitButtons().length );    // (1) count the buttons
    //assertNotNull( "Save button not found", form.getSubmitButton( "save", "Save" ) ); // (2) look up by name
    //assertNotNull( "Open Pool button not found", form.getSubmitButton( "save", "Open Pool" ) );
	
}
