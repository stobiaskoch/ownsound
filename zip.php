<?php
if (is_writable("./tmp")) {
} else {
    die('Die Datei kann nicht geschrieben werden');
}
require_once('config.inc.php');
include('./js/functions.php');
$path = array();
$albumID = $_REQUEST['albumID'];
$artistID = getartistIDfromalbumID($albumID);
$artist = getartist($artistID);
$album = getalbum($albumID);

$db_link = mysqli_connect (DBHOST, DBUSER, DBPASS, DBDATABASE );
$sql = "SELECT * FROM `title` WHERE album='".$albumID."' ORDER BY path";
$zipname = $artist . " - " . $album;

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
		$new_filename = substr($path,strrpos($path,'/') + 1);
		$zip->addFile($path,$new_filename);
		
	}
	$query = "select imgdata,imgtype,imgdata_small from album where id=$albumID";
	$result = @MYSQL_QUERY($query); 
	$data = @MYSQL_RESULT($result,0,"imgdata"); 
	$file = './tmp/folder.jpeg';
	$handle = fopen ($file, 'w+');
	fwrite($handle, $data);
	fclose($handle);
	$new_filename = substr($file,strrpos($file,'/') + 1);
	$zip->addFile($file,$new_filename);
    $zip->close();
	header('Content-Type: application/zip; charset=ISO-8859-1');
	header('Content-Length: ' . filesize($tempfile));
	header('Content-Disposition: attachment; filename='.$zipname.'.zip');
	readfile($tempfile);
	unlink($file);
	unlink($tempfile); 
?>