package
{
import flash.events.*;
import flash.media.Video;
import flash.events.NetStatusEvent;
import flash.display.Sprite;
import flash.net.NetConnection;
import flash.net.NetStream;
import flash.display.StageDisplayState;

public class recieveCaster extends Sprite{
private var rtmpStr:String;
//network properties
private var nc:NetConnection;

private var inStream:NetStream;
//private var outStream:NetStream;


//video properties

//wrapper components
private var inVideo:Video;
//private var outVideo:Video;

private var roomkey:String="Invalid Roomkey";
private var recordPath:String="rooms/"+roomkey;


public function recieveCaster()
{
	if(stage) {
		init();
	} else {
		addEventListener(Event.ADDED_TO_STAGE, init);
	}
}


private function init (e:Event=null):void {
	removeEventListener(Event.ADDED_TO_STAGE, init);
	rtmpStr="rtmp://elton-pc/Deliti";	

	
	var varName:String;
	var paramObj:Object = root.loaderInfo.parameters;
	for (varName in paramObj) {
		roomkey = String(paramObj[varName]);
		trace(roomkey);
	}

	
	recordPath="rooms/"+roomkey;	
	controls.txtRoomTitle.text="Roomkey: "+roomkey;
	
	btnPlay.addEventListener(MouseEvent.CLICK ,playBroadcast);
	controls.btnFullScreen.addEventListener(MouseEvent.CLICK,toggleFullScreen);
	controls.addEventListener(MouseEvent.ROLL_OVER,controlsShow);
	controls.addEventListener(MouseEvent.ROLL_OUT,controlsHide);
	
	nc=new NetConnection();
	nc.connect(rtmpStr); //localhost can be replaced with your LAN IP or remote server IP points to FMS server.
	nc.addEventListener (NetStatusEvent.NET_STATUS,onConnected);
}


private function onConnected(Event:NetStatusEvent):void {
	trace(Event.info.code);
	if (Event.info.code=="NetConnection.Connect.Success"){
		
		setupVideo();
		
	}

}


private function setupVideo():void {
	//setup outgoing devices

	
	//setup outgoing stream
	//outStream=new NetStream(nc);
	//outStream.attachCamera(camera);
	//outStream.attachAudio(microphone);
	//outStream.publish("rooms/room-12234","record");
	
	//setup outgoing video and attach outgoing devices
//	outVideo=new Video(360,240);
	//outVideo.attachCamera(camera);
	
	
		
	//setup incoming stream
	inStream=new NetStream(nc);
	inStream.play(recordPath);
	
	//setup incoming video and attach incoming stream
	inVideo=new Video(360,240);
	inVideo.attachNetStream(inStream);
	
	//wrap the video object
	
	
	
	//setup incoming video
}

private function attachVideoObjects(){

//	addChild(outVideo);
//	outVideo.x=0;
//	outVideo.y=0;

//	controls.parent.addChild(btnRecord);
	
	
	addChild(inVideo);
	inVideo.x=0;
	inVideo.y=0;
	controls.parent.addChild(controls);	
	controls.parent.addChild(btnPlay);
	
}



private function playBroadcast(e:Event):void {
		trace("PlayLiveCast");
		attachVideoObjects();
		controls.txtStatus.text="Playing Broadcast";
		btnPlay.visible=false;
}

private function toggleFullScreen(e:Event):void {
		
		if (stage.displayState == StageDisplayState.NORMAL) {
			stage.displayState = StageDisplayState.FULL_SCREEN; 
			trace("full screen on normal");
    	} else {
			stage.displayState = StageDisplayState.NORMAL;
			trace("full screen on full");
		}

}



private function controlsShow(e:Event):void {
	controls.alpha=100;
}

private function controlsHide(e:Event):void {
	controls.alpha=0;
}



}
}