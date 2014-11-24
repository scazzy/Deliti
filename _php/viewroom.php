<?php require("include/protect.php"); 
require("include/config.php");
require("include/opendb.php");
include("include/phpfunc.php");
include("include/secrypt.php");
$crypt = new proCrypt;

dbconnect();
$errorMessage="";
if(isset($_GET['roomkey'])){
$roomkey=$_GET['roomkey'];
if($roomkey==""){$errorMessage="Invalid Room key"; $roomkey="Invalid";}

$q="SELECT * FROM room_details WHERE room_key LIKE '$roomkey'";
$result=mysql_query($q) or die("Invalid Query. - ".mysql_error());
if($result){
$row=mysql_fetch_array($result);
$title=$row['title'];
$desc=$row['agenda'];
$startdt=date("d F, Y h:i",strtotime($row['start_dt'])); 
$enddt=date("d F, Y h:i",strtotime($row['end_dt'])); 

}

}
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Deliti | <?php echo $_SESSION['uname'];?></title>
<link rel="stylesheet" type="text/css" href="include/stylesheet.css" />
<script src="scripts/common.js"></script>


<!--[if lt IE 9]>
<script src="scripts/html5.js"></script>
<![endif]-->
</head>

<body>
<!--Begin of toppart-->
<center>
  <div id="page_body" class="w800">
  <header>
<?php include("include/header_logo.php"); ?>
<div class="floatr header_right_links" align="	"> <b class="lh18"><?php echo "Welcome ".$_SESSION['uname'];?></b><br>
  <a href="home.php" class="link"> Home</a><a href="logout.php" class="link">Logout</a></div>
  </header>
	<!--<nav id="navigation"  class="w800">
<ul>
    	<li><a href="index.php">Home</a></li>
        <li><img src="images/homepage_nav_seperator.gif"/></li>
        <li><a href="schedule-room.php">Schedule a Room</a></li>
        <li><img src="images/homepage_nav_seperator.gif"/></li>
    	<li><a href="#">Features</a></li>
        <li><img src="images/homepage_nav_seperator.gif"/></li>
        <li><a href="#">Take-a-Tour</a></li>
        <li><img src="images/homepage_nav_seperator.gif"/></li>
        <li><a href="register.php">Join Now!</a></li>
    </ul>
</nav>-->

<!--End of toppart-->

<!--begin of body - W800px-->

<div class="subpage_banner" align="left"><br />
<span>View Room Details</span></div>
<div class="container" align="left"> 
<?php
if($errorMessage!="")
{
  echo "<div class='error_notification_box marb10' id='errorBox'> <a href='#' class='small_close_btn floatr' onclick=\"popbox_close('errorBox');\">x</a> <span id='notify_msg'>$errorMessage</span></div>";
}
?>

<br>
  <br>
  <div class="big_icon_buttons big_icon_buttons_static" title="Room Details"><img src="images/icon_quickroom.gif" width="60" height="60" border="0"><span title="<?php echo "$desc"; ?>">Roomkey: <?php echo "- $roomkey ";?><br>
  <b><?php echo $title; ?></b>
</span></div><br><br clear="all">


<?php 
echo "<div class='pad10'><b>Started:</b> $startdt,<br> <b>Ended:</b> $enddt</div>";

?>
<hr size="1" color="#CCCCCC">
<table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td><span class="lighbox_title">Participants</span></td>
    <td><span class="lighbox_title">ChatScript</span></td>
  </tr>
  <tr>
    <td valign="top"><div id="viewParticipantList"><?php 
	
	$q="SELECT * FROM participant_details AS pd WHERE pd.room_key LIKE '$roomkey' ORDER BY  user_id DESC";
