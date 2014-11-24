<?php
ob_start();
session_start();


require("include/participant-protect.php");
include("include/phpfunc.php");
require("include/config.php");
require("include/opendb.php");
dbconnect();
$roomkey="";
$partid="";
$title="";
$agenda="";
$mod_id="";
$name="";
$job="";
$org="";
$gender="";
$lat="";
$long="";
$startDT="";
$email="";
include("include/deskboard-func.php");


/////////////////////////////////////////////////////function get room details
if(isset($_GET['roomkey']) && $_SESSION['roomkey']==$_GET['roomkey'])
{
	$roomkey=$_GET['roomkey'];
	$partid=$_SESSION['part_id'];
	

	
	$q="SELECT * FROM room_details WHERE room_key LIKE '$roomkey'";
	$result=mysql_query($q) or die("Query failed. Error resolving roomkey. -".mysql_error());
	$row=mysql_fetch_array($result);
	if(mysql_num_rows($result)==1)
	{
		$roomurl="project/".$roomkey;
		$title=$row['title'];
		$agenda=$row['agenda'];
		$mod_id=$row['user_id'];
		$startDT=date("d F, Y h:i",strtotime($row['start_dt'])); 
	}
	else
	{
		echo "<br>Room does not exist<br>";
		exit;
	}

////////////////////////////////// function get participant details
	$q="SELECT * FROM participant_details WHERE participant_id LIKE '$partid'";
	$result=mysql_query($q) or die("Query failed. Error resolving roomkey. -".mysql_error());
	$row=mysql_fetch_array($result);
	if(mysql_num_rows($result)==1)
	{
		$name=$row['prt_name'];
		$job=$row['prt_job'];
		$org=$row['prt_org'];
		$ifmod=$row['user_id'];
		$enterDT=$row['prt_enter_dt'];
		$gender=$row['prt_gender'];
		$geoLoc=explode(',',$row['prt_geo_location']);
		$lat=trim($geoLoc[0]);
		//$long=trim($geoLoc[1]);
	}
	else
	{
		echo "<br>Error fetching participant details<br>";
		exit;
	}
////////////////////////////////////
	
}
else
{
	echo "You are not logged in this room. Please enter valid room key you want to enter.";
	exit;
	//header("location: index.php");
}
?>


<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo $title; ?> | Deliti</title>
<link rel="stylesheet" type="text/css" href="include/stylesheet.css" />
<link rel="stylesheet" type="text/css" href="include/dashboard_stylesheet.css" />

<link rel="stylesheet" type="text/css" href="../include/stylesheet.css" />
<link rel="stylesheet" type="text/css" href="../include/dashboard_stylesheet.css" />

<script src="../scripts/common.js"></script>
<script type="text/javascript" src="../scripts/drag.js"></script>
<script src="../scripts/swfobject_modified.js" type="text/javascript"></script>

<script type="text/javascript"><!--
function onABCommComplete() {
  // OPTIONAL: do something here after the new data has been populated in your text area
}


//--></script>


<!--[if lt IE 9]>
<script src="../scripts/html5.js"></script>
<![endif]-->
</head>
<body>
<input type="hidden" value="<?php echo $roomkey; ?>" id="roomkey">
<input type="hidden" value="<?php echo $partid; ?>" id="partid">


<center>
<div class="container" id="contentPane">
<!--Container Opens-->
<header id="topHeader">
<div class="floatl padr10">
  <h1><a href="<?php echo $roomkey;?>"><img src="../images/logo.png" alt="Deliti Home" width="100" height="30" border="0" title="Home"/></a></h1>
</div>
<div class="floatl padl20 mart10"><b><?php echo $title; ?></b></div>
<div class="floatr header_right_links" align="	">
<b class="lh18"><?php echo "Welcome $name ";?></b><br>
<a href="../endmeet.php?<?php if(isset($_SESSION['is_user'])){echo "pid=$partid&rk=$roomkey&mid=".$_SESSION['is_user'];} 
else {echo "pid=$partid&rk=$roomkey";}?>" class="link">Logout</a></div>
</header>


