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
<div class="floatr header_right_links">
Welcome, <B>John Doe</B></div>
</header>
<?php include("include/header_unlogged_nav.php"); ?>

<!--End of toppart-->

<!--begin of body - W800px-->

<div class="subpage_banner" align="left"><br />
<span>Forgot Pass****</span>
</div>
<div class="container" align="left">
  <div class="notification_box marb10" id="errorBox"><a href="#" class="small_close_btn floatr" onclick="popbox_close('errorBox');">x</a> <span id="notify_msg">Password sent to your email address. </span></div>
  <form action="" method="post" name="frmLogin">
  <table width="459" cellpadding="10" >
		<tr>
        	<td colspan="2"><b>Forgot Password</b><br>
            Enter your email address which you supplied while registeration.<br>
<br>
</td>
        </tr>
    <tr>
      <td width="36%" align="right">Email Address</td>
      <td width="64%" align="left"><input name="fname2" type="text" size="35" /></td>
     
    </tr>
    <tr>
      <td align="right">&nbsp;</td>
      <td align="left"><input type="submit" class="def_btn" value="Send password"></td>
    </tr>
  </table></form><br>
<br>
</div>
<!--End of body-->
</div>
<!--begin of footer-->
<?php include("include/footer.php");?>
<!--end of body - W800px-->
</center>
<script type="text/javascript">

</script>
</body>
</html>
