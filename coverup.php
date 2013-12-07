<?php
$dbhost = $_REQUEST['dbhost'];
$dbuser = $_REQUEST['dbuser'];
$dbpass = $_REQUEST['dbpass'];
$dbname = $_REQUEST['dbname'];
$musicdir = $_REQUEST['musicdir'];
$ownurl = $_REQUEST['ownurl'];

mysql_connect($dbhost, $dbuser, $dbpass);
mysql_select_db($dbname) or die ("Die Datenbank existiert nicht.");

    $handle = fopen ( "config.inc.php", "w" );
 
    // schreiben des Inhaltes von email
    fwrite ( $handle, 'define("DBHOST", "'.$dbhost.'");');
    fwrite ( $handle, 'define("DBUSER", "'.$dbuser.'");');
	fwrite ( $handle, 'define("DBPASS", "'.$dbpass.'");');
	fwrite ( $handle, 'define("DBDATABASE", "'.$dbname.'");');
	fwrite ( $handle, 'define("MUSICDIR", "'.$musicdir.'");');
	fwrite ( $handle, 'define("OWNURL", "'.$ownurl.'");');
 
    // Datei schließen
    fclose ( $handle );



?>