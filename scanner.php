<?php
/**
    EventSource is documented at 
 
http://dev.w3.org/html5/eventsource/
 
*/
 
//a new content type. make sure apache does not gzip this type, else it would get buffered
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache'); // recommended to prevent caching of event data.
 
/**
    Constructs the SSE data format and flushes that data to the client.
*/
function send_message($id, $message, $progress) 
{
    $d = array('message' => $message , 'progress' => $progress);
     
    echo "id: $id" . PHP_EOL;
    echo "data: " . json_encode($d) . PHP_EOL;
    echo PHP_EOL;
     
    //PUSH THE data out by all FORCE POSSIBLE
    ob_flush();
    flush();
}
 
$serverTime = time();
 
//LONG RUNNING TASK

require_once('./getid3/getid3.php');
require_once('./ownsound.config.php');
$getID3 = new getID3;
$i=1;
//starten



mysql_connect(DBHOST, DBUSER,DBPASS) OR DIE ("NICHT Erlaubt");
mysql_select_db(DBDATABASE) or die ("Die Datenbank existiert nicht.");
mysql_query("SET NAMES 'utf8'");



$result = mysql_query("SELECT * FROM scanner"); 
$checkscan = mysql_num_rows($result);


//statistik
mysql_query("UPDATE scanner_log SET folderscanned=folderscanned+1 WHERE id='0'");
$sql    = "SELECT * FROM scanner_log WHERE id = '0'";
$query = mysql_query($sql); 
$Daten = mysql_fetch_assoc($query); 
$foldertoscan = $Daten['foldertoscan'];
$foldertoscan = $foldertoscan - 1;
$folderscanned = $Daten['folderscanned'];





$sql = "SELECT path FROM scanner ORDER BY `ID`";
 
$db_erg = mysql_query( $sql );
if ( ! $db_erg )
{
	die('Ungültige Abfrage: ' . mysql_error());
}

				$result = mysql_query("SELECT * FROM scanner"); 
				$checkscan = mysql_num_rows($result);
				$progress = 100 / $checkscan;
$progress2 = $progress2 + $progress;			
while ($zeile = mysql_fetch_array( $db_erg, MYSQL_ASSOC)) {
$progress2 = $progress2 + $progress;


		$scannerid = $zeile['id'];
		mysql_query("DELETE FROM scanner WHERE path = '$path'");		

		$FullFileName = utf8_decode($zeile['path']);
		set_time_limit(180);

		$ThisFileInfo = $getID3->analyze($FullFileName);
		getid3_lib::CopyTagsToComments($ThisFileInfo);
		
//überspringe datei, wenn keine mp3 (hey, that rhymes...)


		
//variablen ermitteln

		$artist = $ThisFileInfo['comments_html']['artist'][0];
		$artist = addslashes($artist);
		$artist = html_entity_decode($artist, ENT_QUOTES, 'UTF-8');

		$album = $ThisFileInfo['comments_html']['album'][0];
		$album = addslashes($album);
		
		$title = $ThisFileInfo['comments_html']['title'][0];
		$title = addslashes($title);
		$title = html_entity_decode($title, ENT_QUOTES, 'UTF-8');
		
		$track = $ThisFileInfo['comments_html']['track'][0];
				
		$path = $ThisFileInfo['filenamepath'];
		$path = addslashes($path);
		$path = utf8_encode($path);
		
		$playtime = $ThisFileInfo['playtime_string'];
		$genre = $ThisFileInfo['comments_html']['genre'][0];
		
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
			
				mysql_query("INSERT INTO album (name, artist, genre) VALUES ('$album', '$artistID', '$genre')");
				mysql_query("UPDATE scanner_log SET album=album+1 WHERE id='0'");



				send_message($serverTime, 'album: ' . $album , $progress2 + 1); 
				
			//albumID ermitteln

			}
		//}
		$sql    = "SELECT id FROM album WHERE name = '$album'";
		$query = mysql_query($sql) OR DIE("Konnte Album ID nicht auslesen:<br/>".$sql); 
		$Daten = mysql_fetch_assoc($query); 
		$albumID = $Daten['id'];
		//cover vorhanden? schreiben
		

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
			
			mysql_query("UPDATE scanner_log SET title=title+1 WHERE id='0'");
			
		}







}






    
     


 
send_message($serverTime, 'TERMINATE'); 
?>
