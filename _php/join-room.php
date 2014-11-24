<?php
session_start(); 
include("include/secrypt.php");
$crypt = new proCrypt;
$email="";
$name="";
$gender="";
$job="";
$org="";
$roomkey="";
$errorMessage = ''; 
if(isset($_GET['st'])){
	$st=$_GET['st'];
	if($st=='lf')
		{$errorMessage = 'Incorrect Email or Password.'; }
	else if($st=="roomnotexist")
		{$errorMessage="Room key does not exists.<br>Please enter a valid room key, or search for a room key <a href='search-rooms.html'>here</a>";
	}
	else if($st=="participantexist"){
		$errorMessage="The email you provided has already logged in this room.";
	}
}


if(isset($_GET['email'])){
$email=trim($crypt->decrypt($_GET['email']));}
if(isset($_GET['name'])){$name=$_GET['name'];}
if(isset($_GET['gender'])){$gender=$_GET['gender'];}
if(isset($_GET['job'])){$job=$_GET['job'];}
if(isset($_GET['org'])){$org=$_GET['org'];}

if(isset($_GET['roomkey']) && $_GET['roomkey']!=""){
	$roomkey=$_GET['roomkey'];
}

?>
<?php
require("include/config.php");
require("include/opendb.php");




?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Join Room - Deliti</title>
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
<div class="floatr header_right_links" align="	"> <b class="lh18"><?php 
echo "Welcome ";
if(isset($_SESSION['uname'])){echo $_SESSION['uname']."</b>"; 
echo "<br>";
echo "<a href='home.php' class='link'> Home</a><a href='logout.php' class='link'>Logout</a>";
}
else{echo "Guest<br>"."<a href='register.php'>Sign Up</a>";}
?></b><br>
  </div>
</header>

<?php 
//selecting navigation menus
if(isset($_SESSION['user_is_logged_in']) && $_SESSION['user_is_logged_in']==true){
	include("include/header_logged_nav.php"); 
}
else{
	include("include/header_unlogged_nav.php"); 
}
?>

<!--End of toppart-->

<!--begin of body - W800px-->

<div class="subpage_banner" align="left"><br />
<span>Join Room / Participant Login</span></div>
<div class="container" align="left">

<?php
if($errorMessage!="")
{
  echo "<div class='error_notification_box marb10' id='errorBox'> <a href='#' class='small_close_btn floatr' onclick=\"popbox_close('errorBox');\">x</a> <span id='notify_msg'>$errorMessage</span></div>";
}
?>
<h3 class="colorGray" align="center">Please click on Allow when it asks for the location.</h3><br>
  <table width="100%" cellpadding="2" >
 
            <td>
	   
 <legend><h2>Join a Room: Participant Login</h2></legend><hr size="1" color="#CCCCCC">
			<form name="frmParticipantLogin" action="register-participant.php" method="post" onSubmit="return validate_participantLogin(this);">
            <table width="100%" cellpadding="4">
				<tr>
                
      <td width="44%" align="right">Email</td>
      <td width="56%" align="left"><input name="PLEmail" type="text" id="PLEmail" value="<?php echo $email;?>" size="35" maxlength="100" /></td>
      
    </tr>
    <tr>
      <td align="right">Full Name</td>
      <td align="left"><input name="PLName" type="text" id="PLName" value="<?php echo $name;?>" size="35" maxlength="50" /></td>
      </tr>
    
    <tr>
      <td align="right">Gender</td>
      <td align="left"><select name="PLGender" size="1" id="PLGender">
      <?php 
	  if($gender=='f') {
		  echo "<option value='f' selected>Female</option>";
		  echo "<option value='m'>Male</option>";
		}
		else {
			echo "<option value='f' >Female</option>";
		  echo "<option value='m' selected>Male</option>";
		}
	  ?>
       
      </select></td>
    </tr>
    <tr>
      <td align="right">Job / Designation</td>
      <td align="left"><input name="PLJob" type="text" id="PLJob" value="<?php echo $job;?>" size="35" maxlength="50" /></td>
    </tr>
    <tr>
      <td align="right">Organization / Institution</td>
      <td align="left"><input name="PLOrg" type="text" id="PLOrg" value="<?php echo $org;?>" size="35" maxlength="30" /></td>
    </tr>
    <tr>
      <td align="right"><strong>Room Key</strong></td>
      <td align="left"><input name="PLRoomKey" type="text" size="35" maxlength="30" id="partLoginRoomKey3" value="<?php echo $roomkey; ?>" /></td>
    </tr>
    <tr>
      <td align="right"><input type="hidden" name="PLGeoLoc" id="PLGeoLoc"></td>
      <td align="left"><input name="Submit" type="submit" class="def_btn" onClick="popbox_show('notify_1');" value="Join Room">
        <img src="images/spacer.gif" alt="" width="5" height="1"> <a href="search-rooms.php">Forgot Room key?</a></td>
    </tr>
            </table>
            </form>
	 
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

	function validate_participantLogin(fp)
	{
		var reg = /^([sA-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
		if((reg.test(trim(fp.PLEmail.value))==false))
		{alert("Please enter your valid email address");fp.PLEmail.focus();}
		else if(trim(fp.PLName.value)=="")
		{alert("Please enter your full name");fp.PLName.focus();}
//		else if(trim(fp.partLoginJob.value)=="")
//		{alert("Please enter your");fp.partLoginJob.focus();}
//		else if(trim(fp.partLoginOrganization.value)=="")
//		{alert("Please enter a password");fp.partLoginOrganization.focus();}
		else if(trim(fp.PLRoomKey.value)=="")
		{alert("Please enter the *Room Key* of the room you want to enter");fp.PLRoomKey.focus();}
		else
		{return true;}
		return false;
	}


</script>
</body>
</html>