<nav id="navigation">
	<ul>
    	<li><a href="#" class="active">deskBoard</a></li>
        <li><img src="../images/dashboard_nav_seperator.gif"/></li>
        
    </ul>
        <a href="javascript:void(0)" onClick="toggle_showHide('topHeader','navBar_extraMenu');" class="floatr padt3"><img src="../images/buttons/toggle_arrows.gif" alt="Toggle Show/Hide" width="16" height="16" border="0" title="Show/Hide header"></a> 
    <div class="floatr padt5 display_none" id="navBar_extraMenu"> <a href="../endmeet.php?<?php if(isset($_SESSION['is_user'])){echo "pid=$partid&rk=$roomkey&mid=".$_SESSION['is_user'];} 
else {echo "pid=$partid&rk=$roomkey";}?>" class="link">Logout</a> </div>

</nav>
<!--End of top part-->

<div class="pad5">
	<div class="padl5 marb10">
    	<div class="floatl" id="whiteboard_container">
    	   <?php include("whiteboard_viewer.php");?>
    	</div>
        <div class="floatl marl10" id="video_container">
           <?php include("videocast_viewer.php");?>
        </div>
    </div><br clear="all"><br clear="all">
    <div class="">
    	<div id="participants_list" class="floatl panel_white_round_"><b class="colorBlue">Participants</b>
        <div class="participants_scrollPane" id="participants_scrollPane">
       		
                
                	
 <!--              <li><a href="#"><b><img src="../images/male-24.png" alt="Male" width="16" height="16" border="0"></b><img src="../images/webcam-icon-small.gif" alt="Webcam" width="9" height="10" border="0" class="floatr" title="Webcam">George</a></li>
-->                    
                    
                    
            
          </div>
        </div>
        <div class="floatl" id="discussion_block">
        		<div id="discussion_chat" class="pad5">
                     <!--   <ul>
                        	<li><span class="msgTime">10:47pm</span><b>Jane:</b> how do you do?  </li>
                            <li><span class="msgTime">10:47pm</span><b>Jane:</b> hey hi wassup? hey hi wassup? hey hi wassup? hey hi wassup? hey hi wassup? hey hi wassup?  how do you do?  </li>
                            <li><span class="msgTime">10:47pm</span><b>Jane:</b> how do you do?  </li>				<li><div id="discussion_notifier">John left the room </div></li>
                            <li><span class="msgTime">10:47pm</span><b>Jane:</b> how do you do?  </li>
                        </ul>-->
                </div>
                
                
         
                <div id="discussion_chat_textbox">
                <form action="" method="get" onSubmit="send(); return false;" >
                
          <input type="text" id="chat_text_input" value="Type your message here..." maxlength="255"onClick="javascript: this.value='';"><input id="chat_text_send_btn" type="button" value="" onClick="send();">
          </form>
          </div>
        </div>
        <div class="floatl" id="tools_panel_right">
        		<div class="marl10" title="<?php echo $title; ?>"><b><?php echo cutString($title,35); ?></b><br>
                		Started: <?php echo $startDT; ?>
				</div>
                <div class="panel_white_round_ marl10 mart5" title="Tools"><img src="../images/tools_icon.gif" width="14" height="14" alt="Tools"> <b>Tools:</b> <a href="#" class="tool_btn_w26" title="Live Notepad" onClick="popbox_show('LiveNotepad');"><img src="../images/notepad_icon.gif" alt="Notepad" width="16" height="16" border="0"></a>
                <a href="#" class="tool_btn_w26" title="File Explorer"  onClick="toggle_showHide('file_explorer');"><img src="../images/files_icon.gif" alt="File Explorer" width="16" height="16" border="0"></a>
                <a href="#" class="tool_btn_w26" title="Share a document"  onClick="popbox_show('fileUploader');"><img src="../images/upload_icon.png" alt="Share a document" width="16" height="16" border="0"></a>
                
                </div>
          <div class="panel_white_round_ marl10 mart5" title="Room Details"><img src="../images/settings_icon.gif" width="14" height="14" alt="Volume COntrol"> <b>Room Details:</b>
          		<table width="99%" border="0" cellpadding="2" cellspacing="0">
          		<tr><td>roomKey:</td><td><input type="text" value="<?php echo $roomkey; ?>" size="16" readonly="readonly"></td></tr>
	            <tr><td>roomURL:</td><td><input type="text" value="<?php echo "http://abc-pc/project/room/".$roomkey; ?>" size="16" readonly="readonly"></td></tr>
                <tr><td colspan="2"><input type="submit" value="Invite Participants" class="def_btn" style="height:20px;" onClick="popbox_show('popBox_Invite_Participants');"/></td></tr>
                </table>
          </div>
        </div>
    </div>
    <br clear="all">
