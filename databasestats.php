<?php
mysql_connect("localhost", "root","strese84");
mysql_select_db("musikdatenbank") or die ("Die Datenbank existiert nicht."); 

$artistresult = mysql_query("SELECT * FROM artist"); 
$artist = mysql_num_rows($artistresult);

$albumresult = mysql_query("SELECT * FROM album"); 
$album = mysql_num_rows($albumresult);

$titleresult = mysql_query("SELECT * FROM title"); 
$title = mysql_num_rows($titleresult);

echo "$artist Künstler<br>";
echo "$album Alben<br>";
echo "$title Tracks<br>";

?>