<?php
ob_start();
session_start(); 
$errorMessage = ''; 
if (isset($_SESSION['user_is_logged_in'])) {
	header('Location: home.php'); 
	exit;
}
?>
<?php
require ("include/config.php");
require ("include/opendb.php");
dbconnect();
	
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Deliti</title>
<link rel="stylesheet" type="text/css" href="include/stylesheet.css" />
<script src="scripts/common.js"></script>
<script src="scripts/validations.js"></script>

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
<div class="floatr header_right_links">
<a href="#" class="link active">Home</a> | <a href="login.php" class="link" id="quick_signup_btn" onClick="toggle_showHide('drop_login_box');">Member LogIn</a> | <a href="join-room.php" class="link" id="quick_signup_btn" onClick="toggle_showHide('drop_participant_login_box');">Participant LogIn</a></div>
</header>
<?php include("include/header_unlogged_nav.php"); ?>

<!--End of toppart-->

<!--begin of body - W800px-->

<div class="home_banner" align="left"> Organize <span>Meetings</span><br />
Educate in <span>ClassRoom</span><br />
Perform <span>Trainings</span><br />
and <span>more...</span></div>

<div class="container" align="left">
<div>
	<div class="_signup_box mart-40 floatl">
    <h2>Sign Up</h2>
    <form action="register.php" method="post" name="frmSignupHome" onSubmit="return validate_form(this);">
    <span class="font10 colorGray">All the fields are mandatory.</span><br><br>

    <table width="415" cellpadding="8" >
    	<tr>
        	<td align="right">First Name</td>
            <td align="left"><input name="hrfname" type="text" id="rfname" size="35" maxlength="50" /></td>
        </tr>
    	<tr>
        	<td align="right">Last Name</td>
            <td align="left"><input name="hrlname" type="text" id="rlname" size="35" maxlength="50" /></td>
        </tr>
        <tr>
        	<td align="right">Email</td>
            <td align="left"><input name="hremail" type="text" id="remail" size="35" maxlength="80" /></td>
        </tr>
        <tr>
          <td align="right">I am</td>
          <td align="left">
            <select name="hrgender" size="1" id="hrgender">
              <option value="m" selected>Male</option>
              <option value="f">Female</option>
            </select>
          </td>
        </tr>
        <tr>
          <td align="right">Country:</td>
          <td><select name="hrcountry" id="hrcountry" size="" style="width:240px">
            <option value="Select Country:">Select Country:</option>
            <?php      
            
            $q="SELECT country_id,country_name FROM countries";
            $result = mysql_query($q) or die('Query failed. ' . mysql_error()); 
            
            while($row=mysql_fetch_array($result))
            {
                echo "<option value='".$row['country_id']."'>".$row['country_name']."</option>";
            }
            ?>
            </select></td>
        </tr>
        <tr>
        	<td align="right"></td>
            <td align="left"><input type="submit" value="Submit" class="def_btn"/></td>
        </tr>
    </table>
    </form>
    </div>
    
      
    <div class="floatr" align="center">
      <div id="" class="usr_login_fieldset"> <b class="padl5 floatl">Sign In</b><br clear="all">
      <input type="hidden" name="loginGeoLoc" id="loginGeoLoc">
        <form action="login.php" method="post" name="frmPopLogin" onSubmit="return validate_loginForm(this);">
          <table width="90%" cellpadding="5" cellspacing="0">
            <tr>
              <td>Email: </td>
              <td><input name="loginEmail" type="text" id="loginEmail" width="20"></td>
            </tr>
            <tr>
              <td valign="top">Password: </td>
              <td><input name="loginPwd" type="password" id="loginPwd" width="20">
                </td>
            </tr>
            <tr>
              <td></td>
              <td><input type="submit" value="Login" class="def_btn" style="" /> <a href="forgotpwd.php">Forgot Password?</a></td>
            </tr>
          </table>
        </form>
      </div>

    <br>

    
    <div align="left" class="padl20 participant_login_fieldset"><form action="join-room.php" method="get">
    <b>Join Room</b>
    <br>
    Enter Roomkey: <input name="roomkey" type="text" id="roomkey" size="10"> <input type="submit" value="Join" class="def_btn"></form>
    <a href="join-room.php">Join a Room (Participants)</a><br>
    </div>
	
	<br>

    <a href="about.php"><img src="images/what-is-getting-started-img.gif" width="331" height="181" border="0" /></a><br />      <br />

</div>
<br clear="all" />
</div>

</div>

<!--End of body-->
</div>
<!--begin of footer-->
<?php include("include/footer.php");?>
<!--end of body - W800px-->

</center>
<!-- popup lightboxes -->
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
		var reg = /^([sA-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
		if((reg.test(trim(f1.loginEmail.value))==false))
		{alert("Please enter your valid email address");f1.loginEmail.focus();}
		else if(trim(f1.LoginPwd.value)=="")
		{alert("Please enter a password");f1.LoginPwd.focus();}
		else
		{return true;}
		return false;

	}


	function validate_form(f)
	{
		//var reg = /^([sA-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
		
		if(trim(f.hrfname.value)=="")
		{alert("Please enter your first name");f.hrfname.focus();}
		else if(trim(f.hrlname.value)=="")
		{alert("Please enter your last name");f.hrlname.focus();}
		else if((reg.test(trim(f.hremail.value))==false))
		{alert("Please enter your valid email address");f.hremail.focus();}
		else if(f.hrcountry.value == "Select Country:")
		{alert("Please select your country");f.hrcountry.focus();}
		else
		{return true;}
		
		return false;
	}

	
  </script>
 
</body>
</html>
