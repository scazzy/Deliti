<?php

if(isset($_GET['roomkey'])){
	$roomkey=$_GET['roomkey'];
}
else {
	$roomkey="Demo";
}

if (isset($_SESSION['is_user'])){
?>

  <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000"
codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0" name="main"
width="360"
height="240"
align="middle"
id="main">
    <param name="allowScriptAccess" value="sameDomain" />
<param name="movie" value="../billgates.swf" />
<param name="quality" value="high" />
<param name="bgcolor" value="#000000" />
<param name="FlashVars" value="roomkey=<?php echo $roomkey;?>">
<param name="wmode" value="opaque">
<embed src="../billgates.swf" 
width="360"
height="240"
autostart="false"
align="middle"
allowFullScreen="true"
quality="high"
bgcolor="#000000"
FlashVars="roomkey=<?php echo $roomkey;?>"
name="main"
allowScriptAccess="sameDomain"
type="application/x-shockwave-flash"
pluginspage="http://www.macromedia.com/go/getflashplayer" wmode="opaque" />
</object>

<?php
}
else {
?>	
<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000"
codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0" name="main"
width="360"
height="240"
align="middle"
id="main">
  <param name="allowScriptAccess" value="sameDomain" />
<param name="movie" value="../stevejobs.swf" />
<param name="quality" value="high" />
<param name="bgcolor" value="#000000" />
<param name="FlashVars" value="roomkey=<?php echo $roomkey;?>">
<param name="wmode" value="opaque">
<embed src="../stevejobs.swf" 
width="360"
height="240"
autostart="false"
align="middle"
allowFullScreen="true"
quality="high"
bgcolor="#000000"
FlashVars="roomkey=<?php echo $roomkey;?>"
name="main"
allowScriptAccess="sameDomain"
type="application/x-shockwave-flash"
pluginspage="http://www.macromedia.com/go/getflashplayer" wmode="opaque" />
</object>
<?php
}
?>