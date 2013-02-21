<?php
session_start();
include_once("model.php");
$ip= $_SERVER['REMOTE_ADDR'];
echo "Beshi kore biri khan vater upor chap koman.<br/>"; // dummy text you can delete it.
if(!isset($_SESSION["ip"]))
{
	$_SESSION["ip"]=$ip;
	insertIP($ip);
	mailIP($ip);
	mysql_close($con);
}
?>