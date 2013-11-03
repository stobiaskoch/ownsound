<?php
require_once('config.inc.php');
$db_link = mysqli_connect (DBHOST, DBUSER, DBPASS, DBDATABASE );
$user = $_COOKIE['loggedIn'];
//sonst gibts immer ne leere playlist in der datenbank
if ( ! isset ( $user ) )
{
  die();
}

$sql="CREATE TABLE IF NOT EXISTS `".$user."_playlist` (
  `artist` varchar(500) CHARACTER SET latin1 COLLATE latin1_german1_ci NOT NULL,
  `title` varchar(500) CHARACTER SET latin1 COLLATE latin1_german1_ci NOT NULL,
  `titleid` varchar(500) CHARACTER SET latin1 COLLATE latin1_german1_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;";

$db_erg = mysqli_query( $db_link, $sql );
if ( ! $db_erg )
{
  die('Ungültige Abfrage: ' . mysqli_error());
}





if($_REQUEST['order']=="addalbum") {

	$sql = "SELECT * FROM `title` WHERE album='".$_REQUEST['albumID']."' ORDER BY path";

	$db_erg = mysqli_query( $db_link, $sql );
	if ( ! $db_erg )
	{
		die('Ungültige Abfrage: ' . mysqli_error());
	}
	mysqli_query($db_link, "TRUNCATE ".$user."_playlist");
	while ($zeile = mysqli_fetch_array( $db_erg, MYSQL_ASSOC))
	{
		$title = str_replace("'", "\'", $zeile['name']);
		$title = utf8_encode($title);
		mysqli_query($db_link, "INSERT INTO ".$user."_playlist (artist, title, titleid) VALUES ('".$_REQUEST['artistID']."', '$title', '".$zeile['id']."')");
	}
	
}

if($_REQUEST['order']=="playtitle" or $_REQUEST['order']=="addtitle") {

	$sql = "SELECT * FROM `title` WHERE id='".$_REQUEST['albumID']."'";

	$db_erg = mysqli_query( $db_link, $sql );
	if ( ! $db_erg )
	{
		die('Ungültige Abfrage: ' . mysqli_error());
	}

	while ($zeile = mysqli_fetch_array( $db_erg, MYSQL_ASSOC))
	{
		$title = str_replace("'", "\'", $zeile['name']);
		$title = utf8_encode($title);
			if($_REQUEST['order']=="playtitle") {
				mysqli_query($db_link, "TRUNCATE ".$user."_playlist");
			}
		mysqli_query($db_link, "INSERT INTO ".$user."_playlist (artist, title, titleid) VALUES ('".$_REQUEST['artistID']."', '$title', '".$_REQUEST['albumID']."')");
	}

}


if($_REQUEST['order']=="random") {


mysql_connect(DBHOST, DBUSER,DBPASS);
mysql_select_db(DBDATABASE) or die ("Die Datenbank existiert nicht."); 

$titleresult = mysql_query("SELECT * FROM title"); 
$titlecount = mysql_num_rows($titleresult);



mysqli_query($db_link, "TRUNCATE ".$user."_playlist");
for ($i = 1; $i <= 8; $i++) {
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
$title = utf8_encode($title);

$artistID = $zeile['artist'];
$sql    = "SELECT name FROM artist WHERE id = '$artistID'";
$query = mysql_query($sql); 
$Daten = mysql_fetch_assoc($query); 
$artist = $Daten['name'];
				
	mysqli_query($db_link, "INSERT INTO ".$user."_playlist (artist, title, titleid) VALUES ('".$artist."', '$i - $title', '".$randid."')");
}

}
}

?>