</div>



<!--Container ends-->
</div>

<div class="pop_lightbox" id="popBox_Invite_Participants" align="left">
<form action="" name="form_1" onsubmit="return validate_inviteParticipante(this);" method="post">
      <a href="#" class="small_close_btn floatr" onclick="popbox_close('popBox_Invite_Participants');">x</a>
    <div class="lighbox_title">Invite Participants</div>
		This will send mail to all the invited users for joining the room.
      <table width="100%" cellpadding="4" cellspacing="0" class="floatl" >
        <tr>
          <td ><b>Enter invitees email addresses</b> Seperated by a comma ( , )<br>
			<textarea name="invitee_list" cols="71" rows="4" id="invitee_list" class="w385"></textarea><br clear="all">
          	Example: john.doe@gmail.com,david_thomas@yahoo.com, ...
          		
          </td></tr>
                  <tr>
          <td ><input type="checkbox" name="checkbox" id="checkbox" onclick="toggle_showHide('invitee_message');">
            <label for="checkbox" >Preview Message:</label> 
           <br clear="all">
			<div name="invitee_message" style="display:none; background:#fff; border:1px solid #666; color:#333; padding:5px;" id="invitee_message" class="w385">From: <b><?php echo $name;?></b><br><br>
            
I would like to invite you to the meeting/class on <b><?php echo $startDT;?></b>.<br><br>


The meeting is held at <?php echo $roomurl;?>.<br>
I would like to see your presence at the venue.<br><br>

Please use the room key to enter the Meeting room.<br><br>

Room Key: <b><u><?php echo $roomkey;?></u></b><br>

Room Address: <b><?php echo "http://localhost/project/room/".$roomkey;?></b><br><br><br>


Thank You<br>
<b><?php echo $name;?></b><br>
<?php echo "";?>
			</div>
          	
          		 
          </td></tr>
        <tr>
        <td colspan="2"><input type="submit" value="Send Invitation" class="def_btn" />
          <input type="button" class="def_btn"  value="Close" onclick="popbox_close('popBox_Invite_Participants');"/></td>
        </tr>
    </table>
      <br />
    </form>
</div>


<div class="pop_lightbox" id="popBox_participant_detail" align="left">
      <a href="#" class="small_close_btn floatr" onclick="popbox_close('popBox_participant_detail');">x</a>
      <iframe name="" id="fraViewParticipantDetail" align="middle" src="../view_participant_detail.php" style="width:100%; border:0px; font-family:tahoma; text-align:center; overflow:auto;" frameborder="0" allowtransparency="true"></iframe>
      

</div>


<div class="pop_lightbox" id="LiveNotepad"  style="min-width:100px; width:600px;" align="left" >
  <form action="../view_livepad_content.php" target="_blank" name="form_notepad" method="post">
    <a href="#" class="small_close_btn floatr" onclick="popbox_close('LiveNotepad');" title="Minimize">-</a><img src="../images/spacer.gif" alt="" width="5" height="1" class="floatr"><input type="submit" value="" style="background:url(../images/save_icon.gif);border:0px; cursor:pointer; width:14px; height:14px;" title="Save/Download" class="floatr" >
    <div class="lighbox_title" id="Notepad_title" onMouseDown="dragStart(event, 'LiveNotepad');" style="cursor:move"><img src="../images/notepad_icon.gif" alt="" width="16" height="16"> Notepad</div>

    <textarea name="notepad_text" id="notepad_text"  style="width:99%; height:200px; max-width:594px; max-height:500px;"></textarea>
  </form>
