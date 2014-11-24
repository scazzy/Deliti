<?php 
ob_start();
session_start(); 
include("include/secrypt.php");
$crypt = new proCrypt;


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
<div class="pad10 notification_box mar10 w95p" style="font-weight:normal; line-height:20px; width:600px; text-align:left; background:#fff; font-size:11px;">
<?php
if(isset($_POST['crRoomKey']) && isset($_POST['crTitle']) && isset($_POST['crAgenda']))
{
$roomkey=$_POST['crRoomKey'];
$userid=$_SESSION['uid'];
$title=trim($_POST['crTitle']);
$agenda=trim($_POST['crAgenda']);
$invitees=trim($_POST['crInviteeList']);
$startdt=date("d.m.Y h.m.s");
$roomurl=$_POST['crRoomURL'];
$date=date("d M Y");
$time=date("h:m");
$sender_email=trim($crypt->decrypt($_SESSION['uemail']));

require ("include/config.php");
require ("include/opendb.php");
dbconnect();
$sql="SELECT room_key FROM room_details WHERE room_key LIKE '$roomkey'";
$res = mysql_query($sql) or die('Query failed.1 ' . mysql_error()); 

	if(mysql_num_rows($res)>0)
	{
		$errorMessage = "Room key already exists. Go back"; 
		echo $errorMessage;
		exit;
	}
	else
	{
		//storing values to database for a new user
		$q="INSERT INTO room_details(room_key,user_id,title,agenda) VALUES ('$roomkey',$userid,'$title','$agenda')";
		$result = mysql_query($q) or die('Query failed.2' . mysql_error()); 
		if($result==1)
		{
			echo "Creating sessions.<br>";
			$_SESSION['room_is_open']=true;
		
			if($invitees!="")
			{
				echo "Sending invitations...";
				
				$fromname=$_SESSION['uname'];
				$from=$sender_email;
				$to=$invitees;
				$subject="Invitation: ".$title;
				$message="<div style='padding:10px; background:#E4F3FA; border:2px solid #B1DDF1; font-size:12px; font-family:arial,tahoma; width:95%'>
<div style='font-size:14px; font-weight:bold'>Invitation: $title <br />
<span style='font-size:12px; color:#666; font-weight:normal;'>Date: $date, Time: $time</span>
</div>
<div style='background:#fff; margin-top:10px; padding:5px;'>From: <strong>".$_SESSION['uname']."</strong> &lt;".$sender_email."&gt;<br />
<br />
I would like to invite you to the meeting/class on <strong>$date</strong> at <strong>$time</strong>.<br />
<div style='background:#FFC'><pre>".$agenda."</pre></div>
<br>

The meeting is held at <strong><a href='$roomurl'>$roomurl</a></strong><br />
I would like to see your presence at the venue.<br />
<br />
Please use the room key to enter the Meeting room.<br />
<br />
Room Key: <strong>$roomkey</strong><br />
Room Address: <strong><a href='$roomurl'>$roomurl</a></strong><br />
<br />

Thank You<br />".
$_SESSION['uname']."<br />".
$sender_email."

	</div>
   <br />

<a href='http://welbour.com/projects/clg-project/about.html'>Learn more</a> about Deliti.<br>
Create your own meetings, <a href='http://welbour.com/projects/clg-project/register.html'>register</a> now.<br />
<br />

Thanks,<br />
The Deliti Team </div>
<br />
<div style='font-size:11px; font-family:arial,tahoma; width:95%; color:#999;'>
This message was intended for email. If you are not the intended user, please delete this email.
</div>
";
				// To send HTML mail, the Content-type header must be set
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				$headers .= "Content-type: text/html\r\n"; 
				// Additional headers
				
				$headers .= "From: $fromname <$from>" . "\r\n";
				mail($to,$subject,$message,$headers);
			echo "Invitations sent...<br>";
			}
			
			echo "OK. so you just created a room successfully. Now you can easily enter the room with the key: ".$roomkey."<br>";
			$q="UPDATE settings SET set_value=set_value+1  WHERE set_name LIKE 'last_room_id'";
			$result = mysql_query($q) or die('Update failed.' . mysql_error()); 
			echo "Room Updated...<br>";
			
			$user_id=$_SESSION['uid'];
			$sql="SELECT * FROM user_details WHERE user_id LIKE '$user_id'";
			$res=mysql_query($sql) or die('Query failed. ' .mysql_error()); 
			$row=mysql_fetch_array($res);
			
			//updating user as participant
			include("include/Browser.php");
			include("include/phpfunc.php");
			$browser = new Browser();
	
			$prName=$row['usr_fname']." ".$row['usr_lname'];
			$prEmail=$row['usr_email'];
			$prRoomkey=$roomkey;
			$prGender=$row['usr_gender'];
			$prJob=$row['usr_job'];
			$prOrg=$row['usr_org'];
			$prDateTime=date("Y-m-d h:i:s");
			$prGeoLoc="";
			$prIP=getRealIpAddr();
			$prBrowser=$browser->getBrowser()."- ".$browser->getVersion();
			$prOS=php_uname('s')."-".php_uname('v');
			
			echo "Updating as participant...<br>";
			$q="INSERT INTO participant_details (prt_name,prt_email,room_key,user_id,prt_gender,prt_job,prt_org,prt_enter_dt,prt_geo_location,prt_IP,prt_browser,prt_OS) VALUES('$prName','$prEmail','$prRoomkey','$userid','$prGender','$prJob','$prOrg','$prDateTime','$prGeoLoc','$prIP','$prBrowser','$prOS') ";
			$result = mysql_query($q) or die('Query failed. ' .mysql_error()); 
			echo "Updated...<br>";
			echo "<br>doing the extra stuff....of participants...<br>";
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
					$_SESSION['is_user']=$user_id;
					
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
		}
		else {$errorMessage='Something just happned. Please try again.'; echo $errorMessage;}
	}
}
else
{
	$errorMessage="Fields missing. Go back and Try again.";echo $errorMessage;exit;
}
?>

</div>
</center>
</body>
</html>