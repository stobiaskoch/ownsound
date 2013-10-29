<?php
echo '<html><head>';
echo '<title>getID3() - /demo/demo.simple.php (sample script)</title>';
echo '<style type="text/css">BODY,TD,TH { font-family: sans-serif; font-size: 9pt; }</style>';
echo '</head><body>';
$titlecount = "0";
//Dummfug vom KRAUSE
// include getID3() library (can be in a different directory if full path is specified)
require_once('./getid3/getid3.php');

// Initialize getID3 engine
$getID3 = new getID3;
$now = date('Y-m-d');
$now2 = date('H.m.s');
$now3 = "$now $now2";
//$DirectoryToScan = '/mnt/musik/Eisregen/2009 - Buehnenblut/CD1'; // change to whatever directory you want to scan
$DirectoryToScan = $_REQUEST['dirtoscan'];
if($DirectoryToScan=="ende") { goto ende; }
echo "Durchsuche Verzeichniss: $DirectoryToScan<br>";
//die();
$dir = opendir($DirectoryToScan);

mysql_connect("localhost", "root","strese84");
mysql_select_db("musikdatenbank") or die ("Die Datenbank existiert nicht.");

//echo $Daten['id'];


while (($file = readdir($dir)) !== false) {
	$FullFileName = realpath($DirectoryToScan.'/'.$file);
	if ((substr($FullFileName, 0, 1) != '.') && is_file($FullFileName)) {
		set_time_limit(30);

		$ThisFileInfo = $getID3->analyze($FullFileName);

		getid3_lib::CopyTagsToComments($ThisFileInfo);
		if($ThisFileInfo['fileformat']=="mp3") {
		$artist = $ThisFileInfo['comments_html']['artist'][0];
		
	$sql    = "SELECT name FROM artist WHERE name  = '$artist'";
$query = mysql_query($sql); 
$Daten = mysql_fetch_assoc($query); 
$checkartist = $Daten['name'];

	if($checkartist!=$artist) {
mysql_query("INSERT INTO artist (name) VALUES ('$artist')");
//mysql_query("INSERT INTO `scanner_log` SET artist=artist+1 ON DUPLICATE KEY UPDATE artist=artist+1"); 
mysql_query("UPDATE scanner_log SET artist=artist+1 WHERE id='0'");
echo mysql_error();
}


$sql    = "SELECT id FROM artist WHERE name  = '$artist'";
$query = mysql_query($sql); 
$Daten = mysql_fetch_assoc($query); 
$artistID = $Daten['id'];	
	
		$album = $ThisFileInfo['comments_html']['album'][0];
		
//mysql_query("INSERT INTO album (name, artist) VALUES ('$album', '$artistID')");	

$sql    = "SELECT name FROM album WHERE name  = '$album'";
$query = mysql_query($sql); 
$Daten = mysql_fetch_assoc($query); 
$checkalbum = $Daten['name'];

if($checkalbum!=$album) {
//$album = utf8_decode($album);

mysql_query("INSERT INTO album (name, artist) VALUES ('$album', '$artistID')");	
mysql_query("UPDATE scanner_log SET album=album+1 WHERE id='0'");

echo mysql_error();
}

	
		$sql    = "SELECT id FROM album WHERE name  = '$album'";
		
		
		
$query = mysql_query($sql); 
$Daten = mysql_fetch_assoc($query); 
$albumID = $Daten['id'];
		
		$title = $ThisFileInfo['comments_html']['title'][0];
		$title = addslashes($title);
		$path = $ThisFileInfo['filenamepath'];
		$path = addslashes($path);
		$playtime = $ThisFileInfo['playtime_string'];
$sql    = "SELECT path FROM title WHERE path  = '$path'";
$query = mysql_query($sql); 
$Daten = mysql_fetch_assoc($query); 
$checkpath = $Daten['path'];

if($checkpath!=$path) {
mysql_query("INSERT INTO title (name, artist, path, album, duration) VALUES ('$title', '$artistID', '$path', '$albumID', '$playtime')");	
$titlecount++;
echo $titlecount." - ".$title."<br>";
mysql_query("UPDATE scanner_log SET title=title+1 WHERE id='0'");
echo mysql_error();
}









	$artworktmp = './tmp/front_'.$artist.'_'.$album.'.jpeg';
	
	file_put_contents($artworktmp, $getID3->info['id3v2']['APIC'][0]['data']);
	
	
    $info = getimagesize($artworktmp);
    $type = mime_content_type($artworktmp) . "\n";
	$type = "Content-Type: ".$type;
	

$size = getimagesize($artworktmp);

if ($size[0]>5 || $size[1]>5) {

$src_img = imagecreatefromjpeg($artworktmp);
$dst_img = imagecreatetruecolor(200,200);
imagecopyresampled($dst_img, $src_img, 0, 0, 0, 0, 200, 200, $size[0], $size[1]);
imagejpeg($dst_img, './tmp/front_'.$artist.'_'.$album.'.jpeg');
imagedestroy($src_img);
imagedestroy($dst_img);


$src_img = imagecreatefromjpeg($artworktmp);
$dst_img = imagecreatetruecolor(140,140);
imagecopyresampled($dst_img, $src_img, 0, 0, 0, 0, 140, 140, $size[0], $size[1]);
imagejpeg($dst_img, './tmp/front_'.$artist.'_'.$album.'_small.jpeg');
imagedestroy($src_img);
imagedestroy($dst_img);

}


	$hndFile = fopen('./tmp/front_'.$artist.'_'.$album.'.jpeg', "r");
$data = addslashes(fread($hndFile, filesize('./artwork/front_'.$artist.'_'.$album.'.jpeg')));
$hndFilesmal = fopen('./tmp/front_'.$artist.'_'.$album.'_small.jpeg', "r");
$data2 = addslashes(fread($hndFilesmal, filesize('./artwork/front_'.$artist.'_'.$album.'_small.jpeg')));

mysql_query("UPDATE album SET imgdata = '$data', imgtype = '$type' WHERE id='$albumID'");
mysql_query("UPDATE album SET imgdata_small = '$data2', imgtype = '$type' WHERE id='$albumID'");
unlink('./tmp/front_'.$artist.'_'.$album.'.jpeg');
unlink('./tmp/front_'.$artist.'_'.$album.'_small.jpeg');
		}

	}
}
$error = mysql_error();
mysql_query("UPDATE scanner_log SET error = '$error' WHERE id='0'");
echo mysql_error();
echo '<br>'. $titlecount.' neue Tracks gefunden.';










echo '</body></html>';
