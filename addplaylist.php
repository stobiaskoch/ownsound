<?php
require_once('config.inc.php');
$db_link = mysqli_connect (DBHOST, DBUSER, DBPASS, DBDATABASE );
$user = $_COOKIE['loggedIn'];

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

$artistname = $_REQUEST['artistname'];

echo $_REQUEST['artistname'];

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
$path = str_replace("'", "\'", $zeile['path']);

mysqli_query($db_link, "INSERT INTO ".$user."_playlist (artist, title, titleid) VALUES ('".urlencode($_REQUEST['artistID'])."', '$title', '".$zeile['id']."')");
}



}

if($_REQUEST['order']=="playtitle") {

$sql = "SELECT * FROM `title` WHERE id='".$_REQUEST['albumID']."'";

$db_erg = mysqli_query( $db_link, $sql );
if ( ! $db_erg )
{
  die('Ungültige Abfrage: ' . mysqli_error());
}

while ($zeile = mysqli_fetch_array( $db_erg, MYSQL_ASSOC))
{
$title = str_replace("'", "\'", $zeile['name']);
$path = str_replace("'", "\'", $zeile['path']);
	mysqli_query($db_link, "TRUNCATE ".$user."_playlist");
	mysqli_query($db_link, "INSERT INTO ".$user."_playlist (artist, title, titleid) VALUES ('".urlencode($_REQUEST['artistID'])."', '$title', '".$_REQUEST['albumID']."')");
}


}

?>
