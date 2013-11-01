<?php
require_once('config.inc.php');
mysql_connect(DBHOST, DBUSER,DBPASS) OR DIE ("NICHT Erlaubt");
mysql_select_db(DBDATABASE) or die ("Die Datenbank existiert nicht.");

$id = $_REQUEST['id'];
$newvalue = $_REQUEST['value'];
//mysql_query("UPDATE album SET name=$newvalue WHERE id='$id'");

	$sql    = "UPDATE `album` SET name='$newvalue' WHERE id='$id'";
//		$sql = "INSERT INTO album (name) VALUE ('$newvalue')";
		$query = mysql_query($sql);
		echo mysql_error();
		
echo $newvalue;
?>

