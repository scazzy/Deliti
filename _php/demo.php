
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Deliti | Demo</title>
<link rel="stylesheet" type="text/css" href="include/stylesheet.css" />
</head>

<body>
<div align="center">


<div class="w385 mar10 pad10" align="left" >

<h1>Thank you for your participation. </h1><br>

You have successfully logged out of the room.<br><br>
<br><br>
<?php
$pid="0";
$rk="0";
if (isset($_GET['roomkey']) && isset($_GET['pid'])){
	
	$pid=$_GET['pid'];
	$rk=$_GET['roomkey'];
}
?>
<h3>We would love to hear about your feedback regarding the meeting inside the classroom. And also about your experience to this application.</h3><br>
<form action="submit_feedback.php" method="post" name="feedForm">
<input type="hidden" value="<?php echo $pid;?>" name="pid">
<input type="hidden" value="<?php echo $rk;?>" name="rk">
<table width="500" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><textarea cols="80" rows="5" name="feedbackMsg">Share your experience here...</textarea></td>
    </tr>
  <tr>
    <td><br><input type="submit" value="     Send     " class="def_btn" />
      <input type="button" value="     Close     " class="def_btn" onClick="window.location = 'index.php'" /></td>
    </tr>
</table>
</form>
<br>
<br>

Or what you can do?<br><br>
1. <a href="register.php">Register yourself</a><br>
2. <a href="index.php">Go to Deliti Homepage </a></div>
<br>
<br>
<br>


</div>
</body>
</html>