</div>

<div class="pop_lightbox" id="fileUploader" align="left" >

     <a href="#" class="small_close_btn floatr" onclick="popbox_close('fileUploader');">x</a><img src="../images/spacer.gif" alt="" width="5" height="1" class="floatr">
    <div class="lighbox_title"><img src="../images/upload_icon.png" alt="" width="16" height="16"> File Uploader</div>
    
 <iframe id="upload_target" name="upload_target" align="middle" src="../file-uploader.php" style="width:400px;height:250px;border:0px; font-family:tahoma; overflow:auto;"  frameborder="0" allowtransparency="true"></iframe>

</div>


<div class="pop_lightbox" id="meetingOver" align="left" >
<!---->
<img src="../images/spacer.gif" alt="" width="5" height="1" class="floatr">
    <div class="lighbox_title">Room is  closed...</div>
    The host has closed the room.<br>
    Please use the top-right Logout button to Logout.<br>
<br>
    <input type="button" class="def_btn" value="Close" onclick="popbox_close('meetingOver');">
    

</div>


<!--file sharer-->
<div class="" id="file_sharer" align="right">
<span class="colorBlue title"><b><a href="#" onClick="toggle_showHide('file_explorer');"> <img class="floatl" src="../images/files_icon.gif" width="16" height="16" border="0">&nbsp; File Explorer</a></b></span>
                    
<div id="file_explorer" class="">
<div id="shared_files_block"></div>

<div class="pad5" style="background:#FFC; border-left:1px solid #ccc; border-top:1px solid #ccc;"><a href="#" title="Share a document" onClick="popbox_show('fileUploader');"><img src="../images/upload_icon.png" alt="Share a document" width="14" height="14" border="0" > Share a document</a> <img src="../images/spacer.gif" width="20" height="5">  <a href="#"title="Refresh list" onClick="showSharedFiles();"> <img src="../images/refresh-icon.png" alt="Refresh list" width="14" height="14" border="0" > Refresh</a></div>
</div>
</div>
<!--file sharer ends-->


</center>





<script type="text/javascript">

popbox_close('LiveNotepad');
popbox_close('popBox_Invite_Participants');
popbox_close('popBox_participant_detail');
popbox_close('fileUploader');
popbox_close('meetingOver');





function validate_inviteParticipante(f){
	if(trim(f.invitee_list.value)=="")
	{alert("Please enter atleast one email address to be invited"); f.invitee_list.focus();}
	else if(trim(f.invitee_message.value)=="")
	{alert("Please provide some message.");f.invitee_message.focus();}
	else {check_emails('invitee_list'); if(erremails==""){return true;}else {erremails="";return false;}}

	return false;
}




function toggle_msgEdit(chkBox,id){
	
	txtBox=document.getElementById(id);
	if(!chkBox.checked)
	{
		
		txtBox.style.display="none";
	}
	else {
		txtBox.style.display="block";
	}
}


</script>


<script type="text/javascript">
//This function will display the users
function showParticipants(){
	//Send an XMLHttpRequest to the 'show-message.php' file

	if(window.XMLHttpRequest){
		xmlhttp = new XMLHttpRequest();
		xmlhttp.open("GET","../show-participant-list.php",false);
		xmlhttp.send(null);
	
	}
	else{
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		xmlhttp.open("GET","../show-participant-list.php",false);
		xmlhttp.send();
	}

	//Replace the content of the messages with the response from the 'show-messages.php' file
	document.getElementById('participants_scrollPane').innerHTML = xmlhttp.responseText
	
	//Repeat the function each 3 seconds
	setTimeout('showParticipants()',5000);
	
}
//Start the show participants() function
showParticipants();




