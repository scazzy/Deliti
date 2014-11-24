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
<span>User Home</span></div>
<div class="container" align="left"> <strong>Links:</strong><br>
  <br>
<div align="center">
       <a href="#" class="big_icon_buttons" title="Quick Room" onClick="popbox_show('popBox_QuickRoom')"><img src="images/icon_quickroom.gif" width="60" height="60" border="0"><span>Quick Room</span></a>
       <a href="edit-profile.php" title="Edit Profile" class="big_icon_buttons"><img src="images/icon_editprofile.gif" width="60" height="60" border="0"><span>Edit Profile</span></a>
       <a href="changepwd.php" title="Change Password" class="big_icon_buttons"><img src="images/icon_changepassword.gif" width="60" height="60" border="0"><span>Change Password</span></a>
       
       <a href="join-room.php" title="Join Room" class="big_icon_buttons"><img src="images/icon_joinroom.gif" width="60" height="60" border="0"><span>Join Room</span></a>
       <a href="search-rooms.php" title="Search Rooms" class="big_icon_buttons"><img src="images/icon_searchroom.gif" width="60" height="60" border="0"><span>Search Rooms</span></a>
       <br clear="all">
       </div>



<br>


<div class="search_room_table"><b>My Rooms:</b><br clear="all">
<?php

$user_id=$_SESSION['uid'];

$q="SELECT * FROM room_details WHERE user_id LIKE '$user_id' ORDER BY start_dt DESC";
$result=mysql_query($q) or die ("Query failed. -".mysql_error());
$num=mysql_num_rows($result);
if($num>=1)
{
  echo "<table width='100%'>";
     echo "<tr>";
       echo "<th>#</th>";
       echo "<th>Room Key</th>";
       echo "<th>Title</th>";
       echo "<th>DateTime</th>";
       echo "<th>Duration</th>";
     echo "</tr>";
	 $count=0;
	while($row=mysql_fetch_array($result))
	{
		$startdate=date("d F, Y h:i",strtotime($row['start_dt']));
		
		$count++;
    echo "<tr>";
      echo "<td>$count</td>";
      echo "<td><a href='viewroom.php?roomkey=".$row['room_key']."' target='_blank'>".$row['room_key']."</a></td>";
      echo "<td title='".$row['agenda']."'>".$row['title']."</td>";
      echo "<td>".$startdate."</td>";
	  if($row['end_dt']=="")
      		{echo "<td>OnGoing</td>";}
		else{ 
			
			echo "<td>".date("d F, Y h:i",strtotime($row['end_dt']))."</td>";
		}
    echo "</tr>";
	}
  echo "</table>";
}
else
{
	echo "You have not created any rooms yet.<br><br>";
	echo "<a href='#' onClick=\"popbox_show('popBox_QuickRoom')\">Create</a> a new room now";
}
  ?>
</div>
  
  
  
  
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
