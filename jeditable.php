<?php
require_once('config.inc.php');
mysql_connect(DBHOST, DBUSER,DBPASS) OR DIE ("NICHT Erlaubt");
mysql_select_db(DBDATABASE) or die ("Die Datenbank existiert nicht.");
mysql_query("SET NAMES 'utf8'");

$id = $_REQUEST['id'];
$newvalue = urldecode($_REQUEST['value']);
$order = $_REQUEST['order'];


		if($_REQUEST['order']=="title" or $_REQUEST['order']=="album") {
			$sql    = "UPDATE `".$order."` SET name='$newvalue' WHERE id='$id'";
		}
		if($_REQUEST['order']=="track") {
			$sql    = "UPDATE `title` SET track='$newvalue' WHERE id='$id'";
		}
		
		
		
		
		
		$query = mysql_query($sql);


?>

