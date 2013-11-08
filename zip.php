<?php
error_reporting(E_ALL);
if (is_writable("./tmp")) {

} else {
    die('Die Datei kann nicht geschrieben werden');
}
require_once('config.inc.php');
include('./js/functions.php');
$path = array();
$albumID = $_REQUEST['albumID'];
$db_link = mysqli_connect (DBHOST, DBUSER, DBPASS, DBDATABASE );
$sql = "SELECT * FROM `title` WHERE album='".$albumID."' ORDER BY path";
$zipname = urlencode(getalbum($albumID));
	$db_erg = mysqli_query( $db_link, $sql );
	if ( ! $db_erg )
	{
		die('Ungültige Abfrage: ' . mysqli_error());
	}

    if (!extension_loaded('zip')) {
        return false;
    }
	$tempfile = tempnam("tmp","zip");
    $zip = new ZipArchive();
    $zip->open($tempfile,ZipArchive::OVERWRITE);

	while ($zeile = mysqli_fetch_array( $db_erg, MYSQL_ASSOC))
	{
		$path = $zeile['path'];
		$zip->addFile($path);
		
	}
	
    $zip->close();
	header('Content-Type: application/zip');
	header('Content-Length: ' . filesize($tempfile));
	header('Content-Disposition: attachment; filename='.$zipname.'.zip');
	readfile($tempfile);
	unlink($tempfile); 
?>