$result=mysql_query($q)or die("Query failed. Error resolving roomkey. -".mysql_error());
						
	echo "<ul>";					
		while ($row=mysql_fetch_array($result))
		{
			$name=$row['prt_name'];
			if($row['user_id']!="" || $row['user_id']!=NULL){$foto="images/moderator-24.png"; $name="$name";}
			else if($row['prt_gender']=='f'){$foto="images/female-24.png";}
			else {$foto="images/male-24.png";}
			$prt_email=trim($crypt->decrypt($row['prt_email']));
			echo "<li title='$name &lt; $prt_email &gt;'><a href='#' onClick='popbox_show(\"popBox_participant_detail\");'><img src='$foto' alt='$name' width='16' height='16' border='0'> $name  <img src='images/icon-info.gif' alt='Info'  border='0' class='' title='Info'>  </a></li>";
		}
	echo "</ul>";
	 ?></div></td>
    <td  valign="top"><div id="showChatScript"><?php
	
$q="SELECT
		cm.participant_id AS pid, pd.prt_name AS pname, cm.message AS pmessage, cm.timeStamp AS ptime, pd.prt_enter_dt AS pjointime, pd.prt_leave_dt AS pleavetime 

		FROM participant_details AS pd, chat_message AS cm
		WHERE cm.participant_id LIKE pd.participant_id AND cm.room_key LIKE '$roomkey'
		
		ORDER BY cm.timeStamp";
		
		$result=mysql_query($q) or die(mysql_error());
		
		echo "<ul>";
		while($row=mysql_fetch_array($result)){
			$time=date("H:i",strtotime($row['ptime']));
			if($time < "12:00")
			{$time.="am";}
			else{$time.="pm";}
			$pname="<span style='color:#333'>".$row['pname']." : </span>";
			
			echo "<li><span class='msgTime'>".$time."</span><b>".$pname."</b> ".$row['pmessage']." </li>";

		}
		echo "</ul>";
                        
?></div></td>
  </tr>
  <tr>
    <td width="50%"><hr size="1" color="#CCCCCC"><span class="lighbox_title">SharedFiles</span></td>
    <td><hr size="1" color="#CCCCCC"><span class="lighbox_title">OtherFiles</span></td>
  </tr>
  <tr>
    <td valign="top"><div id="viewSharedFiles">
      <?php

$q="SELECT sf.*,pd.participant_id AS pid, pd.prt_name AS pname FROM sharedfiles AS sf, participant_details AS pd WHERE roomkey LIKE '$roomkey' AND sf.participant_id = pd.participant_id ORDER BY uploadedOn DESC";
$result=mysql_query($q) or die("Query failed. "+mysql_error());;
$totalFiles=mysql_num_rows($result);
if($totalFiles<1){echo "No files shared in this meeting.";}
//echo $totalFiles;
if($result) {
echo "<table width='100%' cellpadding='5' cellspacing='0' border='0'>";	
	while($row=mysql_fetch_array($result)){
  	$downloadpath="users/documents/".$row['file_name'];
		echo "<tr>
			    <td width='16'>".checkFileTypeImg($row['file_type'])."</td>
			    <td width='180' title='Shared by ".$row['pname']."'>".$row['file_name']."</td>
				<td width='' >by ".$row['pname']."</td>
			    <td width='18'><a href='".$downloadpath."' title='View/Download File (".$row['file_size']." Kb)' target='_blank'>
				<img src='images/buttons/download_arrow_small.gif' alt='Download file' width='8' height='9' border='0' title='View/Download file (".$row['file_size']." Kb)'></a></td>
			</tr>";
		
	}
echo "</table>";	


}
else{
	echo "No files on the server";
}

?></div>
    
	</td>
    <td valign="top"><div id="viewOtherFiles">
    <a href='#' ><img src='images/buttons/download_arrow_small.gif' alt='Download file' width='8' height='9' border='0'>    Download Chat Script</a><br><br>
    <a href="#" class=""><img src='images/buttons/download_arrow_small.gif' alt='Download file' width='8' height='9' border='0'>  Download Whiteboard Screenshot</a><br><br>
	<a href="#" class=""><img src='images/buttons/download_arrow_small.gif' alt='Download file' width='8' height='9' border='0'>   Download Video (if recorded)</a></div>
    </td>
  </tr>
