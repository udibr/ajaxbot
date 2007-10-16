/* 
 * Licensed under the Apache License, Version 2.0 (the "License"); you may not
 * use this file except in compliance with the License. You may obtain a copy of
 * the License at
 * 
 * http://www.apache.org/licenses/LICENSE-2.0
 * 
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations under
 * the License.
 */
package com.br.client;


import com.google.gwt.json.client.JSONArray;
import com.google.gwt.json.client.JSONException;
import com.google.gwt.json.client.JSONObject;
import com.google.gwt.json.client.JSONParser;
import com.google.gwt.json.client.JSONString;
import com.google.gwt.json.client.JSONValue;


import com.google.gwt.user.client.HTTPRequest;
import com.google.gwt.user.client.ResponseTextHandler;
import com.google.gwt.user.client.Window;
import com.google.gwt.user.client.ui.Grid;
import com.google.gwt.user.client.ui.TextBox;
import com.google.gwt.user.client.ui.Button;
import com.google.gwt.user.client.ui.FocusPanel;
import com.google.gwt.user.client.ui.HTML;
import com.google.gwt.user.client.ui.ClickListener;
import com.google.gwt.user.client.ui.Widget;





public class JSONRequester {

/*
 *    The URL where we go to do the search. 
 */
	  private String DEFAULT_SEARCH_URL = "http://www.benreuven.com/udi/AIML/E/src/ajaxbot.php";
	  
/*
 *   Some widgets that we go to need.
 */	  
	  
	  private Button b1 = new Button();
	  private Grid gdOut = new Grid(2,1);
	  private Grid childGrid = new Grid(5,2);
	  private TextBox txtBox = new TextBox();
	  private int itemNumber = 0;
	  private String session_name=null;
	  private String session_uid=null;
	  
	  
	  public Widget initializeMainForm() {
		  
		  /*
		   *  Here we initialize and setup a panel for use it as container for the search form and
		   *  the results.
		   */
		  
		  FocusPanel fpn = new FocusPanel();
		  Grid gd = new Grid(1,2);
            
		  b1.setText("Search");
		  b1.addClickListener(new SearchButtonClickListener());
			
		  gd.setWidget(0, 0, txtBox); 
		  gd.setWidget(0, 1, b1);

		  gdOut.setWidget(0,0,gd);
		  
		  gdOut.setBorderWidth(1);
	      gdOut.setWidth("500px");
	      	      
	      childGrid.setCellPadding(0);
		  childGrid.setCellSpacing(0);
		  childGrid.setWidth("490px");
		  
	
		  fpn.add(gdOut);
		  
		  return fpn;
		  }
	  
    
	  private class SearchButtonClickListener implements ClickListener {
/*
 *  (non-Javadoc)
 * @see com.google.gwt.user.client.ui.ClickListener#onClick(com.google.gwt.user.client.ui.Widget)
 */
      public void onClick(Widget sender) {
    	  /*
    	   * When the user click the button we fetch the URL.
    	   */
		      itemNumber = 0;
		      doFetchURL();
		    }

	  
	  private void doFetchURL() {
				  /*
				   * Here we fetch the URL and call the handler
				   */	  
				  b1.setText("Searching ...");
				    String data = "input="+txtBox.getText();
					if (session_name != null)
							  data = data + "&" + session_name + "=" + session_uid;
				    if (!HTTPRequest.asyncPost(DEFAULT_SEARCH_URL, data, new JSONResponseTextHandler())) {
							  System.out.println(message);
							  Window.alert(DEFAULT_SEARCH_URL + " failed to post");
							  b1.setText("Search");
				    }
			}
	  }
	  
	  private class JSONResponseTextHandler implements ResponseTextHandler {
		  /*
		   *  (non-Javadoc)
		   * @see com.google.gwt.user.client.ResponseTextHandler#onCompletion(java.lang.String)
		   */  
		  
		  public void onCompletion(String responseText) {
		/*
		 *  When the fetch has been completed we parse the JSON response and
		 *  display the result
		 */	
			  JSONValue jsonObject;
		      try {
		        jsonObject = JSONParser.parse(responseText);
		        displayJSONObject(jsonObject);

		      } catch (JSONException e) {
						Window.alert(responseText);

		      }

		        b1.setText("Search");
		      	
		    }
		  
	  
	  
		    private void displayJSONObject(JSONValue jsonObject) {
		    /*
		     * Here we clear the grid and fill it with the new values.
		     */    
		    	childGrid.clear();
			    requestChildrenGrid(jsonObject);
		    	gdOut.setWidget(1,0,childGrid);
		    	
		      }
		    
		    private void requestChildrenGrid(JSONValue jsonValue){
		 
		    	/*
			     * Here we fill the grid.
			     */        	
		    	
		    	
		    JSONObject jsonObject;
		    if(jsonValue.isArray() != null){
		    	for(int i = 0; i < jsonValue.isArray().size();i++){
		    	requestChildrenGrid(jsonValue.isArray().get(i));
		    	childGrid.setWidget(itemNumber,0,new HTML("<HR/>"));
		        childGrid.setWidget(itemNumber,1,new HTML("<HR/>"));
		        
		  
		        itemNumber++;
		        int resizeNumber = itemNumber + 1;
		        childGrid.resize(resizeNumber,2);
		    	}
		    } else {
		    
		    	if ((jsonObject = jsonValue.isObject()) != null) {
		        Object[] keys = jsonObject.keySet().toArray();
		       
		        for (int i = 0; i < keys.length; ++i) {
		          String key = keys[i].toString();
		          childGrid.setWidget(itemNumber,0,new HTML("<B>"+ key  +":</B>"));
		          childGrid.setWidget(itemNumber,1,new HTML(jsonObject.get(key).toString()));
				  if (key=="session_name")
							session_name=jsonObject.get(key).toString();
					if (key=="session_uid")
							  session_uid=jsonObject.get(key).toString();
		          requestChildrenGrid(jsonObject.get(key));
		          
		          itemNumber++;
		          int resizeNumber = itemNumber + 1;
		          childGrid.resize(resizeNumber,2);
		        }
		      } else if (jsonValue != null) {
		        // Only JSONObject, and JSONArray do anything special with toString, so
		        // it is safe to handle all non-null cases by simply using toString
		        //
		       	  
		      } else {
		       // 
		      }
		    
		    
		    
		    }
		    
		    
		    }

}	  
	  
}