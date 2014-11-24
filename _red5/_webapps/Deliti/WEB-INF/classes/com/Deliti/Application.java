package com.Deliti;
import java.io.*;
import java.util.List;
import org.red5.server.adapter.ApplicationAdapter;
import org.red5.server.api.so.ISharedObject;
import org.red5.server.api.IClient;
import org.red5.server.api.IConnection;
import org.red5.server.api.IScope;

public class Application extends ApplicationAdapter {

      private IScope appScope;

	ISharedObject line_SO;


      /** {@inheritDoc} */
   
      public boolean connect(IConnection conn, IScope scope, Object[] params) {

		//connecting to the app for the first time

            appScope = scope;
            return true;

      }

      /** {@inheritDoc} */

    
      public void disconnect(IConnection conn, IScope scope) {

            super.disconnect(conn, scope);

      }
  


	public Boolean appStart() {

		//creating a sharedobject on the sending client
	
		createSharedObject(appScope, "line_SO",true);

		return true;
	}

	/* param[0] = mode( drawing or moving ),
	    	 * param[1] = color, 
	    	 * param[2] = thickness, 
	    	 * param[3] = xmouse, 
	    	 * param[4] = ymouse
    	 */


	//creating a sharedobject on the server

	public void onLineDraw(Object[] params){

		line_SO = getSharedObject(appScope,"line_SO");

		line_SO.setAttribute("point",params[0].toString()+"~"+params[1].toString()+"~"+params[2].toString()+"~"+params[3].toString()+"~"+params[4].toString()+"~"+params[5].toString());
		
	}

}
