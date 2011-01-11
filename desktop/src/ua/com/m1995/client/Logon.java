package ua.com.m1995.client;

import java.io.IOException;
import java.net.MalformedURLException;
import java.net.SocketException;
import java.net.UnknownHostException;

import org.xml.sax.SAXException;

import com.meterware.httpunit.HTMLElement;
import com.meterware.httpunit.HttpNotFoundException;
import com.meterware.httpunit.PostMethodWebRequest;
import com.meterware.httpunit.WebConversation;

import com.meterware.httpunit.WebRequest;
import com.meterware.httpunit.WebResponse;

public class Logon {

	    public static void logon(WebConversation wc) throws ProgramException {
	    	// HttpNotFoundException - incorrect URL;
	    	// UnknownHostException - incorrect host name;
	    	// SocketException - web server is turned off;
	    	try {
	    		WebRequest wr = new PostMethodWebRequest(Constants.FASCADE_URL);
	    		wr.setParameter("page", "admin");
	    		wr.setParameter(FormConstants.FORM_IDENTIFIER_LOGON_USER_NAME, Constants.USER_NAME);
	    		wr.setParameter(FormConstants.FORM_IDENTIFIER_LOGON_PASSWORD, Constants.USER_KEY);
	    		wr.setParameter(FormConstants.FORM_IDENTIFIER_LOGON_FLAG, "1");
	    		WebResponse response = wc.sendRequest(wr);
	    		
	    		// TODO Check the response;
	    		HTMLElement[] elements = response.getElementsWithName("logged");
	    		if (elements.length == 1) {
	    			HTMLElement element = elements[0];
	    			String value = element.getAttribute("value");
	    			if ( ! value.equals("yes")) {
	    				throw new ProgramException(Messages.MESSAGE_CANT_LOGIN);
	    			}
	    		} else {
	    			throw new ProgramException(Messages.MESSAGE_CANT_LOGIN);
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
	    
	    public static void logoff(WebConversation wc) throws ProgramException {
	    	try {
	    		WebRequest wr = new PostMethodWebRequest(Constants.FASCADE_URL);
	    		wr.setParameter("page", "admin");
	    		wr.setParameter("disconnect", "1");
	    		wc.sendRequest(wr);
	    		// TODO Check the response - seems it is not necessary;
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
}
