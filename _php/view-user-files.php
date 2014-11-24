<?php
ob_start();
session_start();
require("include/participant-protect.php");
//include("include/phpfunc.php");
require("include/config.php");
require("include/opendb.php");
dbconnect();

$roomkey=$_SESSION['roomkey'];
$partid=$_SESSION['part_id'];



$q="SELECT sf.*,pd.participant_id AS pid, pd.prt_name AS pname FROM sharedfiles AS sf, participant_details AS pd WHERE roomkey LIKE '$roomkey' AND sf.participant_id = pd.participant_id ORDER BY uploadedOn DESC";
$result=mysql_query($q) or die("Query failed. "+mysql_error());;
$totalFiles=mysql_num_rows($result);
if($totalFiles<1){echo "No files shared yet."; exit;}
//echo $totalFiles;
if($result) {
echo "<table width='100%' cellpadding='5' cellspacing='0' border='0'>";	
	while($row=mysql_fetch_array($result)){
  	$downloadpath="../users/documents/".$row['file_name'];
		echo "<tr>
			    <td width='16'>".checkFileTypeImg($row['file_type'])."</td>
			    <td width='180' title='Shared by ".$row['pname']."'>".$row['file_name']."</td>
			    <td width='18'><a href='".$downloadpath."' title='View/Download File (".$row['file_size']." Kb)' target='_blank'>
				<img src='../images/buttons/download_arrow_small.gif' alt='Download file' width='8' height='9' border='0' title='View/Download file (".$row['file_size']." Kb)'></a></td>
			</tr>";
		
	}
echo "</table>";	


}
else{
	echo "No files on the server";
}

function checkFileTypeImg($str){
	$fileIcon="";
	switch($str) {
		case 'application/msword':
			$fileIcon= "icon-wordDoc.png";
			break;
		case 'application/pdf':
			$fileIcon= "icon-pdf.png";
			break;
		case 'text/richtext':
		case 'text/html':
		case 'text/plain':
			$fileIcon= "icon-textDoc.png";
			break;
		case "image/gif":
		case "image/jpeg":
		case "image/pjpeg":
		case "image/png":
		case "image/x-png":
			$fileIcon= "icon-images.png";
			break;
		case "application/zip":
		case "application/rar":
			$fileIcon= "icon-zip.png";
			break;
		case "application/vnd.ms-excel":
			$fileIcon= "icon-excelDoc.png";
			break;
		case "application/vnd.ms-powerpoint":
			$fileIcon= "icon-powerpointDoc.png";
			break;
			
		default:
			$fileIcon= "icon-unknownDoc.png";
			break;
	}
	return "<img src='../images/".$fileIcon."' width='16' height='16'>";
}


?>



