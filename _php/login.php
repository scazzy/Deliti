<?php
ob_start();
session_start(); 
$errorMessage = ''; 
if(isset($_GET['st'])){
	if($_GET['st']=='lf') {$errorMessage = 'Incorrect Email or Password.'; }
}
if (isset($_SESSION['user_is_logged_in'])) {
	header('Location: home.php'); 
	exit;
}
?>
<?php
require("include/config.php");
require("include/opendb.php");

	include("logg_in.php");


?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Log In - Deliti</title>
<link rel="stylesheet" type="text/css" href="include/stylesheet.css" />
<script src="scripts/common.js"></script>
<!--[if lt IE 9]>
<script src="scripts/html5.js"></script>
<![endif]-->
</head>

<body>
<!--Begin of toppart-->
<center>
  <div id="page_body" class="w800">
  <header>
<?php include("include/header_logo.php"); ?>
<div class="floatr header_right_links"> <a href="index.php" class="link">Home</a> <a href="register.php" class="link">Sign Up</a></div>
</header>
<?php include("include/header_unlogged_nav.php"); ?>

<!--End of toppart-->

<!--begin of body - W800px-->

<div class="subpage_banner" align="left"><br />
<span>Log In</span>
</div>
<div class="container" align="left">

<?php
if($errorMessage!="")
{
  echo "<div class='error_notification_box marb10' id='errorBox'> <a href='#' class='small_close_btn floatr' onclick=\"popbox_close('errorBox');\">x</a> <span id='notify_msg'>$errorMessage</span></div>";
}
?>
<h3 class="colorGray" align="center">Please click on Allow when it asks for the location.</h3><br>
  <table width="100%" cellpadding="2" >
    <tr><td valign="top">
  
		<fieldset class="usr_login_fieldset"><legend><h2>Login here</h2></legend>
          <form action="" method="post" name="frmMemberLogin" onSubmit="return validate_loginForm(this);">
            <table width="100%" cellpadding="4">
				<tr>
      <td width="19%" align="right">Email</td>
      <td width="35%" align="left"><input name="loginEmail" type="text" size="35" maxlength="100" id="loginEmail" /></td>
      
    </tr>
    <tr>
      <td align="right">Password</td>
      <td align="left"><input name="loginPwd" type="password" size="35" id="loginPwd" /></td>
      </tr>
    <tr>
      <td align="right" valign="top">&nbsp;</td>
      <td align="left"><a href="forgotpwd.php">Forgot Password?</a></td>
      </tr>
    <tr>
      <td align="right"><input type="hidden" name="loginGeoLoc" id="loginGeoLoc"></td>
      <td align="left"><input type="submit" class="def_btn" value="Log In" ><!--onClick="popbox_show('notify_1');">-->
        <img src="images/spacer.gif" width="5" height="1"> or <a href="register.php">Sign Up</a></td>
      </tr></table></form>
      </fieldset>
            
            </td>
            <td >
            <h2><a href="join-room.php">Join Room /<br> Participant Login here<br><br> &gt;&gt;</a></h2>
	        </td>
        </tr>
    	
  </table></form><br>
<br>
<div id="whatIsDeliti_onLogin_box">
<span>What's Deliti?</span>
	<div class="floatr" style="width:250px"><br>

    <div class="padl5" align="center">Didn't register yet? </div>
  <a href="register.php" class="floatr"><img src="images/buttons/sign_up_now_login_big.gif" width="245" height="58" border="0"></a><br clear="all">
  <div class="padl5" align="center"><b class="colorBlue">It's FREE</b>, and amazing </span></div>
  </div>
	You can conduct your own meetings, and webinars right now using the world's, easiest online conference ... Dimdim!<br>
	Share your desktop<br>
	Show presentations<br>
	Collaborate live<br>
	... and much, much more<br><br>

	<a href="about.php" class="link">read more</a>


</div>
  
</div>
<!--End of body-->
</div>
<!--begin of footer-->
<?php include("include/footer.php");?>
<!--end of body - W800px-->

</center>
<script type="text/javascript">
// First check if browser supports the geolocation API
if (navigator.geolocation)
{
// Get the current position
navigator.geolocation.getCurrentPosition(function(position)
{
lat = position.coords.latitude
long = position.coords.longitude;
//alert(lat+" "+long );
document.getElementById('PLGeoLoc').value=lat+","+long;
document.getElementById('loginGeoLoc').value=lat+","+long;

});
} else {
//alert("Sorry... your browser does not support the HTML5 GeoLocation API");
}
</script>
<script type="text/javascript">

	//validations
	function validate_loginForm(f1)
	{
//		var reg = /^([sA-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
		if((reg.test(trim(f1.loginEmail.value))==false))
		{alert("Please enter your valid email address");f1.loginEmail.focus();}
		else if(trim(f1.loginPwd.value)=="")
		{alert("Please enter a password");f1.LoginPwd.focus();}
		else
		{return true;}
		return false;

	}

	


</script>
</body>
</html>
