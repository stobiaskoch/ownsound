<?php
require_once('config.inc.php');
include('./js/functions.php');
$db_link = mysqli_connect (DBHOST, DBUSER, DBPASS, DBDATABASE );
mysqli_query("SET NAMES 'utf8'");
$user = $_COOKIE['loggedIn'];
//sonst gibts immer ne leere playlist in der datenbank
if($user=="" or $user==" ") { die(); }
if ( ! isset ( $user ) )
{
  die();
}

if ( ! isset ( $_REQUEST['order'] ) )
{
  die();
}
$sql="CREATE TABLE IF NOT EXISTS `".$user."_playlist` (
  `artist` varchar(500) CHARACTER SET latin1 COLLATE latin1_german1_ci NOT NULL,
  `title` varchar(500) CHARACTER SET latin1 COLLATE latin1_german1_ci NOT NULL,
  `titleid` varchar(500) CHARACTER SET latin1 COLLATE latin1_german1_ci NOT NULL,
  `artistID` int(11) NOT NULL,
  `albumID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;";

$db_erg = mysqli_query( $db_link, $sql );
if ( ! $db_erg )
{
  die('Ungültige Abfrage: ' . mysqli_error());
}





if($_REQUEST['order']=="playalbum" or $_REQUEST['order']=="addalbum") {
$i = 1;

	$sql = "SELECT * FROM `title` WHERE album='".$_REQUEST['albumID']."' ORDER BY ABS(track)";

				if($_REQUEST['order']=="playalbum") {
				mysqli_query($db_link, "TRUNCATE ".$user."_playlist");
			}
	$db_erg = mysqli_query( $db_link, $sql );
	if ( ! $db_erg )
	{
		die('Ungültige Abfrage: ' . mysqli_error());
	}

	while ($zeile = mysqli_fetch_array( $db_erg, MYSQL_ASSOC))
	{
		
		$title = str_replace("'", "\'", $zeile['name']);
	//	$title = utf8_encode($title);
		$artist = addslashes(getartist($_REQUEST['artistID']));
		$artist = utf8_decode($artist);
		mysqli_query($db_link, "INSERT INTO ".$user."_playlist (artist, title, titleid, albumID) VALUES ('".$artist."', '$title', '".$zeile['id']."', '".$_REQUEST['albumID']."')");
		$i++;
	}
	
}





if($_REQUEST['order']=="playtitle" or $_REQUEST['order']=="addtitle") {
$i = 1;
	$sql = "SELECT * FROM `title` WHERE id='".$_REQUEST['albumID']."'";

	$db_erg = mysqli_query( $db_link, $sql );
	if ( ! $db_erg )
	{
		die('Ungültige Abfrage: ' . mysqli_error());
	}

	while ($zeile = mysqli_fetch_array( $db_erg, MYSQL_ASSOC))
	{
		
		$title = str_replace("'", "\'", $zeile['name']);
	//	$title = utf8_encode($title);
		$artist = getartist($_REQUEST['artistID']);
	//	$artist = addslashes($artist);
		$artist = utf8_decode($artist);
		$albumID = $zeile['album'];
			if($_REQUEST['order']=="playtitle") {
				mysqli_query($db_link, "TRUNCATE ".$user."_playlist");
			}
		mysqli_query($db_link, "INSERT INTO ".$user."_playlist (artist, title, titleid, albumID) VALUES ('".$artist."', '$title', '".$_REQUEST['albumID']."', '$albumID')");
		$i++;
	}

}



if($_REQUEST['order']=="truncate") {

	$sql = "SELECT * FROM `title` WHERE id='".$_REQUEST['albumID']."'";

	$db_erg = mysqli_query( $db_link, $sql );
	if ( ! $db_erg )
	{
		die('Ungültige Abfrage: ' . mysqli_error());
	}

		mysqli_query($db_link, "TRUNCATE ".$user."_playlist");


}



if($_REQUEST['order']=="random") {


mysql_connect(DBHOST, DBUSER,DBPASS);
mysql_select_db(DBDATABASE) or die ("Die Datenbank existiert nicht."); 

$titleresult = mysql_query("SELECT * FROM title"); 
$titlecount = mysql_num_rows($titleresult);



mysqli_query($db_link, "TRUNCATE ".$user."_playlist");
for ($i = 1; $i <= 13; $i++) {
$count = floatval($titlecount);
$randid = rand(0, $count);
$randid = round($randid);
$sql = "SELECT * FROM `title` WHERE id='".$randid."'";

$db_erg = mysqli_query( $db_link, $sql );
if ( ! $db_erg )
{
  die('Ungültige Abfrage: ' . mysqli_error());
}

while ($zeile = mysqli_fetch_array( $db_erg, MYSQL_ASSOC))
{
$title = str_replace("'", "\'", $zeile['name']);
//$title = utf8_encode($title);
$albumID = $zeile['album'];

$artistID = $zeile['artist'];
$sql    = "SELECT name FROM artist WHERE id = '$artistID'";
$query = mysql_query($sql); 
$Daten = mysql_fetch_assoc($query); 
$artist = $Daten['name'];
$artist = utf8_decode($artist);

				
	mysqli_query($db_link, "INSERT INTO ".$user."_playlist (artist, title, titleid, albumID) VALUES ('".$artist."', '$title', '".$randid."', '$albumID')");
}

}
}

?>
