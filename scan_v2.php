<?php
echo '<html><head>';
echo '<title>OwnSound-Scanner V2</title>';
echo '<style type="text/css">BODY,TD,TH { font-family: sans-serif; font-size: 9pt; }</style>';
echo '</head><body>';
// requests
	$titlecount = "0";
	$DirectoryToScan = $_REQUEST['dirtoscan'];
	
require_once('./getid3/getid3.php');
require_once('config.inc.php');
$getID3 = new getID3;

//starten

$dir = opendir($DirectoryToScan);
mysql_connect(DBHOST, DBUSER,DBPASS) OR DIE ("NICHT Erlaubt");
mysql_select_db(DBDATABASE) or die ("Die Datenbank existiert nicht.");

//statistik
mysql_query("UPDATE scanner_log SET folderscanned=folderscanned+1 WHERE id='0'");
$sql    = "SELECT * FROM scanner_log WHERE id = '0'";
$query = mysql_query($sql); 
$Daten = mysql_fetch_assoc($query); 
$foldertoscan = $Daten['foldertoscan'];
$foldertoscan = $foldertoscan - 2;
$folderscanned = $Daten['folderscanned'];

echo "Durchsuche Verzeichniss $folderscanned von $foldertoscan : $DirectoryToScan<br>";

if($DirectoryToScan=="") { exit; } 

