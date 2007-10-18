package com.benreuven.chat.client;

import com.google.gwt.core.client.EntryPoint;
import com.google.gwt.user.client.ui.TabPanel;
import com.google.gwt.user.client.ui.RootPanel;

/**
 * Entry point classes define <code>onModuleLoad()</code>.
 */
public class chat implements EntryPoint {

  /**
   * This is the entry point method.
   */
	  public void onModuleLoad() {

	/*
	 * Just for fun we use a TabPanel as layout 
	 */		  
		    TabPanel tp = new TabPanel();
			JSONRequester myJson = new JSONRequester();
			

			
			tp.add(myJson.initializeMainForm()  ,"Corporate Directory");

			
			tp.selectTab(0);

			RootPanel.get().add(tp);
			
			
		  }
		  
}
