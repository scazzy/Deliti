<?php
if(isset($_GET['roomkey']) && $_GET['roomkey']!="") {
	$roomkey=$_GET['roomkey'];
	$joinroom="?roomkey=".$roomkey;
}
if (!isset($_SESSION['participant_logged_in']) || $_SESSION['participant_logged_in'] != true || !isset($_SESSION['part_id']) || !isset($_SESSION['roomkey'])) {
	unset($_SESSION['part_id']); 
	unset($_SESSION['roomkey']); 
	unset($_SESSION['is_user']); 
	header("Location: ../join-room.php".$joinroom); 
    exit; 
}
else
{
	//do nothing	
}
?>