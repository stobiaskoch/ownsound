<?php
require_once('./../ownsound.config.php');
mysql_connect(DBHOST, DBUSER,DBPASS);
mysql_select_db(DBDATABASE) or die ("Die Datenbank existiert nicht."); 

function getartist ($id) {

				$sql    = "SELECT name FROM artist WHERE id = '$id'";
				$query = mysql_query($sql); 
				$Daten = mysql_fetch_assoc($query); 
				
				return $Daten['name'];

}

function getalbum ($id) {

				$sql    = "SELECT name FROM album WHERE id = '$id'";
				$query = mysql_query($sql); 
				$Daten = mysql_fetch_assoc($query); 
				
				return $Daten['name'];

}

function gettitle ($id) {

				$sql    = "SELECT name FROM title WHERE id = '$id'";
				$query = mysql_query($sql); 
				$Daten = mysql_fetch_assoc($query); 
				
				return $Daten['name'];

}

function getartistID ($id) {

				$sql    = "SELECT id FROM artist WHERE name = '$id'";
				$query = mysql_query($sql); 
				$Daten = mysql_fetch_assoc($query); 
				
				return $Daten['id'];

}

function getartistIDfromalbumID ($id) {

				$sql    = "SELECT artist FROM album WHERE id = '$id'";
				$query = mysql_query($sql); 
				$Daten = mysql_fetch_assoc($query); 
				
				return $Daten['artist'];

}

function coverinmysql ($file, $albumID) {

		require_once './js/thumb/ThumbLib.inc.php';

				copy($file, "./tmp/".$albumID."_copy1.jpg");
			//	copy($file, "./tmp/".$albumID."_copy2.jpg");
			//	copy($file, "./tmp/".$albumID."_copy3.jpg");

				$thumb = PhpThumbFactory::create('./tmp/'.$albumID.'_copy1.jpg');
				$thumb->resize(140, 140)->save('./tmp/'.$albumID.'_grossesbild.jpg', 'jpg');

				$thumb = PhpThumbFactory::create('./tmp/'.$albumID.'_copy1.jpg');
				$thumb->resize(70, 70)->save('./tmp/'.$albumID.'_kleinesbild.jpg', 'jpg');

				$thumb = PhpThumbFactory::create('./tmp/'.$albumID.'_copy1.jpg');
				$thumb->createReflection(10, 40, 90, true, '#a4a4a4')->resize(140, 196)->save('./tmp/'.$albumID.'_reflection.jpg', 'jpg');

				$hndFile = fopen('./tmp/'.$albumID.'_grossesbild.jpg', "r");
				$data = addslashes(fread($hndFile, filesize('./tmp/'.$albumID.'_grossesbild.jpg')));

				$hndFilesmall = fopen('./tmp/'.$albumID.'_kleinesbild.jpg', "r");
				$datasmall = addslashes(fread($hndFilesmall, filesize('./tmp/'.$albumID.'_kleinesbild.jpg')));

				$hndFilebig = fopen('./tmp/'.$albumID.'_reflection.jpg', "r");
				$databig = addslashes(fread($hndFilebig, filesize('./tmp/'.$albumID.'_reflection.jpg')));

				$type = mime_content_type('./tmp/'.$albumID.'_reflection.jpg');

				mysql_query("UPDATE album SET imgdata = '$data', imgtype = '$type' WHERE id='$albumID'");
				mysql_query("UPDATE album SET imgdata_small = '$datasmall', imgtype = '$type' WHERE id='$albumID'");
				mysql_query("UPDATE album SET imgdata_big = '$databig', imgtype = '$type' WHERE id='$albumID'");

				unlink($file);
				unlink('./tmp/'.$albumID.'_grossesbild.jpg');
				unlink('./tmp/'.$albumID.'_kleinesbild.jpg');
				unlink('./tmp/'.$albumID.'_reflection.jpg');
				unlink('./tmp/'.$albumID.'_copy1.jpg');

				}
?>