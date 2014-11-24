<?php
require("include/protect.php"); 
include("include/secrypt.php");
$crypt = new proCrypt;
//connecting database
require ("include/config.php");
require ("include/opendb.php");
dbconnect();
$errorMessage = ""; 
$successMessage="";

if(isset($_POST['txtEmail']) && isset($_POST['txtOldPwd']) && isset($_POST['txtNewPwd']) && isset($_POST['txtConfirmNewPwd'])) {

	$email=$crypt->encrypt(trim($_POST['txtEmail']));
	$oldPwd=$crypt->encrypt(trim($_POST['txtOldPwd']));
	$newPwd=$crypt->encrypt(trim($_POST['txtNewPwd']));
	$userid=$_SESSION['uid'];

	$q="SELECT * FROM user_details WHERE user_id LIKE $userid AND usr_email LIKE '$email' AND usr_pwd LIKE '$oldPwd'";
	$result=mysql_query($q) or die("Query failed. ".mysql_error());

	if(mysql_num_rows($result)==1){
		$successMessage="Email and password matched.";
		$q="UPDATE user_details SET usr_pwd='$newPwd' WHERE user_id LIKE '$userid'";
		$result=mysql_query($q) or die("Query failed. Password could not be saved. ".mysql_error());
		if($result) {
			$successMessage="Your password was changed successfully";}
		else {
			$errorMessage="There was an error saving your password. Please try again.";}
	}
	else {$errorMessage="Invalid email or password. Please try again.";}
	
}

?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Change Password - Deliti</title>
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
<div class="floatr header_right_links" align="	"> <b class="lh18"><?php echo "Welcome ".$_SESSION['uname'];?></b><br>
  <a href="home.php" class="link"> Home</a><a href="logout.php" class="link">Logout</a></div>
  </header>
<?php 
//selecting navigation menus
if(isset($_SESSION['user_is_logged_in']) && $_SESSION['user_is_logged_in']==true){
	include("include/header_logged_nav.php"); 
}
?>

<!--End of toppart-->

<!--begin of body - W800px-->

<div class="subpage_banner" align="left"><br />
<span>Change Pass****</span>
</div>
<div class="container" align="left">
  <?php
//show error if registeration faileds
if($errorMessage!="")
{echo "<div class='error_notification_box marb10' id='errorBox'><a href='#' class='small_close_btn floatr' onclick=\"popbox_close('errorBox');\">x</a> <span id='notify_msg'>$errorMessage</span></div>";
}
if($successMessage!="")
{echo "<div class='notification_box marb10' id='noteBox'><a href='#' class='small_close_btn floatr' onclick=\"popbox_close('noteBox');\">x</a> <span id='notify_msg'>$successMessage <br><br><a href='home.php'>&laquo; Go Homepage </a></span></div>";
}

?>

  <form action="" method="post" name="frmChangePwd" onSubmit="return validate_form(this);">
  <table width="" cellpadding="2" >
		<tr>
        	<td colspan="2"><b>Change Password</b></td>
        </tr>
    <tr>
      <td width="19%" align="right">Your registered Email</td>
      <td width="35%" align="left"><input name="txtEmail" type="text" id="txtEmail" size="35" /></td>
     
    </tr>
    <tr>
      <td width="19%" align="right">Old Password</td>
      <td width="35%" align="left"><input name="txtOldPwd" type="password" id="txtOldPwd" size="35" /></td>
     
    </tr>
    <tr>
      <td align="right">New Password</td>
      <td align="left"><input name="txtNewPwd" type="password" id="txtNewPwd" size="35" /></td>
      </tr>
   <tr>
      <td align="right">Confirm Password</td>
      <td align="left"><input name="txtConfirmNewPwd" type="password" id="txtConfirmNewPwd" size="35" /></td>
   </tr>
    <tr>
      <td align="right">&nbsp;</td>
      <td align="left"><input type="submit" class="def_btn" value="Change Password"></td>
      </tr>
  </table></form><br>
  
  <script type="text/javascript">
  //validate fields
function validate_form(f)
{
//var reg = /^([sA-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
	if((reg.test(trim(f.txtEmail.value))==false))
		{alert("Please enter your valid email address"); f.txtEmail.focus();}
	else if(trim(f.txtOldPwd.value)=="")
		{alert("Please enter your old password");f.txtOldPwd.value="";f.txtOldPwd.focus();}
	else if(trim(f.txtNewPwd.value)=="")
		{alert("Please enter a new password");f.txtNewPwd.value="";f.txtNewPwd.focus();}
	else if(f.txtNewPwd.value.length<6)
		{alert("Please enter a password of more than 6 characters");f.txtNewPwd.focus();}
	else if(trim(f.txtConfirmNewPwd.value)=="")
		{alert("Please confirm your new password");f.txtConfirmNewPwd.value="";f.txtConfirmNewPwd.focus();}
	else if(trim(f.txtConfirmNewPwd.value)=="" || f.txtConfirmNewPwd.value != f.txtNewPwd.value)
		{alert("Password does not match. Please try again");f.txtConfirmNewPwd.value="";f.txtConfirmNewPwd.focus();}
	
	else
	{return true;}
		
	return false;
}

  </script>
  
  
<br>
<div id="whatIsDeliti_onLogin_box">
<span>NOTE</span>
<ul><li> Your new password must be at least 6 characters in length.</li>
<li> Use a combination of letters, numbers, and punctuation.</li>
<li> Passwords are case-sensitive. Remember to check your CAPS lock key.</li>
<li> Do not use the same password that you use for other online accounts.</li>
 </ul>

</div>
  
</div>
<!--End of body-->
</div>
<!--begin of footer-->
<?php include("include/footer.php");?>
<!--end of body - W800px-->

</center>
</body>
</html>
