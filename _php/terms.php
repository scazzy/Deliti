<?php
session_start();
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Terms - Deliti</title>
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
<span>Terms</span></div>
<div class="container " align="left"><br>
  Deliti  is a genuine site whereby the users must abide with our terms .<br>
  <br>
Deliti  uses the private data of our users in protected database that is maintained by our administrator. 
<br>

<br>
Deliti  takes pride in building strategic long-term relationships with clients or colleagues.<br>
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
