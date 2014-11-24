<?php

if(isset($_GET['roomkey'])){
	$roomkey=$_GET['roomkey'];
}
else {
	$roomkey="Demo";
}

?>
<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000"
codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0" name="main"
width="590"
height="240"
align="middle"
id="main">
  <param name="allowScriptAccess" value="sameDomain" />
<param name="movie" value="../whiteboard.swf" />
<param name="quality" value="high" />
<param name="bgcolor" value="#004E43" />
<param name="FlashVars" value="roomkey=<?php echo $roomkey;?>">
<param name="wmode" value="opaque">
<embed src="../whiteboard.swf" 
width="590"
height="240"
autostart="false"
align="middle"
allowFullScreen="true"
quality="high"
bgcolor="#004E43"
FlashVars="roomkey=<?php echo $roomkey;?>"
name="main"
allowScriptAccess="sameDomain"
type="application/x-shockwave-flash"
pluginspage="http://www.macromedia.com/go/getflashplayer" wmode="opaque" />
</object>
