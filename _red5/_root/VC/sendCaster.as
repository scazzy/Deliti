//broadcaster
package
{
import flash.events.*;
import flash.media.Camera;
import flash.media.Microphone;
import flash.media.Video;
import flash.events.NetStatusEvent;
import flash.display.Sprite;
import flash.net.NetConnection;
import flash.net.NetStream;
import flash.display.StageDisplayState;

public class sendCaster extends Sprite{
private var rtmpStr:String;

//network properties
private var nc:NetConnection;

//private var inStream:NetStream;
private var outStream:NetStream;

//device properties
private var camera:Camera;
private var microphone:Microphone;

//video properties

//wrapper components
//private var inVideo:Video;
private var outVideo:Video;

private var roomkey:String="Invalid Roomkey";
private var recordPath:String="rooms/"+roomkey;


public function sendCaster()
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
	
	
		
	
	nc=new NetConnection();
	nc.connect(rtmpStr); //localhost can be replaced with your LAN IP or remote server IP points to FMS server.
	nc.addEventListener (NetStatusEvent.NET_STATUS,onConnected);
	
	btnRecord.addEventListener(MouseEvent.CLICK, recordLiveCast);
	btnPlay.addEventListener(MouseEvent.CLICK ,donotRecordAndPlay);
	controls.btnResumePlay.addEventListener(MouseEvent.CLICK ,playLiveCast);
	controls.btnPause.addEventListener(MouseEvent.CLICK, pauseLiveCast);
	controls.btnFullScreen.addEventListener(MouseEvent.CLICK,toggleFullScreen);
	controls.btnMicOpen.addEventListener(MouseEvent.CLICK,openMicrophone);
	controls.btnMicMute.addEventListener(MouseEvent.CLICK,muteMicrophone);

	controls.addEventListener(MouseEvent.ROLL_OVER,controlsShow);
	controls.addEventListener(MouseEvent.ROLL_OUT,controlsHide);
	
	controls.btnResumePlay.visible=false;
	controls.btnPause.visible=false;
	
	
}


private function onConnected(Event:NetStatusEvent):void {
	trace(Event.info.code);
	if (Event.info.code=="NetConnection.Connect.Success"){
		
		setupVideo();
		
	}

}


private function setupVideo():void {
	//setup outgoing devices
	attachCamera();	
	attachMicrophone();
	//microphone=Microphone.getMicrophone();
	
	//setup outgoing stream
	outStream=new NetStream(nc);
	//outStream.attachCamera(camera);
	//outStream.attachAudio(microphone);
	//outStream.publish("rooms/room-12234","record");
	
	//setup outgoing video and attach outgoing devices
	outVideo=new Video(360,240);
	//outVideo.attachCamera(camera);
	
		
	//setup incoming stream
//	inStream=new NetStream(nc);
//	inStream.play("rooms/stephen");
	
	//setup incoming video and attach incoming stream
//	inVideo=new Video(100,100);
//	inVideo.attachNetStream(inStream);
	
	//wrap the video object
	attachVideoObjects();
	
	
	//setup incoming video
}



private function attachCamera(){
camera=Camera.getCamera();
camera.setQuality (0,80);
camera.setKeyFrameInterval (9);
camera.setMode (360,240,15);
}

private function attachMicrophone(){

microphone=Microphone.getMicrophone();
microphone.gain=80;
microphone.rate=12;
microphone.setSilenceLevel(15,2000);
}

private function attachVideoObjects(){

	addChild(outVideo);
	outVideo.x=0;
	outVideo.y=0;
	controls.parent.addChild(controls);
	controls.parent.addChild(btnRecord);
	controls.parent.addChild(btnPlay);
	
	
//	addChild(inVideo);
//	inVideo.x=400;
//	inVideo.y=100;
}



private function recordLiveCast(e:Event):void {
		//outStream=new NetStream(nc);
		outVideo.attachCamera(camera);
		outStream.attachCamera(camera);
		outStream.attachAudio(microphone);
		outStream.publish(recordPath,"record");
		controls.txtStatus.text="Recording LiveCast...";
		trace("RecordLiveCast");
		
		controls.btnResumePlay.visible=false;
		controls.btnPause.visible=false;
		btnRecord.visible=false;
		btnPlay.visible=false;

		
}

private function donotRecordAndPlay(e:Event):void {
		trace("PlayLiveCast");
		//outStream=new NetStream(nc);
		outVideo.attachCamera(camera);
		outStream.attachCamera(camera);
		outStream.attachAudio(microphone);
		outStream.publish(recordPath,"live");
		//outStream.resume();
		controls.txtStatus.text="Playing LiveCast";
		controls.btnResumePlay.visible=false;
		controls.btnPause.visible=true;
		btnRecord.visible=false;
		btnPlay.visible=false;

}


private function playLiveCast(e:Event):void {
		trace("PlayLiveCast");
		//outStream=new NetStream(nc);
		outVideo.attachCamera(camera);
		outStream.attachAudio(microphone);
		//outStream.attachCamera(camera);
		outStream.publish(recordPath,"live");
		//outStream.resume();
		controls.txtStatus.text="Playing LiveCast";
		controls.btnResumePlay.visible=false;
		controls.btnPause.visible=true;
}
private function pauseLiveCast(e:Event):void {
		trace("PauseLiveCast");
		outVideo.attachCamera(null);
		outStream.attachAudio(null);
		//outStream.attachCamera(null);
		outStream.pause();
		outStream.close();
		
		
		controls.txtStatus.text="LiveCast Paused";
		controls.btnResumePlay.visible=true;
		controls.btnPause.visible=false;
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
private function openMicrophone(e:Event):void {
	outStream.attachAudio(microphone);
	controls.btnMicMute.visible=true;
	controls.btnMicOpen.visible=false;
}

private function muteMicrophone(e:Event):void {
	outStream.attachAudio(null);
	controls.btnMicMute.visible=false;
	controls.btnMicOpen.visible=true;
}

private function controlsShow(e:Event):void {
	controls.alpha=20;
}

private function controlsHide(e:Event):void {
	controls.alpha=0;
}


}
}