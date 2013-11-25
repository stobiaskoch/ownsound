<?php
require_once('./../ownsound.config.php');
mysql_connect(DBHOST, DBUSER,DBPASS);
mysql_select_db(DBDATABASE) or die ("Die Datenbank existiert nicht."); 
mysql_query("SET NAMES 'utf8'");

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

function getgenrefromalbumID ($id) {

				$sql    = "SELECT genre FROM album WHERE id = '$id'";
				$query = mysql_query($sql); 
				$Daten = mysql_fetch_assoc($query); 
				
				return $Daten['genre'];

}

function coverinmysql ($file, $albumID) {

		require_once './js/thumb/ThumbLib.inc.php';
				if(mime_content_type($file)=="image/jpeg") {  
				$options = array('resizeUp' => true, 'jpegQuality' => 60);
				$optionsbig = array('resizeUp' => true, 'jpegQuality' => 90);
				
				copy($file, "./tmp/".$albumID."_copy1.jpg");

				$thumb = PhpThumbFactory::create($file, $optionsbig);
				$thumb->resize(140, 140)->save('./tmp/'.$albumID.'_grossesbild.jpg', 'jpg');

				$thumb = PhpThumbFactory::create($file, $options);
				$thumb->resize(70, 70)->save('./tmp/'.$albumID.'_kleinesbild.jpg', 'jpg');

				$thumb = PhpThumbFactory::create("./tmp/".$albumID."_copy1.jpg", $optionsbig);
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
				mysql_query("UPDATE album SET cover='yes' WHERE id = '$albumID'");
				mysql_query("UPDATE album SET coverbig='yes' WHERE id = '$albumID'");
				
				unlink($file);
				unlink('./tmp/'.$albumID.'_grossesbild.jpg');
				unlink('./tmp/'.$albumID.'_kleinesbild.jpg');
				unlink('./tmp/'.$albumID.'_reflection.jpg');
				unlink('./tmp/'.$albumID.'_copy1.jpg');
				}
					else
				{
					mysql_query("UPDATE album SET cover='no' WHERE id = '$albumID'");
					mysql_query("UPDATE album SET coverbig='no' WHERE id = '$albumID'");
				}

}
				
function thumbnail ($file, $albumID) {

		require_once './js/thumb/ThumbLib.inc.php';

				if(mime_content_type($file)=="image/jpeg") {  
				$options = array('resizeUp' => true, 'jpegQuality' => 60);
				$optionsbig = array('resizeUp' => true, 'jpegQuality' => 90);
				
				$thumb = PhpThumbFactory::create($file, $optionsbig);
				$thumb->resize(140, 140)->save('./tmp/'.$albumID.'_grossesbild.jpg', 'jpg');

				$thumb = PhpThumbFactory::create($file, $options);
				$thumb->resize(70, 70)->save('./tmp/'.$albumID.'_kleinesbild.jpg', 'jpg');

				$hndFile = fopen('./tmp/'.$albumID.'_grossesbild.jpg', "r");
				$data = addslashes(fread($hndFile, filesize('./tmp/'.$albumID.'_grossesbild.jpg')));

				$hndFilesmall = fopen('./tmp/'.$albumID.'_kleinesbild.jpg', "r");
				$datasmall = addslashes(fread($hndFilesmall, filesize('./tmp/'.$albumID.'_kleinesbild.jpg')));

				$type = mime_content_type('./tmp/'.$albumID.'_kleinesbild.jpg');

				mysql_query("UPDATE album SET imgdata = '$data', imgtype = '$type' WHERE id='$albumID'");
				mysql_query("UPDATE album SET imgdata_small = '$datasmall', imgtype = '$type' WHERE id='$albumID'");
				mysql_query("UPDATE album SET cover='yes' WHERE id = '$albumID'");
				
				unlink($file);
				unlink('./tmp/'.$albumID.'_grossesbild.jpg');
				unlink('./tmp/'.$albumID.'_kleinesbild.jpg');

				}
					else
				{
					mysql_query("UPDATE album SET cover='no' WHERE id = '$albumID'");
				}

}
				
				
function thumbreflection ($albumID) {

		require_once './js/thumb/ThumbLib.inc.php';
		
				  
				
					$options = array('resizeUp' => true, 'jpegQuality' => 60);
					$optionsbig = array('resizeUp' => true, 'jpegQuality' => 90);
					
					$query = "select imgdata,imgtype from album where id=$albumID";
					$result = @MYSQL_QUERY($query); 
					$data = @MYSQL_RESULT($result,0,"imgdata"); 
					$file = './tmp/folder.jpeg';
					$handle = fopen ($file, 'w+');
					fwrite($handle, $data);
					fclose($handle);
					
					if(mime_content_type($file)=="image/jpeg") {
					
					$thumb = PhpThumbFactory::create($file, $optionsbig);
					$thumb->createReflection(10, 40, 90, true, '#a4a4a4')->resize(140, 196);
					$thumb->save('./tmp/'.$albumID.'_reflection.jpg', 'jpg');

					$hndFilebig = fopen('./tmp/'.$albumID.'_reflection.jpg', "r");
					$databig = addslashes(fread($hndFilebig, filesize('./tmp/'.$albumID.'_reflection.jpg')));

					$type = mime_content_type('./tmp/'.$albumID.'_reflection.jpg');

					mysql_query("UPDATE album SET imgdata_big = '$databig', imgtype = '$type' WHERE id='$albumID'");
					mysql_query("UPDATE album SET coverbig='yes' WHERE id = '$albumID'");
					
					unlink($file);
					unlink('./tmp/'.$albumID.'_reflection.jpg');

					}
						else
					{
						mysql_query("UPDATE album SET coverbig='no' WHERE id = '$albumID'");
					}

}
				
function map_dirs($path,$level) {
        if(is_dir($path)) {
                if($contents = opendir($path)) {
                        while(($node = readdir($contents)) !== false) {
                                if($node!="." && $node!="..") {
										if(substr($node, -3)=="mp3" or substr($node, -3)=="MP3") {
										$path3 = addslashes($path."/".$node);
										mysql_query("INSERT INTO scanner (path) VALUES ('$path3')");
                                        }
										map_dirs("$path/$node",$level+1);
                                }
                        }
                }
        }

}
function logincheck() {
	if(!$_COOKIE['loggedIn']) {
		echo "<meta http-equiv='refresh' content='0; URL=index.php'>";
		die();
	}
	$checkuser = $_COOKIE['loggedIn'];
	$db_checkuser = mysqli_connect (DBHOST, DBUSER, DBPASS, DBDATABASE );
	$sql_checkuser = "SELECT name FROM user WHERE name = '$checkuser'";
	$db_erg_checkuser = mysqli_query( $db_checkuser, $sql_checkuser );
	$zeile_checkuser = mysqli_fetch_array( $db_erg_checkuser, MYSQL_ASSOC);
	mysqli_close($db_checkuser);
	if ( ! $zeile_checkuser['name'] )
				{
					die('Ungültiger User');
				}
}

function trackcount($artistID) {
	$tracksql = mysql_query("SELECT * FROM album WHERE artist='$artistID'"); 
	$check = mysql_num_rows($tracksql);
	return $check;

}

?>
