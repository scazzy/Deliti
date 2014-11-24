<?php
function dbconnect()
{
	require("config.php");	
	global $dbhost, $dbname, $dbuname, $dbpass;
	@mysql_connect($dbhost, $dbuname, $dbpass);
	@mysql_select_db($dbname) or die ("Database could not be loaded");
}
?>