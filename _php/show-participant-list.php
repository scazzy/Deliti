<?php
ob_start();
session_start();
require("include/participant-protect.php");
include("include/phpfunc.php");
require("include/config.php");
require("include/opendb.php");
dbconnect();
include("include/secrypt.php");
$crypt = new proCrypt;

$roomkey=$_SESSION['roomkey'];

$q="SELECT * FROM live_attendees AS at,participant_details AS pd WHERE pd.room_key LIKE '$roomkey' AND at.participant_id=pd.participant_id AND at.room_key=pd.room_key ORDER BY prt_name ";
$result=mysql_query($q)or die("Query failed. Error resolving roomkey. -".mysql_error());
						
	echo "<ul><br>";					
		while ($row=mysql_fetch_array($result))
		{
			$name=$row['prt_name'];
			if($row['user_id']!="" || $row['user_id']!=NULL){$foto="../images/moderator-24.png"; $name="$name";}
			else if($row['prt_gender']=='f'){$foto="../images/female-24.png";}
			else {$foto="../images/male-24.png";}
			$prt_email=trim($crypt->decrypt($row['prt_email']));
			echo "<li title='$name &lt; $prt_email &gt;'><a href='#' onClick='showParticipantDetail(".$row['participant_id'].")'><img src='../images/icon-info.gif' alt='Info'  border='0' class='floatr' title='Info'> <img src='../images/webcam-icon-small.gif' alt='Webcam' width='0' height='0' border='0' class='floatr' title='Webcam'><img src='$foto' alt='$name' width='16' height='16' border='0'> $name </a></li>";
		}
	echo "</ul>";
						
?>