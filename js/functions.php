<?php
require_once('../ownsound/config.inc.php');
mysql_connect(DBHOST, DBUSER,DBPASS);
mysql_select_db(DBDATABASE) or die ("Die Datenbank existiert nicht."); 

function getartist ($id) {

				$sql    = "SELECT name FROM artist WHERE id = '$id'";
				$query = mysql_query($sql); 
				$Daten = mysql_fetch_assoc($query); 
				
				echo $Daten['name'];

}

function getalbum ($id) {

				$sql    = "SELECT name FROM album WHERE id = '$id'";
				$query = mysql_query($sql); 
				$Daten = mysql_fetch_assoc($query); 
				
				echo $Daten['name'];

}

function gettitle ($id) {

				$sql    = "SELECT name FROM title WHERE id = '$id'";
				$query = mysql_query($sql); 
				$Daten = mysql_fetch_assoc($query); 
				
				echo $Daten['name'];

}
?>