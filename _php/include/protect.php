<?php
session_start(); 
if (!isset($_SESSION['user_is_logged_in']) || $_SESSION['user_is_logged_in'] != true) {
	unset($_SESSION['uemail']); 
	unset($_SESSION['upassword']); 
	unset($_SESSION['uname']); 
	unset($_SESSION['uid']);
		header('Location: login.php'); 
    exit; 
}
?>