</table>


 
  
  <br>
<br>
<br>
</div>
  
  

  
 
  
  
  
  
<!--End of body-->
</div>
<!--begin of footer-->
<?php include("include/footer.php");?>
<!--end of body - W800px-->

</center>
<div class="pop_lightbox" id="popBox_QuickRoom">
<?php
$roomkey="";

$sql="SELECT set_value AS room_id FROM settings WHERE set_name LIKE 'last_room_id'";
$res = mysql_query($sql) or die('Query failed. ' . mysql_error()); 
$row=mysql_fetch_array($res);

//finding the last room_id in db to get the next one
$new_room_id=$row['room_id']+1;
//generating the room_key
$string = "0123456789abcdefghijklmnopqrstuvwxyz";
$code1 = "";
for($i=0; $i<2; $i++){
$x = rand(0,strlen($string)-1);
$code1.= $string[$x];
}
$roomkey= date("m").date("d").$code1.$new_room_id;
?>
  <form action="createroom.php" name="frmCreateRoom" onsubmit="return validate_createRoomForm(this);" method="post">
      <a href="#" class="small_close_btn floatr" onclick="popbox_close('popBox_QuickRoom');">x</a>
    <div class="lighbox_title">Quick Room</div>
      <table width="100%" cellpadding="2" class="floatl" >
        <!--<tr>
        	<td align="right">Room Name</td>
            <td align="left"><input name="fname" type="text" size="35" /></td>
        </tr>-->
        <tr>
          <td width="27%" align="right">Meeting Title</td>
          <td width="73%" align="left"><input name="crTitle" type="text" size="35" maxlength="50" /></td>
        </tr>
        <tr>
          <td align="right" valign="top">Agenda</td>
          <td align="left"><textarea name="crAgenda" cols="27" rows="3" class="w232"></textarea></td>
        </tr>
        <tr>
          <td align="right" valign="top">Invitees</td>
          <td align="left"><textarea name="crInviteeList" cols="27" rows="3" id="crInviteeList" class="w232"></textarea> 
           
<br />
            <a href="#"></a>Seperate email addresses with a comma (,)</td>
        </tr>
        <tr>
          <td align="right" valign="top">Room Key</td>
          <td align="left"><input name="crRoomKey" type="text" value="<?php echo $roomkey; ?>" size="35" maxlength="10" readonly="readonly" style="background:#fff; border:0px;" />
            <br />
            Room key identifies each room uniquely<br>
            Your roomURL will be- http://deliti.com/room/<b><?php echo $roomkey; ?></b><br>
		  </td>
        </tr>
        <tr>
        <td align="center" colspan="2">
           <div class="notification_box marb10" style="display:none">Room Url: <input name="crRoomURL" type="text" value="<?php echo "http://localhost/project/room/".$roomkey; $weburl='http://welbour.com/projects/clg-project/room/'; ?>" size="35" readonly="readonly" /></div>
        </td>
      </tr>
        <tr>
        <td colspan="2"><input type="submit" value="Begin" class="def_btn" />
          <input type="button" class="def_btn"  value="Close" onclick="popbox_close('popBox_QuickRoom');"/></td>
        </tr>
    </table>

    </form>     
</div>
<script type="text/javascript">
popbox_close('popBox_QuickRoom');

//validations

function validate_createRoomForm(f) {
	if(trim(f.crTitle.value)=="")
	{alert("Please enter the meeting title"); f.crTitle.focus();}
	else if(trim(f.crAgenda.value)=="")
	{alert("Please provide some description of the meeting");f.crAgenda.focus();}
	else if(trim(f.crRoomKey.value)=="")
	{alert("Room Key cannot be left blank"); f.crRoomKey.focus();}
	else {check_emails('crInviteeList'); if(erremails==""){return true;}else {erremails="";return false;}}

	return false;
}
</script>
</body>
</html>
