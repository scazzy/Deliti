<?php
ob_start();
session_start();
require("include/participant-protect.php");
include("include/phpfunc.php");
require("include/config.php");
require("include/opendb.php");
dbconnect();

$output = "";
$filename="";
$filetype="";
$filesize="";
$roomkey=$_SESSION['roomkey'];
$partid=$_SESSION['part_id'];

$uploadDir="users/documents/";
$fileurl="http://localhost/project/".$uploadDir;

if (($_FILES["file"]["type"] == "application/msword")
|| ($_FILES["file"]["type"] == "text/richtext")
|| ($_FILES["file"]["type"] == "application/pdf")
|| ($_FILES["file"]["type"] == "text/html")
|| ($_FILES["file"]["type"] == "text/plain")
|| ($_FILES["file"]["type"] == "text/richtext")
|| ($_FILES["file"]["type"] == "image/gif")
|| ($_FILES["file"]["type"] == "image/jpg")
|| ($_FILES["file"]["type"] == "image/jpeg")
|| ($_FILES["file"]["type"] == "image/pjpeg")
|| ($_FILES["file"]["type"] == "image/png")
|| ($_FILES["file"]["type"] == "image/x-png")
|| ($_FILES["file"]["type"] == "application/zip")
|| ($_FILES["file"]["type"] == "application/rar")
|| ($_FILES["file"]["type"] == "application/vnd.ms-excel")
|| ($_FILES["file"]["type"] == "application/vnd.ms-powerpoint")

&& ($_FILES["file"]["size"] < 50000))
  {
  if ($_FILES["file"]["error"] > 0)
    {
    $output= "Return Code: " . $_FILES["file"]["error"] . "<br />";
    }
  else
    {
		$filename=$_FILES["file"]["name"];
		$filetype=$_FILES["file"]["type"];
		$filesize=round(($_FILES["file"]["size"]/1024),2);
		
		
    echo "File <b>" . $filename . "</b> ";
  //  echo "Type: " . $filetype . "<br />";
    echo " (" . $filesize . " Kb)";
  //  echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";

    if (file_exists($uploadDir . $filename))
      {
      $output= "File <b>".$filename . "</b> already exists on the server. ";
      }
    else
      {
      move_uploaded_file($_FILES["file"]["tmp_name"],$uploadDir . $filename);
	  
	  $fileurl.=$filename;
	  
	  $q="INSERT INTO sharedfiles(file_name,file_size,file_type,file_url,roomkey,participant_id)
	  VALUES('$filename','$filesize','$filetype','$fileurl','$roomkey','$partid')";
	  $result=mysql_query($q) or die("Query failed. ".+mysql_error());
	  if($result){

	      $output= "File <b>" . $filename . "</b> uploaded for sharing successfully.";
		 
	  }
	  else {
		  $output= "There was some problem in storing the file on the server. Please go back and try again.";
	  }
      }
    }
  }
else
  {
  $output= "Invalid file type or file exceeds size limit of 5Mb.";
  }
header("location: file-uploader.php?st=".$output);
  
?>
