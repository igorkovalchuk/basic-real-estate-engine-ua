package ua.com.m1995.client;

import java.util.Iterator;
import java.util.LinkedList;

public class RealEstateObjectList extends LinkedList<RealEstateObject> {
	
	static final long serialVersionUID = -1;
	
	void removeTelephoneNumbers() {
		Iterator<RealEstateObject> i = this.iterator();
		while(i.hasNext()) {
			RealEstateObject object = i.next();
			object.removeTelephoneNumber();
		}
	}
	
	public RealEstateObjectList lightClone() {
		RealEstateObjectList newList = new RealEstateObjectList();
		Iterator<RealEstateObject> i = this.iterator();
		while(i.hasNext()) {
			newList.add(i.next());
		}
		return newList;
	}
	
}
