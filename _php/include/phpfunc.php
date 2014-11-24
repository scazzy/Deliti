<?php


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
	return "<img src='images/".$fileIcon."' width='16' height='16'>";
}


function getRealIpAddr()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
    {
      $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
    {
      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
      $ip=$_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

function isEmailAlreadyExists( $email )
{
    $email = $crypt->encrypt($email); 
   	
	$q="SELECT usr_email FROM user_details WHERE usr_email LIKE '$email'";
		
	$result = mysql_query($q) or die('Query failed. ' . mysql_error()); 

    return ( bool ) mysql_num_rows( $result );
}  

function cutString($strValue, $iLength)
{
	$returnValue = "";
	$strValue = trim($strValue);
	if(strlen($strValue) > $iLength)
	{
		$returnValue = substr($strValue,0,$iLength) . "...";
	}
	else
	{
		$returnValue = $strValue;
	}	
	return $returnValue;
}







//highlight search function
// Credits: http://www.bitrepository.com/
function hightlight($str, $keywords = '')
{
$keywords = preg_replace('/\s\s+/', ' ', strip_tags(trim($keywords))); // filter

$style = 'highlight';
$style_i = 'highlight_important';

/* Apply Style */

$var = '';

foreach(explode(' ', $keywords) as $keyword)
{
$replacement = "<span class='".$style."'>".$keyword."</span>";
$var .= $replacement." ";

$str = str_ireplace($keyword, $replacement, $str);
}

/* Apply Important Style */

$str = str_ireplace(rtrim($var), "<span class='".$style_i."'>".$keywords."</span>", $str);

return $str;
}
?>