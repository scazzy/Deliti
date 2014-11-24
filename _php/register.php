<?php
//importing and declaring encryption algorithm

include("include/secrypt.php");
$crypt = new proCrypt;

//setting values from homepage
$hfname=""; $hlname=""; $hemail=""; $hgender=""; $hcountry="";
if(isset($_POST['hrfname'])) {$hfname=$_POST['hrfname'];}
if(isset($_POST['hrlname'])) {$hlname=$_POST['hrlname'];}
if(isset($_POST['hremail'])) {$hemail=$_POST['hremail'];}
if(isset($_POST['hrgender'])) {$hgender=$_POST['hrgender'];}
if(isset($_POST['hrcountry'])) {$hcountry=$_POST['hrcountry'];}
?>

<?php
//connecting database
require ("include/config.php");
require ("include/opendb.php");
dbconnect();
$errorMessage = ""; 

if(isset($_POST['rfname']) && isset($_POST['rlname']) && isset($_POST['remail']) && isset($_POST['rpassword']) && isset($_POST['rSecQueAnswer']))
{
	
//taking values from registeration fields
$fname=trim($_POST['rfname']);
$lname=trim($_POST['rlname']);
$country=$_POST['rcountry'];
$job=trim($_POST['rjob']);
$org=trim($_POST['rorg']);
$phone=trim($_POST['rphone']);
$gender=$_POST['rgender'];
$email=$crypt->encrypt(trim($_POST['remail']));
$password=$crypt->encrypt(trim($_POST['rpassword']));
$secQuestion=trim($_POST['rSecQuestion']);
$secQAns=trim($_POST['rSecQueAnswer']);
   	
$sql="SELECT usr_email FROM user_details WHERE usr_email LIKE '$email'";
$res = mysql_query($sql) or die('Query failed. ' . mysql_error()); 
$flag=mysql_num_rows($res);
if($flag>0)
{ echo "<span style='font-family:arial;'><center><h2>Email address already exists in our database. </h2><a href='javascript:history.go(-1);'>&laquo; Go Back</a> and try again.</center></span>"; exit; }
else 
{
//storing values to database for a new user
$q="INSERT INTO  user_details(usr_fname,usr_lname,usr_email,usr_pwd,usr_phone,usr_gender,usr_country,usr_job,usr_org,usr_secQuestion,usr_secQ_Answer) VALUES ('".$fname."','".$lname."','".$email."','".$password."','".$phone."','".$gender."',".$country.",'".$job."','".$org."',".$secQuestion.",'".$secQAns."')";
 $result = mysql_query($q) or die('Query failed. ' . mysql_error()); 
 
 	if($result==1)
	{
		$q="SELECT user_id,usr_fname,usr_lname,usr_email,usr_pwd FROM user_details WHERE  usr_email  LIKE '$email' AND  usr_pwd  LIKE  '$password'";
		$result = mysql_query($q) or die('Query failed. ' . mysql_error()); 
		
		$row=mysql_fetch_array($result);
				session_start(); 
				if(isset($_SESSION['user_is_logged_in'])) {unset($_SESSION['user_is_logged_in']);}
				$_SESSION['user_is_logged_in'] = true; 
				$_SESSION['uid']=$row['user_id'];
				$_SESSION['uemail']=$lemail;
				$_SESSION['uname']=$row['usr_fname']." ".$row['usr_lname'];
		
		header('Location: signedup.php');
	}
	else
	{$errorMessage="Registration was not successful. Please try again";}
}
}
?>

<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Registeration - Cibta</title>
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
<?php include("include/header_unlogged_nav.php"); ?>

<!--End of toppart-->

<!--begin of body - W800px-->

<div class="subpage_banner" align="left"><br />
<span>Registration</span>
</div>
<div class="container" align="left">
<b> Please enter some details below and click Register to continue</b><br><br>

<?php
//show error if registeration faileds
if($errorMessage!="")
{echo "<div class='error_notification_box marb10' id='errorBox'><a href='#' class='small_close_btn floatr' onclick=\"popbox_close('errorBox');\">x</a> <span id='notify_msg'>$errorMessage</span></div>";
}
?>

