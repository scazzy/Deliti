// ActionScript file
import mx.utils.Delegate;
import flash.events.*;
import flash.net.*;



var dragged=false;
var roomkey = trace(roomkey);
if(roomkey=="" || roomkey==null) {roomkey="Demo";}
_root.txtRoomkey.text=roomkey;
var currentRoomkey=_root.txtRoomkey.text;
trace(roomkey);


var nc:NetConnection=new NetConnection();
//nc.addEventListener(NetStatusEvent.NET_STATUS, netStatusHandler);

//
function connect():Boolean {
		
	
	this.nc = new NetConnection();
	this.nc.onStatus = Delegate.create(this, this.ncOnStatus);

	var connected:Boolean = this.nc.connect("rtmp://elton-pc/Deliti");	
	trace("connected: "+connected);
	
	//light.gotoAndStop(2);
	light.updateStatus();
	return connected;
	
}
function disconnect() {
	light.updateStatus();
	this.nc.close();
}

// status for the netconnection
function ncOnStatus(obj:Object):Void {
	//tt("NetConnection.onStatus", obj);
	light.updateStatus();
}
connect();

//

trace(currentRoomkey);
//From the sender client
lineThickness=4;
selectedColor="0xFFFFFF";

_root.onMouseDown=startDrawing;
_root.onMouseUp=stopDrawing;
_root.mcToolBox.btnClear.onRelease=clearDrawing;

/* param[0] = mode( drawing or moving ),
    	 * param[1] = mouse event mode( 0, 1 , 2..) 
    	 * param[2] = color, 
    	 * param[3] = thickness, 
    	 * param[4] = xmouse, 
    	 * param[5] = ymouse
*/

function startDrawing() {
	if(_ymouse>10 and _ymouse<230 and _xmouse>10 and _xmouse<580) {
		currentRoomkey=_root.txtRoomkey.text;	
		//nc.call("function name on server java file",always NULL, parameters,..)
		nc.call("onLineDraw",null, "START-LINE",selectedColor,lineThickness,this._xmouse, this._ymouse,currentRoomkey);
		_root.lineStyle(lineThickness,selectedColor);
		_root.moveTo(_root._xmouse,_root._ymouse);
		_root.onMouseMove=drawLine;
	}
}

function drawLine() {
	//if(_ymouse<250 and _ymouse>0 and _xmouse>0 and _xmouse<552 ) {
		dragged=true;
		nc.call("onLineDraw",null,"DRAW-LINE",selectedColor,lineThickness,this._xmouse, this._ymouse,currentRoomkey);
		_root.lineTo(this._xmouse,this._ymouse);
	//}
	
}

function stopDrawing() {
	dragged=false;
	nc.call("onLineDraw",null, "STOP-LINE",selectedColor,lineThickness,this._xmouse, this._ymouse,currentRoomkey);
	delete this.onMouseMove;
	
}

function clearDrawing() {
	_root.clear();
	nc.call("onLineDraw",null, "CLEAR-BOARD",selectedColor,lineThickness,this._xmouse, this._ymouse,currentRoomkey);
	
}











//////

///this part is while receiving the data from the server
if(!dragged) {
var line_SO:SharedObject; 

//to the recievers machine
connect();
line_SO = SharedObject.getRemote("line_SO", nc.uri);
//Creating instance of remote option

trace("outside sync");

var receivedRoomkey;
  line_SO.onSync = function (infoList) {
  currentRoomkey=_root.txtRoomkey.text;
    for (var i in infoList) 
	{
      var info = infoList[i];
	  trace("inside sync");
      switch (info.code) 
	  {
        case "change":
          var id = info.name;
          trace("User connected with id: " + id);
          //trace("and name: " + line_SO.data[id]);
		  var dataFromServer=line_SO.data[id];
		  trace("Params: "+dataFromServer);
		  
		 	var todrawData:Array = dataFromServer.split("~");
			receivedRoomkey=todrawData[5];
			
			trace("currentRoomkey-"+currentRoomkey+", receivedRoomkey-"+receivedRoomkey);
		//checking the room
		if(receivedRoomkey==currentRoomkey) {
			
			var lineAction = todrawData[0];
			var color=todrawData[1]; 
			var thick=todrawData[2]; 
			var lineX = Number(todrawData[3]);
			var lineY = Number(todrawData[4]); 
			

			trace(lineX+","+lineAction+","+receivedRoomkey);
					if (lineAction=="START-LINE") {
						_root.lineStyle(thick,color);
						_root.moveTo(lineX,lineY);
						_root.lineTo(lineX,lineY);
					}
					else if(lineAction=="DRAW-LINE"){
						_root.lineTo(lineX,lineY);
					}
					else if(lineAction=="CLEAR-BOARD"){
						_root.clear();
					}
					else if(lineAction=="STOP-LINE"){
						delete _root.onMouseMove;
					}
		}
			break;
        case "delete":
          var id = info.name;
          trace("User disconnected with id: " + id);
          break;
      }
    }  
  };
line_SO.connect(nc);
}

