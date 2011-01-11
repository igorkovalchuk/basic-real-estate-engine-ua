package ua.com.m1995.client;

import java.io.File;

import javax.swing.filechooser.FileFilter;

public class OurFileFilter extends FileFilter {

	public String getDescription() {
		return "DBF files";
	}

	public boolean accept(File f) {
		if (f.isFile()) {
			if (f.getName().endsWith(".dbf")) {
				return true;
			}
		}
		if (f.isDirectory()) {
			return true;
		}
		return false;
	}

}
