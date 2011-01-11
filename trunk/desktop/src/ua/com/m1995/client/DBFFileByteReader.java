package ua.com.m1995.client;

import java.io.File;
import java.io.FileInputStream;
import java.io.FileNotFoundException;
import java.io.IOException;
import java.io.InputStream;

import javax.swing.JFileChooser;

public class DBFFileByteReader {

    private byte[] getBytesFromFile(File file) throws  FileNotFoundException, ProgramException {
        InputStream is;
        
        is = new FileInputStream(file);

        long length = file.length();
    
        if (length > Integer.MAX_VALUE) {
            throw new ProgramException(Messages.MESSAGE_FILE_TOO_BIG);
        }
            
        byte[] bytes = new byte[(int)length];
    
        int offset = 0;
        int numRead = 0;
        
        try {
        
        	while (offset < bytes.length
        			&& (numRead=is.read(bytes, offset, bytes.length-offset)) >= 0) {
        		offset += numRead;
        	}
    
        	// Ensure all the bytes have been read in
        	if (offset < bytes.length) {
        		throw new ProgramException(Messages.MESSAGE_CANT_READ_FILE + " " + file.getName());
        	}
           	is.close();     
       	} catch (IOException exc) {
       		throw new ProgramException(Messages.MESSAGE_CANT_READ_FILE, exc);
        }

        return bytes;
    }

    private String chooseFile() {
    	
    	if (Constants.DEVELOPMENT)
    		return Constants.USER_DIRECTORY + "/1211pk.dbf";
    	
    	String result = null;
    	JFileChooser fileChooser = new JFileChooser();
    	OurFileFilter fileFilter = new OurFileFilter();
		fileChooser.addChoosableFileFilter(fileFilter);
		fileChooser.setCurrentDirectory(new File(Constants.USER_DIRECTORY));
		int value = fileChooser.showOpenDialog(null);
		if (value == JFileChooser.APPROVE_OPTION) {
			result = fileChooser.getSelectedFile().getPath();
		}
		return result;
    }
    
	public byte[] start() throws ProgramException, FileNotFoundException {
		DBFFileByteReader object = new DBFFileByteReader();
		String path = object.chooseFile();
		if (path != null) {
			this.path = path;
			byte[] bytes = this.getBytesFromFile(new File(path));
			Log.debug("Bytes in file: " + bytes.length);
			return bytes;
		} else {
			//throw new ProgramException(Messages.MESSAGE_INCORRECT_PATH);
			return null;
		}
	}

	private String path = "";

	String getFileName() {
		Log.debug(path);
		return path;
	}

}
