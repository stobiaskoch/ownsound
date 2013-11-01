<?php
require_once('config.inc.php');
$dblink = $_COOKIE['loggedIn'];
//$playlist = array();
$db_link = mysqli_connect (DBHOST, DBUSER, DBPASS, DBDATABASE );

$sql = "SELECT * FROM ".$dblink."_playlist";

$db_erg = mysqli_query( $db_link, $sql );
if ( ! $db_erg )
{
  die('Ungültige Abfrage: ' . mysqli_error());
}

while ($zeile = mysqli_fetch_array( $db_erg, MYSQL_ASSOC))
{

	$artist=$zeile['artist'];
	$title=$zeile['title'];
	$titleid=$zeile['titleid'];

 $playlist[]=array('artist'=>$artist,'title'=>$title,'mp3'=>'mp3.php?id='.$titleid);

}



//$playlist[]=array('artist'=>'Alice In Chains','title'=>'God Smack','mp3'=>'mp3.php?id=/mnt/musik/Alice in Chains - Dirt (1992)/Alice In Chains - Dirt/08. Alice In Chains - God Smack.mp3');
$playlist=json_encode($playlist);
print_r($playlist);
?> 
