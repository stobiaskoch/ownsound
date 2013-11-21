<?php
require_once('config.inc.php');
include('./js/functions.php');
$artistID = $_REQUEST['artistID'];
$albumID = $_REQUEST['albumID'];
$titleID = $_REQUEST['titleID'];
$db_link = mysqli_connect (DBHOST, DBUSER, DBPASS, DBDATABASE );


if($_REQUEST['order']=="deletealbum") {

	$album = getalbum($albumID);
	mysqli_query($db_link,"DELETE FROM title WHERE album='$albumID'");
	mysqli_query($db_link,"DELETE FROM album WHERE id='$albumID'");
	mysqli_close($db_link);
	echo "$album wurde gelöscht";
}

if($_REQUEST['order']=="deletartist") {

	mysqli_query($db_link,"DELETE FROM title WHERE artist='$artistID'");
	mysqli_query($db_link,"DELETE FROM album WHERE artist='$artistID'");
	mysqli_query($db_link,"DELETE FROM artist WHERE artist='$artistID'");
	mysqli_close($db_link);
	echo getartist($getartistID) . " wurde gelöscht";
}

if($_REQUEST['order']=="deletetitle") {

	$title = gettitle($titleID);
	mysqli_query($db_link,"DELETE FROM title WHERE id='$titleID'");
	mysqli_close($db_link);
	echo "$title wurde gelöscht";
}

?>