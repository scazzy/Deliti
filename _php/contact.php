<?php
session_start();
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Registeration - Deliti</title>
<link rel="stylesheet" type="text/css" href="include/stylesheet.css" />
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
<span>Contact Us</span></div>
<div class="container" align="left">
<img src="images/contact_banner.jpg" >
</div>
<!--End of body-->
</div>
<!--begin of footer-->
<div class="footer w800">
<div class="floatl">© 2010 Deliti</div>
<div class="floatr"><a href="about.php" class="link">About Us</a> <a href="contact.php" class="link">Contact</a><a href="terms.php" class="link">Terms</a> <a href="privacy.php" class="link">Privacy</a></div><br clear="all" />
</div>
<!--end of body - W800px-->
</center>
</body>
</html>