<div id="" class="">
<form name="frmRegistration" action="" onSubmit="return validate_form(this);" method="post">
<span class="colorGray"><span class="colorRed">*</span> indicates Requred fields</span>
<table width="100%" cellpadding="5">
  <tr>
        	<td align="right">First Name<span class="colorRed">*</span></td>
            <td><input name="rfname" type="text" size="40" id="rfname" value="<?php echo $hfname; ?>"></td>
        </tr>
        <tr>
        	<td align="right">Last Name<span class="colorRed">*</span></td>
            <td><input name="rlname" type="text" size="40" id="rlname" value="<?php echo $hlname; ?>"></td>
        </tr>
        <tr>
        	<td align="right">I am<span class="colorRed">*</span></td>
            <td><select name="rgender" size="1" id="rgender">
            	<?php
					if($hgender=='f'){
						echo "<option value='m'>Male</option>
			              <option value='f'selected>Female</option>";
					}
                	else 
					{
			         	echo "<option value='m' selected>Male</option>
			              <option value='f'>Female</option>";
					}
				?>

            </select></td>
        </tr>
        <tr>
        	<td align="right">Country:<span class="colorRed">*</span></td>
            <td>
             <select name="rcountry" id="rcountry" size="">
             <option value="Select Country:">Select Country:</option>
			<?php      
            
            $q="SELECT country_id,country_name FROM countries";
            $result = mysql_query($q) or die('Query failed. ' . mysql_error()); 
            
            while($row=mysql_fetch_array($result))
            {
				if($row['country_id']==$hcountry)
				{echo "<option value='".$row['country_id']."' selected>".$row['country_name']."</option>";}
				else {
				echo "<option value='".$row['country_id']."'>".$row['country_name']."</option>";}
            }
            ?>
            </select>
            </td>
        </tr>
		<tr>
        	<td align="right">Job / Position</td>
            <td><input name="rjob" type="text" id="rjob" size="40"></td>
        </tr>
        <tr>
        	<td align="right">Organization / Institute</td>
            <td><input name="rorg" type="text" size="40" id="rorg"></td>
        </tr>
        <tr>
        	<td align="right">Phone</td>
            <td><input name="rphone" type="text" size="40" id="rphone"></td>
        </tr>
        <tr>
        	<td align="right">Email<span class="colorRed">*</span></td>
            <td><input name="remail" type="text" size="40" id="remail" value="<?php echo $hemail; ?>"></td>
        </tr>
        <tr>
        	<td align="right">Password<span class="colorRed">*</span></td>
            <td><input name="rpassword" type="password" size="40" id="rpassword"></td>
        </tr>
        <tr>
        	<td align="right">Confirm Password<span class="colorRed">*</span></td>
            <td><input name="rcpassword" type="password" size="40" id="rcpassword"></td>
        </tr>
        
        <tr>
          <td align="right">Security Question<span class="colorRed">*</span></td>
          <td><select name="rSecQuestion" id="rSecQuestion" style="width:270px;">
          <option value="Select a Security Question:" selected>Select a Security Question:</option>
          <?php      
            
            $q="SELECT secQ_id,sec_question FROM security_questions";
            $result = mysql_query($q) or die('Query failed. ' . mysql_error()); 
            
            while($row=mysql_fetch_array($result))
            {
                echo "<option value='".$row['secQ_id']."'>".$row['sec_question']."</option>";
            }
            ?>
          </select></td>
        </tr>
        <tr>
          <td align="right">Answer<span class="colorRed">*</span></td>
          <td><input name="rSecQueAnswer" type="text" size="40" id="rSecQueAnswer"></td>
        </tr>
        <tr>
          <td align="right">Word Verification</td>
          <td>
          <div class="floatl spam_code">
            <div id="antiSpamDiv">
			<script type='text/javascript'>refreshAntiSpamCode('antiSpamDiv');</script>
            </div>
           <!-- <div><img src="images/spacer.gif" id="randomSpamImageOverlay" title="Are you human?"  width="100" height="30" alt="Welbour" /></div>-->
            <!-- <img src="http://www.welbour.com/include/antispam.php" alt="AntiSpam by Welbour" title="Are you human?">--></div>
            <div class="floatl padl10"><input name="rAntiSpamCode" type="text" id="rAntiSpamCode" style="width:80px;" size="12" AUTOCOMPLETE="OFF"></div>
            <a href="javascript:void(0);" class="pad10 " onclick="refreshAntiSpamCode('antiSpamDiv')"><img src="images/refresh.png" title="Refresh Code" alt="Refresh Code" border="0" /></a><br clear="all">
            <span class="font10 colorGray">(Case Sensitive</span> 
          )</td>
        </tr>
        <tr>	
          <td></td>
          <td>By clicking on 'I Accept' below you are agreeing to the <a href="terms.php">Terms of Service</a> and the <a href="privacy.php">Privacy Policy</a>.</td>
        </tr>
        <tr>
          <td></td>
          <td><input name="fname4" type="submit" value="              I Accept. Register            " class="def_btn"></td>
        </tr>
    </table>
</form>
    	<br><br>
</div>
  </div>
</div>
  <!--End of body--><!--begin of footer-->
<?php include("include/footer.php");?>
<!--end of body - W800px-->
</center>


<script type="text/javascript">
	function validate_form(f)
	{
		var reg = /^([sA-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
		var b=trim(f.rAntiSpamCode.value);		
		if(trim(f.rfname.value)=="")
		{alert("Please enter your first name");f.rfname.focus();}
		else if(trim(f.rlname.value)=="")
		{alert("Please enter your last name");f.rlname.focus();}
		else if(f.rcountry.value == "Select Country:")
		{alert("Please select your country");f.rcountry.focus();}
		else if((reg.test(trim(f.remail.value))==false))
		{alert("Please enter your valid email address"); f.remail.focus();}
		else if(trim(f.rpassword.value)=="")
		{alert("Please enter a password");f.rpassword.focus();}
		else if(f.rpassword.value.length<6)
		{alert("Please enter a password of more than 6 characters");f.rpassword.focus();}
		else if(trim(f.rcpassword.value)=="" || f.rpassword.value != f.rcpassword.value)
		{alert("Password does not match. Please try again");f.rcpassword.focus();}
		else if(f.rSecQuestion.value == "Select a Security Question:")
		{alert("Please select a security question");f.rSecQuestion.focus();}
		else if(trim(f.rSecQueAnswer.value)=="")
		{alert("Please enter a valid answer for the security question");f.rSecQueAnswer.focus();}
		else if(trim(f.rAntiSpamCode.value)=="")
		{alert("Please enter the anti spam code");f.rAntiSpamCode.focus();}
		else if(spamCode!=b)
		{alert("Incorrect Code. Please try again");f.rAntiSpamCode.value=""; f.rAntiSpamCode.focus();}
		else
		{return true;}
		
		return false;
	}

  </script>
  <script type="text/javascript">
  
  </script>
</body>
</html>
