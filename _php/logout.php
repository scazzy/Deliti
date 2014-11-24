<?php 
session_start(); 
include("include/config.php");
include("include/opendb.php");
dbconnect();
include("include/phpfunc.php");
if(isset($_POST['loginGeoLoc']))
{$GeoLoc=$_POST['loginGeoLoc'];}
else{$GeoLoc="";}

if (isset($_SESSION['user_is_logged_in'])) { 
    unset($_SESSION['user_is_logged_in']); 
	unset($_SESSION['uemail']); 
	unset($_SESSION['upassword']); 
	unset($_SESSION['uname']);
}
	include("include/Browser.php");
	$browser = new Browser();
	$browsername=$browser->getBrowser()." - ".$browser->getVersion();
	$ipaddr=getRealIpAddr();
//Nor enter log for the user
	$q="INSERT INTO user_log(user_id,log_detail,location,browser,IPaddr) VALUES('".$_SESSION['uid']."','Logged out','".$GeoLoc."','".$browsername."','".$ipaddr."') ";
		$result=mysql_query($q) or die("Query failed while entering Log. -".mysql_error());

header('Location: login.php'); 
exit;
?> 