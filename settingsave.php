<?php
$dbhost = $_REQUEST['dbhost'];
$dbuser = $_REQUEST['dbuser'];
$dbpass = $_REQUEST['dbpass'];
$dbname = $_REQUEST['dbname'];
$musicdir = $_REQUEST['musicdir'];
$ownurl = $_REQUEST['ownurl'];
unlink('config.inc.php');
/*
mysql_connect($dbhost, $dbuser, $dbpass);
mysql_select_db($dbname) or die ("Die Datenbank existiert nicht.");
*/
    $handle = fopen ( "config.inc.php", "w" );
 
	fwrite ( $handle, '<?php
	');
	fwrite ( $handle, '//Database Settings
	');
    fwrite ( $handle, 'define("DBHOST", "'.$dbhost.'");
	');
    fwrite ( $handle, 'define("DBUSER", "'.$dbuser.'");
	');
	fwrite ( $handle, 'define("DBPASS", "'.$dbpass.'");
	');
	fwrite ( $handle, 'define("DBDATABASE", "'.$dbname.'");
	');
	fwrite ( $handle, '//Musicdirectory
	');
	fwrite ( $handle, 'define("MUSICDIR", "'.$musicdir.'");
	');
	fwrite ( $handle, '//Url
	');
	fwrite ( $handle, 'define("OWNURL", "'.$ownurl.'");
	');
 	fwrite ( $handle, '?>');
    fclose ( $handle );
?>