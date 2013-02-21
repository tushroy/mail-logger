<?php
include_once("config.php");
$con = mysql_connect($mySQLserver,$mySQLuser,$mySQLpass);
if (!$con)
{
	echo('Could not connect to database: ' . mysql_error());
}
 
$db=mysql_select_db($mySQLdb, $con);
if(!$db)
{
	mysql_query("CREATE DATABASE $mySQLdb",$con);
	mysql_select_db($mySQLdb, $con);
}
//to module with wp
 
$sql="CREATE TABLE IF NOT EXISTS `ip_addr_store` (
`ip_addr` VARCHAR( 15 ) NOT NULL,
`time_stamp` VARCHAR( 20 ),
`user_agent` VARCHAR( 200 ) NOT NULL,
PRIMARY KEY ( `time_stamp` )
)";
mysql_query($sql);
 
function insertIP($ip)
{
	$time=time();
	$query="INSERT INTO `ip_addr_store` VALUES('".$ip."','".$time."','".$_SERVER['HTTP_USER_AGENT']."');";
	$result = mysql_query($query);
	return $result;
}
 
$visitor_res=mysql_query("SELECT * FROM `ip_addr_store`;");
function getDataRows($visitor_res)
{
	if($visitor_res)
{
return mysql_fetch_row($visitor_res);
}
else
{
	return '';
}
}
function tableTruncate()
{
	return mysql_query("TRUNCATE TABLE `ip_addr_store`;");
}
function mailIP($ip)
{
	global $toAddr,$fromAddr,$toSubj;
	$message="IP: $ip has logged into the site.nHostname: "
	.gethostbyaddr($ip).
	"nUser Agent: ".$_SERVER['HTTP_USER_AGENT'].
	"nReferer: ".$_SERVER['HTTP_REFERER'].
	"nX Forward: ".$_SERVER['HTTP_X_FORWARDED_FOR'];
	$mail_hdr = "From: $fromAddr";
	if(!mail($toAddr, $toSubj,$message,$mail_hdr))
	{
		echo "mail sending failed.";
	}
}
?>