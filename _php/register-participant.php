<?php
ob_start();
session_start();
include("include/secrypt.php");
$crypt = new proCrypt;

require("include/config.php");
require("include/opendb.php");
dbconnect();
//require("include/protect-participant.php"); 
include("include/phpfunc.php");
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ANSI">
<title>Waiting Room - Deliti</title>
<link rel="stylesheet" type="text/css" href="include/stylesheet.css" />
</head>
<body>
<center>
<div class="pad10 mar10 w95p" align="center" style="font-weight:normal; line-height:20px; width:600px; background:#fff; font-size:11px;">
<img id="loader_img" src="images/loading.gif" width="49" height="50" alt="loading">
<h1>Registering...</h1><br />

<?php
date_default_timezone_set('Asia/Kolkata');

if(isset($_POST['PLEmail']) && isset($_POST['PLName']) && isset($_POST['PLRoomKey']))
{
	include("include/Browser.php");
	$browser = new Browser();
	
	$prName=trim($_POST['PLName']);
	$prEmail=trim($crypt->encrypt($_POST['PLEmail']));
	$prRoomkey=trim($_POST['PLRoomKey']);
	$prGender=$_POST['PLGender'];
	$prJob=$_POST['PLJob'];
	$prOrg=$_POST['PLOrg'];
	$prDateTime=date("Y-m-d h:i:s");
	$prGeoLoc=$_POST['PLGeoLoc'];
	$prIP=getRealIpAddr();
	$prBrowser=$browser->getBrowser()."- ".$browser->getVersion();
	$prOS=php_uname('s')."-".php_uname('v');
	
	//checking if room user is trying to enter exists or not
	$sql="SELECT room_key FROM room_details WHERE room_key LIKE '$prRoomkey'";
	$res = mysql_query($sql) or die('Query failed. ' . mysql_error()); 

	
	echo "<div class='floatr'><a href='javascript:history.go(-1);' class=''>Cancel &amp; Go Back</a></div>";
    echo "<br> &gt; Checking room...";
	if(mysql_num_rows($res)!=1)
	{	header("location: join-room.php?st=roomnotexist&email=$prEmail&name=$prName&gender=$prGender&job=$prJob&org=$prOrg&roomkey=$prRoomkey");
		
			echo $errorMessage;
			exit;
	}
	else
	{
		echo "<b>room exists</b>";
		//checking if participant already exists for that room
		echo "<br>Checking participant details...";
		$sql="SELECT * FROM participant_details WHERE prt_email LIKE '$prEmail' AND room_key LIKE '$prRoomkey'";
		$res=mysql_query($sql)  or die('Query failed. ' . mysql_error()); 
		if(!mysql_num_rows($res)>0)
		{
	    echo "<br><br> &gt;  Registering Participant...";
		//if new participant for the room, register its details
		$q="INSERT INTO participant_details (prt_name,prt_email,room_key,prt_gender,prt_job,prt_org,prt_enter_dt,prt_geo_location,prt_IP,prt_browser,prt_OS) VALUES('$prName','$prEmail','$prRoomkey','$prGender','$prJob','$prOrg','$prDateTime','$prGeoLoc','$prIP','$prBrowser','$prOS') ";
			$result = mysql_query($q) or die('Query failed. ' .mysql_error()); 
			if($result==1)
			{
				echo "<br><br> &gt;  Retrieving participant id...";
				//passing sql query to get the newly allocated participant id
				$sql="SELECT * FROM participant_details WHERE prt_email LIKE '$prEmail' AND room_key LIKE '$prRoomkey' AND prt_name LIKE '$prName'";
				$res = mysql_query($sql) or die('Query failed. ' . mysql_error()); 
				if(mysql_num_rows($res)==1)
				{
					echo "<br><br> &gt;  Creating session...";
					$row=mysql_fetch_array($res);
					//creating session for participant
					$_SESSION['participant_logged_in']=true;
					$_SESSION['part_id']=$row['participant_id'];
					$_SESSION['roomkey']=$row['room_key'];
					$_SESSION['is_user']=NULL;
					
					echo "<br><br> &gt;  Entering live attendee queue...";
					//entering participant into live attendees/currently available	
					$q="INSERT INTO live_attendees (participant_id,room_key) VALUES(".$_SESSION['part_id'].",'".$_SESSION['roomkey']."')";
					$result = mysql_query($q) or die('Query failed. ' .mysql_error()); 
				
					echo "<strong>successful</strong>";
			    	echo "<br><br> &gt;  Entering room...";
					header("location: room/$prRoomkey") or die("Some error occured while redirecting. Please Go Back and try again.");
					exit;
					
				}
		}
		else {echo "<br>Something went wrong. Not possible to move ahead<br><a href='javascript:history.go(-1);'>GO BACK</a><br>";}
	}
	else {header("location: join-room.php?st=participantexist&email=$prEmail&name=$prName&gender=$prGender&job=$prJob&org=$prOrg&roomkey=$prRoomkey");
		echo "<br>Participant email already exists for this room.<br><a href='javascript:history.go(-1);'>GO BACK</a><br>";}
	}
	
}
else
{
	$errorMessage="<div class='error_notification_box'> Something was missing.<br> Please check whether all the details were entered correctly.<br><a href='javascript:history.go(-1);'>GO BACK</a></div>";
	echo $errorMessage;
	exit;
}
    
  
?>

</div>
</center>
</body>
</html>