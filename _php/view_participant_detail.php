<?php
session_start();
require("include/config.php");
require("include/opendb.php");
dbconnect();
?>

<html>
<head>
<style type="text/css">

</style>
</head>
<body>
<?php
if(isset($_GET['pid'])) {
$pid=trim($_GET['pid']);
if($pid==""){echo "Hohoho! You missed select the participant!"; exit;}

$q="SELECT * FROM participant_details WHERE participant_id LIKE '$pid'";
$result=mysql_query($q) or die("Query failed. - ".mysql_query());
if(mysql_num_rows($result)<1) {echo "Participant does not exist. ";exit;}
$row=mysql_fetch_array($result);
$name=$row['prt_name'];
$gender="Male"; if($row['prt_gender']=='f'){$gender="Female";}
$job=$row['prt_job'];
$org=$row['prt_org'];
$location=$row['prt_geo_location'];
$smapURL="";
if(trim($location)!=""){

$smapURL="<img border='0' src='http://maps.google.com/maps/api/staticmap?center=".$location."&size=120x120&maptype=terrain&sensor=true&markers=color:blue|label:ABBD|$location'>";
}

echo "<table width='98%' cellpadding='2' class='floatl'  style='font-family:tahoma,arial; font-size:13px;'>
        <tr>
	        <td rowspan='5' width='20'>$smapURL</td>
          <td width='100' valign='top'><b>Name:</b></td>
          <td>$name</td>
		</tr>
        <tr>
          <td><b>Gender:</b></td>
          <td>$gender</td>
        </tr>
        <tr>
        <td><b>Job:</b></td>
        <td>$job</td>
        </tr>
        <tr>
        <td><b>Organization:</b></td>
        <td>$org</td>
        </tr>
        <tr>
        
		
    </table>
";
}
else {
	echo "Click on a participant to view its details.";
}
?>
</body></html>