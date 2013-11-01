<?php
require_once('config.inc.php');
mysql_connect(DBHOST, DBUSER,DBPASS) OR DIE ("NICHT Erlaubt");
mysql_select_db(DBDATABASE) or die ("Die Datenbank existiert nicht.");

$id = $_REQUEST['id'];
$newvalue = $_REQUEST['value'];

	$sql    = "UPDATE `album` SET name='$newvalue' WHERE id='$id'";
	$query = mysql_query($sql);

echo $newvalue;
?>

