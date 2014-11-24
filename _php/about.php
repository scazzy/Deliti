<?php
session_start();
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Registeration - Deliti</title>
<link rel="stylesheet" type="text/css" href="include/stylesheet.css" />
<script src="scripts/common.js"></script>
<script src="scripts/SpryTabbedPanels.js" type="text/javascript"></script>
<link href="include/SpryTabbedPanels.css" rel="stylesheet" type="text/css">
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
<span>About</span></div>
<div class="container " align="left">
  <img src="images/about_banner.jpg" width="600" height="200"><br>
  <br>
<br>
  <strong>Deliti</strong> is a fresh project for the sole purpose to help students and teachers to conduct classes outside the classes or rooms. Thus, we term and convert this purpose into a 'Virtual Classroom'. The term Virtual Classroom means conducting virtual classes in classrooms that make use of the internet technology. Our Virtual Classroom is called as <strong>Deliti</strong>.<br>
  <br>
<strong>Deliti</strong> is a Web conferencing site that allows you to meet online rather than in a conference room. It's the easiest and most cost-effective way to organize and attending lectures or meetings. 
<strong>Deliti</strong> is basically a virtual room where you can create a web conference or an online meeting. It aims not to use of any paper work and saves a lot of time that usually goes for travelling to the conference rooms.<br>
<br>
 With deliti you can organize a business meeting with your partners residing in 
different places. It supports teachers' in transforming their own role and helping 
students become more active learners. It helps integrate technology into the 
curriculum to broaden instructional options and improve the quality of teaching as 
an enhancement to the human interaction of the educational process.<br>
<br>
<strong>Deliti</strong> takes pride in building strategic long-term relationships with clients or colleagues.<br>
<br>
<b>Developed by:</b> <br>
Mahavir Jain, KC College, BSc.IT <br>
Nikesh Doshi, KC College,BSc.IT <br>
<br>
</div>
<!--End of body-->
</div>
<!--begin of footer-->
<?php include("include/footer.php");?>
<!--end of body - W800px-->
</center>
</body>
</html>
