<script src="./js/jquery.loadmask.min.js"></script>
<?php
require_once('config.inc.php');
mysql_connect(DBHOST, DBUSER,DBPASS);
mysql_select_db(DBDATABASE) or die ("Die Datenbank existiert nicht."); 

$artistresult = mysql_query("SELECT * FROM artist"); 
$artist = mysql_num_rows($artistresult);

$albumresult = mysql_query("SELECT * FROM album"); 
$album = mysql_num_rows($albumresult);

$titleresult = mysql_query("SELECT * FROM title"); 
$title = mysql_num_rows($titleresult);

$nocoverresult = mysql_query("SELECT * FROM album WHERE cover='no'"); 
$nocover = mysql_num_rows($nocoverresult);

echo "$artist Künstler<br>";
echo "$album Alben<br>";
echo "$title Tracks<br>";
?>
<a href='#ownsound' onclick="nocover()"><?php echo $nocover; ?> ohne Cover</a>
<?php

?>
