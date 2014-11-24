<?php
include("include/protect.php");
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Deliti - Registration</title>
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
	<!--<nav id="navigation"  class="w800">
<ul>
    	<li><a href="index.php">Home</a></li>
        <li><img src="images/homepage_nav_seperator.gif"/></li>
        <li><a href="schedule-room.php">Schedule a Room</a></li>
        <li><img src="images/homepage_nav_seperator.gif"/></li>
    	<li><a href="#">Features</a></li>
        <li><img src="images/homepage_nav_seperator.gif"/></li>
        <li><a href="#">Take-a-Tour</a></li>
        <li><img src="images/homepage_nav_seperator.gif"/></li>
        <li><a href="register.php">Join Now!</a></li>
    </ul>
</nav>-->

<!--End of toppart-->

<!--begin of body - W800px-->

<div class="subpage_banner" align="left"><br />
<span>You're in!</span></div>
<div class="container" align="left"><h2>Thank You for joining Deliti</h2>
<h3>Now enjoy this fresh product anytime from anywhere to conduct your meetings or classrooms.</h3>
  <br>
  At Deliti you can <br>
  - Conduct your own meetings, and webinars right now using the world's, easiest online conference ... Deliti!<br>
- Share your desktop<br>
- Show presentations<br>
- Collaborate live<br>
... and much, much more<br>
<br>
<br>
<a href="home.php" class="link">Go to your home page right now &rsaquo;</a> <img src="images/spacer.gif" width="20" height="1" alt="Web Conference"><a href="logout.php">Log Out to come back later </a>
<br>
<br> <br>
<br>

<a href="#" class="link">What you can do?</a>  <a href="#" class="link">Spread the word!</a><br>
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