if($dir!=FALSE) {

	while (false !== ($file = readdir($dir)) ) {
	$FullFileName = realpath($DirectoryToScan.'/'.$file);
	if ((substr($FullFileName, 0, 1) != '.') && is_file($FullFileName)) {
	
		set_time_limit(180);

		$ThisFileInfo = $getID3->analyze($FullFileName);
		getid3_lib::CopyTagsToComments($ThisFileInfo);
		
//überspringe datei, wenn keine mp3 (hey, that rhymes...)

		if($ThisFileInfo['fileformat']=="mp3") {  
		
//variablen ermitteln

		$artist = $ThisFileInfo['comments_html']['artist'][0];
		$artist = addslashes($artist);

		$album = $ThisFileInfo['comments_html']['album'][0];
		$album = addslashes($album);
		
		$title = $ThisFileInfo['comments_html']['title'][0];
		$title = addslashes($title);
		
		$track = $ThisFileInfo['comments_html']['track'][0];
				
		$path = $ThisFileInfo['filenamepath'];
		$path = addslashes($path);
		
		$playtime = $ThisFileInfo['playtime_string'];
		if(COVERSEARCH!=FALSE) {
			if($getID3->info['id3v2']['APIC'][0]['data']!="") {
				$artworktmp = './tmp/front_'.$artist.'_'.$album.'.jpeg';
				file_put_contents($artworktmp, $getID3->info['id3v2']['APIC'][0]['data']);
				$coverthere = "yes";
			}
		}
		
//checke, ob artist vorhanden

		$sql    = "SELECT * FROM artist WHERE name = '$artist'";
		$query = mysql_query($sql); 
		$Daten = mysql_fetch_assoc($query); 
		$checkartist = $Daten['name'];
		$checkartist = addslashes($checkartist);

	//artistID ermitteln
	
		
		
		//wenn nicht, schreiben

			if($checkartist!=$artist) {
				mysql_query("INSERT INTO artist (name) VALUES ('$artist')");
				mysql_query("UPDATE scanner_log SET artist=artist+1 WHERE id='0'");
			}
			//artistID ermitteln
				$sql    = "SELECT id FROM artist WHERE name = '$artist'";
				$query = mysql_query($sql); 
				$Daten = mysql_fetch_assoc($query); 
				$artistID = $Daten['id'];

//checke, ob album  von diesem artist vorhanden

		$sql    = "SELECT * FROM album WHERE name = '$album'";
		$query = mysql_query($sql); 
		$Daten = mysql_fetch_assoc($query); 
		$checkalbum = $Daten['name'];
		$checkalbum = addslashes($checkalbum);
		
	//wenn nicht, schreiben
		
		//if($Daten['artist']!=$artistID) {
		
			if($checkalbum!=$album) {
			
				mysql_query("INSERT INTO album (name, artist) VALUES ('$album', '$artistID')");	
				mysql_query("UPDATE scanner_log SET album=album+1 WHERE id='0'");
				
			//albumID ermitteln

			}
		//}
		$sql    = "SELECT id FROM album WHERE name = '$album'";
		$query = mysql_query($sql) OR DIE("Konnte Album ID nicht auslesen:<br/>".$sql); 
		$Daten = mysql_fetch_assoc($query); 
		$albumID = $Daten['id'];
		//cover vorhanden? schreiben
		if(COVERSEARCH!=FALSE) {
			if($coverthere=="yes") {
				$type = mime_content_type($artworktmp) . "\n";
				$type = "Content-Type: ".$type;
				$size = getimagesize($artworktmp);
				if ($size[0]>5 || $size[1]>5) {
				
					$src_img = imagecreatefromjpeg($artworktmp);
					$dst_img = imagecreatetruecolor(70,70);
					imagecopyresampled($dst_img, $src_img, 0, 0, 0, 0, 70, 70, $size[0], $size[1]);
					imagejpeg($dst_img, './tmp/front_'.$artist.'_'.$album.'_small.jpeg');
					imagedestroy($src_img);
					imagedestroy($dst_img);
					
					$src_img = imagecreatefromjpeg($artworktmp);
					$dst_img = imagecreatetruecolor(140,140);
					imagecopyresampled($dst_img, $src_img, 0, 0, 0, 0, 140, 140, $size[0], $size[1]);
					imagejpeg($dst_img, './tmp/front_'.$artist.'_'.$album.'.jpeg');
					imagedestroy($src_img);
					imagedestroy($dst_img);

					$hndFile = fopen('./tmp/front_'.$artist.'_'.$album.'.jpeg', "r");
					$data = addslashes(fread($hndFile, filesize('./tmp/front_'.$artist.'_'.$album.'.jpeg')));
					$hndFilesmal = fopen('./tmp/front_'.$artist.'_'.$album.'_small.jpeg', "r");
					$data2 = addslashes(fread($hndFilesmal, filesize('./tmp/front_'.$artist.'_'.$album.'_small.jpeg')));

					mysql_query("UPDATE album SET imgdata = '$data', imgtype = '$type' WHERE id='$albumID'");
					mysql_query("UPDATE album SET imgdata_small = '$data2', imgtype = '$type' WHERE id='$albumID'");
					unlink('./tmp/front_'.$artist.'_'.$album.'.jpeg');
					unlink('./tmp/front_'.$artist.'_'.$album.'_small.jpeg');
				}
			}
		}
//checke, ob titel von diesem artist vorhanden

		$sql    = "SELECT path FROM title WHERE path = '$path' AND artist='$artistID'";
		$query = mysql_query($sql); 
		$Daten = mysql_fetch_assoc($query); 
		$checkpath = $Daten['path'];
		$checkpath = addslashes($checkpath);
		
	//wenn nicht, schreiben
		
		if($checkpath!=$path) {
			$sql="INSERT INTO title (name, artist, path, album, duration, track) VALUES ('$title', '$artistID', '$path', '$albumID', '$playtime', '$track') ON DUPLICATE KEY UPDATE name='$title', artist='$artistID', path='$path', album='$albumID', duration='$playtime'";
			mysql_query($sql) OR DIE (mysql_error()."Title konnte nicht eingetragen werden.<br/>".$sql);	
			$titlecount++;
			echo $titlecount." - ".$title."<br>";
			mysql_query("UPDATE scanner_log SET title=title+1 WHERE id='0'");
			
		}
	}	
}
}
echo '<br>'. $titlecount.' neue Tracks gefunden.';
echo '</body></html>';	 	 
	}	
	if($folderscanned==$foldertoscan) {
		echo "yeah!";
		mysql_query("UPDATE scanner_log SET endtime=(NOW()) WHERE id='0'");
	}
?>		
