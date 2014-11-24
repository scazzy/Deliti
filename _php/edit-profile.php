<?php
//importing and declaring encryption algorithm
require("include/protect.php"); 
include("include/secrypt.php");
$crypt = new proCrypt;
?>

<?php
//connecting database
require ("include/config.php");
require ("include/opendb.php");
dbconnect();
$errorMessage = ""; 
$successMessage="";

$userid=$_SESSION['uid'];

//to update the changes if made
if(isset($_POST['rfname']) && isset($_POST['rlname']) && isset($_POST['rSecQueAnswer']))
{
//taking values from registeration fields
$fname=trim($_POST['rfname']);
$lname=trim($_POST['rlname']);
$country=$_POST['rcountry'];
$job=trim($_POST['rjob']);
$org=trim($_POST['rorg']);
$phone=trim($_POST['rphone']);
$gender=$_POST['rgender'];
$secQuestion=trim($_POST['rSecQuestion']);
$secQAns=trim($_POST['rSecQueAnswer']);
   	
//storing values to database for a new user
$q="UPDATE user_details SET 
usr_fname='$fname',
usr_lname='$lname',
usr_phone='$phone',
usr_gender='$gender',
usr_country=$country,
usr_job='$job',
usr_org='$org',
usr_secQuestion=$secQuestion,
usr_secQ_Answer='$secQAns '
WHERE user_id=$userid";


 $result = mysql_query($q) or die('Query failed. ' . mysql_error()); 
 
 	if($result==1)
	{
		$successMessage="Your profile was saved successfully.";

	}
	else
	{$errorMessage="Your profile was not saved successfully. Please try again";}
}



//to show the date in fields from database
$q="SELECT * FROM user_details WHERE user_id LIKE '$userid'";
$result=mysql_query($q) or die("Query failed. ".mysql_error());
if($result){
$row=mysql_fetch_array($result);
//taking values from registeration fields
$fname=trim($row['usr_fname']);
$lname=trim($row['usr_lname']);
$country=$row['usr_country'];
$job=trim($row['usr_job']);
$org=trim($row['usr_org']);
$phone=trim($row['usr_phone']);
$gender=$row['usr_gender'];
$email=trim($crypt->decrypt(trim($row['usr_email'])));
$secQuestion=trim($row['usr_secQuestion']);
$secQAns=trim($row['usr_secQ_Answer']);
}
?>

<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Edit Profile - Cibta</title>
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
<span>Edit Profile</span>
</div>
<div class="container " align="left">
<a href="home.php" class="link">Home</a> . <a href="changepwd.php" class="link">Change Password</a><hr>
<br>
<b> Please click on 'Save Changes' after editing information.</b><br>
<br>

<?php
//show error if registeration faileds
if($errorMessage!="")
{echo "<div class='error_notification_box marb10' id='errorBox'><a href='#' class='small_close_btn floatr' onclick=\"popbox_close('errorBox');\">x</a> <span id='notify_msg'>$errorMessage</span></div>";
}
if($successMessage!="")
{echo "<div class='notification_box marb10' id='noteBox'><a href='#' class='small_close_btn floatr' onclick=\"popbox_close('noteBox');\">x</a> <span id='notify_msg'>$successMessage <br><br><a href='home.php'>&laquo; Go Homepage </a></span></div>";
}

?>

<div id="" class="">
<form name="frmEditProfile" action="" onSubmit="return validate_form(this);" method="post">
<span class="colorGray"><span class="colorRed">*</span> indicates Requred fields</span>
<table width="100%" cellpadding="5">
  <tr>
        	<td align="right">First Name<span class="colorRed">*</span></td>
            <td><input name="rfname" type="text" size="40" id="rfname" value="<?php echo $fname; ?>"></td>
        </tr>
        <tr>
        	<td align="right">Last Name<span class="colorRed">*</span></td>
            <td><input name="rlname" type="text" size="40" id="rlname" value="<?php echo $lname; ?>"></td>
        </tr>
        <tr>
        	<td align="right">I am<span class="colorRed">*</span></td>
            <td><select name="rgender" size="1" id="rgender">
            	<?php
					if($gender=='f'){
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
				if($row['country_id']==$country)
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
            <td><input name="rjob" type="text" id="rjob" value="<?php echo $job; ?>" size="40"></td>
        </tr>
        <tr>
        	<td align="right">Organization / Institute</td>
            <td><input name="rorg" type="text" id="rorg" value="<?php echo $org; ?>" size="40"></td>
        </tr>
        <tr>
        	<td align="right">Phone</td>
            <td><input name="rphone" type="text" id="rphone" value="<?php echo $phone; ?>" size="40"></td>
        </tr>
        <tr>
        	<td align="right">Email<span class="colorRed">*</span></td>
            <td><?php echo $email; ?></td>
        </tr>
        
        <tr>
          <td align="right">Security Question<span class="colorRed">*</span></td>
          <td><select name="rSecQuestion" id="rSecQuestion" style="width:270px;" onChange="javascript: document.getElementById('rSecQueAnswer').value='';">
            <option value="Select a Security Question:">Select a Security Question:</option>
            
            <?php      
            
            $q="SELECT secQ_id,sec_question FROM security_questions";
            $result = mysql_query($q) or die('Query failed. ' . mysql_error()); 
            
            while($row=mysql_fetch_array($result))
            {
				if($row['secQ_id']==$secQuestion){
                echo "<option value='".$row['secQ_id']."' selected>".$row['sec_question']."</option>";}
			else{	    echo "<option value='".$row['secQ_id']."'>".$row['sec_question']."</option>";}
            }
            ?>
            </select></td>
        </tr>
        <tr>
          <td align="right">Answer<span class="colorRed">*</span></td>
          <td><input name="rSecQueAnswer" type="text" id="rSecQueAnswer" value="<?php echo $secQAns; ?>" size="40"></td>
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
          <td><input name="fname4" type="submit" value="             Save Changes            " class="def_btn"></td>
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
