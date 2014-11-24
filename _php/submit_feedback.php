<? ob_start(); ?>
<?php
require("include/config.php");
require("include/opendb.php");
dbconnect();
if(isset($_POST['pid']) && isset($_POST['rk'])) 
{
	$pid=$_POST['pid'];
	$rk=$_POST['rk'];
	$msg=$_POST['feedbackMsg'];
	$q="UPDATE participant_details SET prt_feedback='$msg' WHERE participant_id LIKE $pid AND 	room_key LIKE '$rk'";
	$result=mysql_query($q) or die("Query failed. Error resolving roomkey. -".mysql_error());
	
	
        echo "Your feedback was sent successfully. Thank You";

		echo "<script type='text/javascript'>alert('Your feedback was sent successfully. Thank You');</script>;";

		header("location: index.php");

}
		
?>
<? ob_flush(); ?>