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
<span>Features</span></div>
<div class="container" align="left">
  <h1 ><strong>Online room environment for universities,companies and organisation </strong></h1>
  <p><strong> Deliti </strong>is an online web conferencing platform, built specific for the purpose to save time and learn more, ie. to host and attend, classes and meetings, at a virtual level thus making the best use of the internet.</p>
  <hr color="#cccccc" size="1"> 
  <table width="777" height="201" border="0" align="center" cellpadding="5" cellspacing="5">
    <tr>
      <td width="215" height="41"><strong>Simultaneous Rooms </strong></td>
      <td width="527">Deliti is a user project, and we allow multiple users from different locations to simultaneously create and host their classes or meetings live without any problem.</td>
    </tr>
    <tr>
      <td height="42"><strong>Start  meetings with one click</strong> </td>
      <td><p>Are you in hurry? No need to fill up those big forms to create a classroom. Use our Quick Room facility to simply click and go to the room and invite participants for the same.                                                    </p>
        </td>
    </tr>
    <tr>
      <td height="36"><strong>Geo Location</strong> </td>
      <td>A feature of HTML5 that allows to get the exact location details of the user/participant while logging in or attending a class.</td>
    </tr>
    <tr>
      <td height="57"><strong >No registeration to attend a class</strong></td>
      <td>Usually users get bored to type in long details, more when they actually not becoming a member but simply want to attend a meeting. We let them be free, by just entering their very basic details and the roomkey and nothing else and get headed to attend the webcast.</td>
    </tr>
  </table><hr color="#cccccc" size="1"> <br>
<br>
  <h3 class="style1">Inside the Classroom</h3>
  <p>The collaborative web conferencing environment enables you to communicate synchronously using audio, video or text chat, interactive whiteboard , live notepad and content sharing.</p>
  <hr color="#cccccc" size="1"> 
  <table width="777" height="247" border="0" cellpadding="5" cellspacing="5">
    <tr>
      <td width="215" height="36"><strong >Interactive Whiteboard</strong></td>
      <td width="527">Everything you need to write in the class is at your fingertips-  Free hand drawing. When words run out, the white board is easy for chalk-talks</td>
    </tr>
    <tr>
      <td height="36"><strong >Live <strong>Multi userchat/</strong><strong>Discussion </strong></strong></td>
      <td>This is the main feature that allows for live syncrhnized real-time multiuser discussions that let's you raise queries, share information, or simply chat.</td>
    </tr>
    <tr>
      <td height="35"><strong >Host-Video/Audio Conferencing</strong></td>
      <td> All the participants can see, as well as hear the presenter live through our custom built broadcast players.</td>
    </tr>
    <tr>
      <td height="35"><strong>Videocast Recorder</strong></td>
      <td>This option allows the host to record their live video broadcastings which then later can be used to view the host meeting activity. [The option to view the recorded cast is for future enhancement]</td>
    </tr>
    <tr>
      <td height="35"><strong>Live Notepad</strong> </td>
      <td>You can note down realtime notes on the notepad without interfering your meeting by switching windows.</td>
    </tr>
    <tr>
      <td height="35"><strong >Document &amp; File   Sharing</strong></td>
      <td>Pre-built content can be uploaded in formats like Word, PDF, PowerPoint,  Excel ,jpg ,png ,rar ,zip ,RichText.</td>
    </tr>
     <tr>
      <td height="35"><strong >Participant Detail viewer</strong></td>
      <td>Each participant can see basic details of other participants attending that meeitng/class.</td>
    </tr>
  </table>
  </div>
<!--End of body-->
</div>
<!--begin of footer-->
<?php include("include/footer.php");?>
<!--end of body - W800px-->
</center>
</body>
</html>