//This function will display the users
function showChatMessages(){
	//Send an XMLHttpRequest to the 'show-message.php' file

	if(window.XMLHttpRequest){
		xmlhttp = new XMLHttpRequest();
		xmlhttp.open("GET","../show-chat-messages.php",false);
		xmlhttp.send(null);
	
	}
	else{
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		xmlhttp.open("GET","../show-chat-messages.php",false);
		xmlhttp.send();
	}

	//Replace the content of the messages with the response from the 'show-messages.php' file
	document.getElementById('discussion_chat').innerHTML = xmlhttp.responseText
	
	//Repeat the function each 3 seconds
	setTimeout('showChatMessages()',3000);
	
	var objDiv = document.getElementById("discussion_chat");
	objDiv.scrollTop = objDiv.scrollHeight;
	
}
//Start the showmessages() function
showChatMessages();













//This function will submit the message
function send() {
	
	var message=document.getElementById("chat_text_input").value;

	//Send an XMLHttpRequest to the 'send.php' file with all the required informations
	var sendto = "../sendchatmessage.php?message="+message;
	if(window.XMLHttpRequest){
		xmlhttp = new XMLHttpRequest();
		xmlhttp.open("GET",sendto,false);
		xmlhttp.send(null);
		
		document.getElementById("chat_text_input").focus();
	}
	else{
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		xmlhttp.open("GET",sendto,false);
		xmlhttp.send();
		
		document.getElementById("chat_text_input").focus();
	}
	var error = '';
	//If an error occurs the 'send.php' file send`s the number of the error and based on that number a message is displayed
	error=String(xmlhttp.responseText);
	if(error == ''){
		//
		//showmessages();
		document.getElementById("chat_text_input").value="";
	}
	else{
		alert(error);
	}

}




//For showing shared files
//This function will display the users
function showSharedFiles(){
	//Send an XMLHttpRequest to the 'show-message.php' file

	if(window.XMLHttpRequest){
		xmlhttp = new XMLHttpRequest();
		xmlhttp.open("GET","../view-user-files.php",false);
		xmlhttp.send(null);
	
	}
	else{
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		xmlhttp.open("GET","../view-user-files.php",false);
		xmlhttp.send();
	}

	//Replace the content of the messages with the response from the 'show-messages.php' file
	document.getElementById('shared_files_block').innerHTML = xmlhttp.responseText
	
	//Repeat the function each 3 seconds
	setTimeout('showSharedFiles()',5000);
	
}
//Start the show participants() function
showSharedFiles();
</script>

<!--<script type="text/javascript">
//chk if room is closed

//For showing shared files
//This function will display the users
function chkRoomClosed(){
	//Send an XMLHttpRequest to the 'show-message.php' file
var rk=document.getElementById('roomkey').value;
var pid=document.getElementById('partid').value;

	if(window.XMLHttpRequest){
		xmlhttp = new XMLHttpRequest();
		xmlhttp.open("GET","../chk_room_closed.php?rk="+rk+"&pid="+pid,false);
		xmlhttp.send(null);
	
	}
	else{
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		xmlhttp.open("GET","../chk_room_closed.php?rk="+rk+"&pid="+pid,false);
		xmlhttp.send();
	}
	//Repeat the function each 3 seconds
	setTimeout('chkRoomClosed()',5000);
	
}
//Start the show participants() function
chkRoomClosed();
</script>-->


<script language="JavaScript">

	function showParticipantDetail(pid) {
		var viewDetailPage="../view_participant_detail.php";
		document.getElementById('fraViewParticipantDetail').src=viewDetailPage+"?pid="+pid;
		popbox_show('popBox_participant_detail');
		
	}

  
  function confirmExit()
  {
	  // the url which you have to reload is this page, but you add an action to the GET- or POST-variable
	var url="../endmeet.php?<?php if(isset($_SESSION['is_user'])){echo "pid=$partid&rk=$roomkey&mid=".$_SESSION['is_user'];} 
else {echo "pid=$partid&rk=$roomkey";}?>";
	
	// Opens the url in the same window
	   window.open(url, "_blank");
	   
  }
  
  
</script>


</body>
</html>