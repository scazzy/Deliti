<?php
session_start();

//Connect to MySQL
require("include/participant-protect.php");
include("include/phpfunc.php");
require("include/config.php");
require("include/opendb.php");
dbconnect();



//echo $_SESSION['part_id']." ".$_SESSION['roomkey'];

if(isset($_SESSION["part_id"]) && isset($_SESSION["roomkey"]) && isset($_GET["message"])){

$partid=$_SESSION['part_id'];
$roomkey=$_SESSION['roomkey'];
$message=htmlspecialchars($_GET['message'], ENT_QUOTES);


	if(strlen(trim($message))>0) {
		if(strlen(trim($message))<=255){
		$q="INSERT INTO chat_message(participant_id,room_key,message) VALUES('".$partid."','".$roomkey."','".$message."')";
		$result=mysql_query($q) or die(mysql_error());
		}
		else 
		{echo "Only 255 characters allowed. \n You entered ".strlen(trim($message))." extra";}
	}
	else {
		echo "Message was missing or incorrect.";	

	}

}
else {
	echo "Some data was misssing";
	
}
?>