<?php
$id = $_GET['id'];
require_once('config.inc.php');

mysql_connect(DBHOST, DBUSER,DBPASS) OR DIE ("NICHT Erlaubt");
mysql_select_db(DBDATABASE) or die ("Die Datenbank existiert nicht.");
 
 
 				$sql    = "SELECT path FROM title WHERE id = '$id'";
				$query = mysql_query($sql); 
				$Daten = mysql_fetch_assoc($query); 
				$mp3Path = $Daten['path'];
 
// Make sure the file exists
if(!file_exists($mp3Path) || !is_file($mp3Path)) {
    header('HTTP/1.0 404 Not Found');
    die('The file does not exist');
}
 
// Set the appropriate content-type
// and provide the content-length.
$mime_type = "audio/mpeg"; 
$fsize=filesize($mp3Path);
$shortlen=$fsize-1;
header('Content-type: '.$mime_type);
header('Content-length: ' .$fsize);
header('Cache-Control: no-cache');
header( 'Content-Range: bytes 0-'.$shortlen.'/'.$fsize); 
header( 'Accept-Ranges: bytes');
 
// Print the mp3 data
readfile($mp3Path);
?>
