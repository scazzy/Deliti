<?php
	
//importing and declaring encryption algorithm
include("include/phpfunc.php");
include("include/secrypt.php");
$crypt = new proCrypt;

if(isset($_POST['loginEmail']) && isset($_POST['loginPwd']))
{
		dbconnect();
		
		$lemail = $crypt->encrypt(trim($_POST['loginEmail'])); 
   		$lpassword = $crypt->encrypt(trim($_POST['loginPwd'])); 
		
		$q="SELECT user_id,usr_fname,usr_lname,usr_email,usr_pwd FROM user_details WHERE  usr_email  LIKE '$lemail' AND  usr_pwd  LIKE  '$lpassword'";
		
		$result = mysql_query($q) or die('Query failed. ' . mysql_error()); 
		if(mysql_num_rows($result) == 1) 
		{
			$row=mysql_fetch_array($result);
				$_SESSION['user_is_logged_in'] = true; 
				$_SESSION['uid']=$row['user_id'];
				$_SESSION['uemail']=$lemail;
				$_SESSION['uname']=$row['usr_fname']." ".$row['usr_lname'];

				include("include/Browser.php");
				$browser = new Browser();
				$browsername=$browser->getBrowser()." - ".$browser->getVersion();
				$ipaddr=getRealIpAddr();
				$GeoLoc=$_POST['loginGeoLoc'];
		//Nor enter log for the user
		$q="INSERT INTO user_log(user_id,log_detail,location,browser,IPaddr) VALUES('".$_SESSION['uid']."','Logged in','".$GeoLoc."','".$browsername."','".$ipaddr."') ";
		$result=mysql_query($q) or die("Query failed while entering Log. -".mysql_error());
				
				
				header('Location: home.php'); 
				exit;
		}
		else
		{
			
			$errorMessage = 'Incorrect Email or Password.';
			header('Location: login.php?st=lf');
		}
}
?>