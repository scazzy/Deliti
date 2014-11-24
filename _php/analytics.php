<?php require("include/protect.php"); 
require("include/config.php");
require("include/opendb.php");
dbconnect();
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
<nav id="navigation"  class="w800">
<ul>
    	<li><a href="home.php">Home</a></li>
        <li><img src="images/homepage_nav_seperator.gif"/></li>
        <li><a href="edit-profile.php">Edit Profile</a></li>
        <li><img src="images/homepage_nav_seperator.gif"/></li>
    	<li><a href="changepwd.php">Change Password</a></li>
        <li><img src="images/homepage_nav_seperator.gif"/></li>
        <li><a href="join-room.php">Join a room</a></li>
        <li><img src="images/homepage_nav_seperator.gif"/></li>
        <li><a href="search-rooms.php">Search Rooms</a></li>
    </ul>
</nav>

<!--End of toppart-->

<!--begin of body - W800px-->

<div class="subpage_banner" align="left"><br />
<span>OverViews</span></div>
<div class="container" align="left"><strong>Statistics:</strong><br>
<br>
<br>
<div class="pad10 mar10 floatl">
<b>Total Active / Registered Members</b>
<div class="notification_box">
<?php
 $q="SELECT count(*) as members,max(user_id) as registered  FROM user_details";
 $result=mysql_query($q) or die("Query failed : ".mysql_error());
 $row=mysql_fetch_array($result);
 echo "<h1>";
 echo $row['members']." / ".$row['registered'];
 echo "</h1>";

?>
</div></div>
<br clear="all">

<div class="pad10 mar10 floatl">
<b>Total Participation</b>
<div class="notification_box">
<?php
 $q="SELECT count(*) as participants FROM participant_details";
 $result=mysql_query($q) or die("Query failed : ".mysql_error());
 $row=mysql_fetch_array($result);
 echo "<h1>";
 echo $row['participants'];
 echo "</h1>";

?>
</div></div>
<br clear="all">

<div class="pad10 mar10 floatl">
<b>Active Participants</b>
<div class="notification_box">
<?php
 $q="SELECT count(*) as active FROM live_attendees";
 $result=mysql_query($q) or die("Query failed : ".mysql_error());
 $row=mysql_fetch_array($result);
 echo "<h1>";
 echo $row['active'];
 echo "</h1>";

?>
</div></div>
<br clear="all">

<div class="pad10 mar10 floatl">
<b>Total Rooms</b>
<div class="notification_box">
<?php
 $q="SELECT count(*) as rooms FROM room_details";
 $result=mysql_query($q) or die("Query failed : ".mysql_error());
 $row=mysql_fetch_array($result);
 echo "<h1>";
 echo $row['rooms'];
 echo "</h1>";

?>
</div></div>
<br clear="all">

<div class="pad10 mar10 floatl">
<b>Total Files on Storage</b>
<div class="notification_box">
<?php
 $q="SELECT count(*) as files FROM sharedfiles";
 $result=mysql_query($q) or die("Query failed : ".mysql_error());
 $row=mysql_fetch_array($result);
 echo "<h1>";
 echo $row['files'];
 echo "</h1>";

?>
</div></div>


<br clear="all">
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
