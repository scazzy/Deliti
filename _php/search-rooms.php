<?php
session_start(); 

require("include/config.php");
require("include/opendb.php");
dbconnect();

$searchWrd="";
if(isset($_GET['search']) && trim($_GET['search'])!=""){
$searchWrd=trim($_GET['search']);
}
include("include/phpfunc.php");
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Search Room - Cibta</title>
<link rel="stylesheet" type="text/css" href="include/stylesheet.css" />
<script src="scripts/common.js"></script>
<script src="scripts/SpryTooltip.js" type="text/javascript"></script>
<link href="include/SpryTooltip.css" rel="stylesheet" type="text/css">
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
<span>Search rooms</span>
</div>
<div class="container" align="left">
  <form action="" method="get" name="frmLogin">
 Enter meeting title, description or room key<br>
<input name="search" type="text" id="search" size="35" value="<?php echo $searchWrd;?>" /> <input type="submit" class="def_btn" value="Search"></form><br>

<?php
//searching rooms
$searchWrd="";
if(isset($_GET['search']) && trim($_GET['search'])!=""){
$searchWrd=trim($_GET['search']);
$cur_q="SELECT rd.*,ud.user_id as uid,ud.usr_fname as ufname,ud.usr_lname as ulname FROM room_details as rd,user_details as ud WHERE ud.user_id = rd.user_id AND rd.room_key LIKE '%$searchWrd%'  AND rd.end_dt IS NULL UNION
SELECT rd.*,ud.user_id,ud.usr_fname,ud.usr_lname FROM room_details as rd,user_details as ud WHERE ud.user_id = rd.user_id  AND rd.title LIKE '$searchWrd%' AND rd.end_dt IS NULL UNION
SELECT rd.*,ud.user_id,ud.usr_fname,ud.usr_lname FROM room_details as rd,user_details as ud WHERE ud.user_id = rd.user_id  AND rd.agenda LIKE '%$searchWrd%'  AND rd.end_dt IS NULL";
$cur_rooms=mysql_query($cur_q) or die("Search query failed. - ".mysql_error());
}

if($searchWrd!=""){
//echo "<b>".mysql_num_rows($cur_rooms)."</b> records found for <b>".$searchWrd."</b>";

?>

<div class="search_room_table" id="search_results">
<table width="100%">
  <tr>
    <th>#</th>
    <th>Room Key</th>
    <th>Title</th>
    <th>DateTime</th>
    <th>Ending / Duration</th>
    <th>By</th>
  </tr>

<tr><td colspan="6" class="bgyellow pad5" style="background:#E0F1FC"><br>

      <b class="pad5">Current Room(s)</b><br>
</td></tr>
<br>

  <?php
if(mysql_num_rows($cur_rooms)<=0){echo "<tr><td colspan='6'> No Live rooms matched.</td></tr>";}
$count=0;

  while($row=mysql_fetch_array($cur_rooms)){
		
	  $count++;
	  $startDT=date("d F,  Y  h:i",strtotime($row['start_dt'])); 
	 echo " <tr id='".$row['room_key']."' title='".$row['agenda']."'>
    <td>$count</td>
    <td><a href='join-room.php?roomkey=".$row['room_key']."'>".hightlight($row['room_key'], $searchWrd)."</a></td>
    <td>".hightlight($row['title'], $searchWrd)."</td>
    <td>".$startDT."</td>
    <td>LIVE</td>
    <td><a href='#'>".$row['ufname']." ".$row['ulname']."</a></td>
  </tr>";
}

} 

  ?>

 <!-- <tr id="sprytrigger2">
    <td>2</td>
    <td><a href="#">6s4w84</a></td>
    <td><a href="#">MIX 2011 Conference</a></td>
    <td>Sunday, Jan 22,2011</td>
    <td>OnGoing</td>
    <td><a href="#">Jerrard Butler</a></td>
  </tr>
  -->

<?php 



if(isset($_GET['search']) && trim($_GET['search'])!=""){
$searchWrd=trim($_GET['search']);

$pst_q="SELECT rd.*,ud.user_id as uid,ud.usr_fname as ufname,ud.usr_lname as ulname FROM room_details as rd,user_details as ud WHERE ud.user_id = rd.user_id AND rd.room_key LIKE '%$searchWrd%'  AND rd.end_dt IS NOT NULL UNION
SELECT rd.*,ud.user_id,ud.usr_fname,ud.usr_lname FROM room_details as rd,user_details as ud WHERE ud.user_id = rd.user_id  AND rd.title LIKE '$searchWrd%'  AND rd.end_dt IS NOT NULL  UNION
SELECT rd.*,ud.user_id,ud.usr_fname,ud.usr_lname FROM room_details as rd,user_details as ud WHERE ud.user_id = rd.user_id  AND rd.agenda LIKE '%$searchWrd%'  AND rd.end_dt IS NOT NULL" ;
//OR  
$pst_rooms=mysql_query($pst_q) or die("Search query failed. - ".mysql_error());
}

if($searchWrd!=""){
//echo "<b>".mysql_num_rows($pst_rooms)."</b> records found for <b>".$searchWrd."</b>";

?>



<tr><td colspan="6" class="bgyellow pad5" style="background:#eee"><br>
      <b class="pad5" style="">Past Room(s)</b><br>
</td></tr>

<?php
$count=0;
if(mysql_num_rows($pst_rooms)<=0){echo "<tr><td colspan='6'> No rooms matched.</td></tr>";}
  while($row=mysql_fetch_array($pst_rooms)){
	  $count++;
	  $startDT=date("d F,  Y  h:i",strtotime($row['start_dt'])); 
	  $endDT=date("d F,  Y  h:i",strtotime($row['end_dt'])); 
	 echo " <tr id='".$row['room_key']."' title='".$row['agenda']."'>
    <td>$count</td>
    <td><a href='viewroom.php?roomkey=".$row['room_key']."' target='_blank'>".hightlight($row['room_key'], $searchWrd)."</a></td>
    <td>".hightlight($row['title'], $searchWrd)."</td>
    <td>".$startDT."</td>
    <td>".$endDT."</td>
    <td><a href='#'>".$row['ufname']." ".$row['ulname']."</a></td>
  </tr>";
}

}
?>



</table>
</div>
</div>
<!--End of body-->
</div>
<!--begin of footer-->
<?php include("include/footer.php");?>
<!--end of body - W800px-->
</center>
<!--
<div class="tooltipContent" id="sprytooltip1">
	<b>Google IO conference 2010</b><br>
    This is some text agenda for timepass. Hope you don't mind it.<br>
    <br>
  <span class="colorGray">Thursday, May 20, 2010</span><br>
	By: George Alimuth
</div>
-->
</body>
</html>
