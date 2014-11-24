<?php 
ob_start();
session_start();

require("include/config.php");
require("include/opendb.php");
dbconnect();

//removing entry of participant from live attendee
if(isset($_GET['pid']) && isset($_GET['rk'])) 
{

$pid=$_GET['pid'];
$rk=$_GET['rk'];
$q="DELETE FROM live_attendees WHERE participant_id LIKE '$pid' AND room_key LIKE '$rk'";
$result=mysql_query($q) or die("Query failed. Error resolving roomkey. -".mysql_error());


//removing session for the logged in participant before logging out
if (isset($_SESSION['participant_logged_in'])) { 
    unset($_SESSION['participant_logged_in']);
	unset($_SESSION['part_id']);
	unset($_SESSION['roomkey']);
	unset($_SESSION['is_user']);
} 
//header('Location: index.php'); 
$timestamp=date("Y-m-d h:m:s");
$q="UPDATE participant_details SET prt_leave_dt='$timestamp' WHERE room_key LIKE '$rk' AND participant_id LIKE '$pid'";
	$result=mysql_query($q) or die("Query failed. Error resolving roomkey. -".mysql_error());
	
	
echo "You are out of the meeting.";
if(isset($_GET['mid']) && $_GET['mid']!="")
{
	//attaching end datetime to the room 
	$timestamp=date("Y-m-d h:m:s");
	$user_id=$_GET['mid'];
	$q="UPDATE room_details SET end_dt='$timestamp' WHERE room_key LIKE '$rk' AND user_id LIKE '$user_id'";
	$result=mysql_query($q) or die("Query failed. Error resolving roomkey. -".mysql_error());
	
	//removing all the participants from live_attendees for the room
	$q="DELETE FROM live_attendees WHERE room_key LIKE '$rk'";
	$result=mysql_query($q) or die("Query failed. Error resolving roomkey. -".mysql_error());
	echo "The room has been closed. Go <a href='home.php'>Home</a> now";
}
}

header ("location: demo.php?sk=endmeet&roomkey=$rk&pid=$pid");
exit;
?> 