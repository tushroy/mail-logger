<?php
include_once("model.php");
if($_GET["truncate"]=="1")
{
	tableTruncate();
	echo "Table truncated</br>";
	echo '<a href="userlist.php">Back</a>';
	mysql_close($con);
	die();
}
?>
<a href="userlist.php?truncate=1"><b>Truncate data</b></a>
<table border=1px>
<tr>
<th>IP</th><th>Date-Time</th><th>User Agent</th>
</tr>
<?php
while($row = getDataRows($visitor_res))
	echo "<tr><td>".$row[0]."</td><td>".date('d-m-y at h:i:s a',$row[1])."</td><td>".$row[2]."</td></tr>";
?>
</table>
<?php mysql_close($con); ?>