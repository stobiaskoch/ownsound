<?php
//Der Pfad zum Verzeichnis
$mp3Location = '/media/usb1/Musik/ACDC/Live/';
 // This fetches a file name from the URL.
// The "basename" function is there for
// security, to make sure only a filename
// is passed, not a path.
$mp3Path = $_GET['id'];
//$mp3Name="01 Thunderstruck.mp3"; 
// Construct the actual mp3 path.
//$mp3Path = $mp3Location . $mp3Name;
 
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