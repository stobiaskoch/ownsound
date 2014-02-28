<?php
require_once('config.inc.php');
$artistID = "1";

mysql_connect(DBHOST, DBUSER,DBPASS);
mysql_select_db(DBDATABASE) or die ("Die Datenbank existiert nicht.");

$albumcountsql = mysql_query("SELECT * FROM album WHERE artist='$artistID'"); 

$albumcount = mysql_num_rows($albumcountsql);
if($albumcount<=1) {$albumcount = "$albumcount Album"; } else {$albumcount = "$albumcount Alben"; }
	if($albumcount==0) {
		$albumcount = "Keine Alben gefunden";
		$sql = "SELECT * FROM title WHERE artist='$artistID' ORDER BY path";
	}
	else
	{
		$sql = "SELECT * FROM album WHERE artist='$artistID' ORDER BY name";
	}
	if($artistID=="lastten") {
		$albumcount = "Zuletzt hinzugefügt:";
		$sql = "SELECT * FROM album ORDER BY id DESC LIMIT 20";
	}


$db_link = mysqli_connect (DBHOST, DBUSER, DBPASS, DBDATABASE );



$db_erg = mysqli_query( $db_link, $sql );
if ( ! $db_erg )
{
  die('Ungültige Abfrage: ' . mysqli_error());
}

while ($zeile = mysqli_fetch_array( $db_erg, MYSQL_ASSOC))
{

	$artist=$zeile['artist'];
	$title=$zeile['title'];
	$title=utf8_encode($title);
	$titleid=$zeile['titleid'];
	$albumID=$zeile['id'];
	$title=$zeile['name'];
	$artist=utf8_encode($artist);
	
 $playlist[]=array('title'=>$title, 'description'=>'', 'image'=>'get.php?picid='.$albumID,'link'=>'', 'duration'=>'');

}



//$playlist[]=array('artist'=>'Alice In Chains', 'artist'=>'Alice In Chains','title'=>'God Smack','mp3'=>'mp3.php?id=/mnt/musik/Alice in Chains - Dirt (1992)/Alice In Chains - Dirt/08. Alice In Chains - God Smack.mp3');
$playlist=json_encode($playlist);
print_r($playlist);
?> 