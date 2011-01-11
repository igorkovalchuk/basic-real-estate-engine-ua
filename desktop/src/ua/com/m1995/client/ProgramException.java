package ua.com.m1995.client;

public class ProgramException extends Exception {

	private static final long serialVersionUID = -1L;

	private String parentExceptionMessage = "";
	
    public ProgramException(String message) {
    	super(message);
    }

    public ProgramException(String message, Throwable cause) {
        super(message, cause);
    	if (cause != null) {
    		parentExceptionMessage = cause.getMessage();
    	}
    }

	public String getParentExceptionMessage() {
		return parentExceptionMessage;
	}

}
