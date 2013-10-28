<?php
$db_link = mysqli_connect ("localhost", "root", "strese84", "musikdatenbank" );


if($_REQUEST['order']=="addalbum") {

$artistname = $_REQUEST['artistname'];

echo $_REQUEST['artistname'];

$sql = "SELECT * FROM `title` WHERE album='".$_REQUEST['albumID']."' ORDER BY path";

$db_erg = mysqli_query( $db_link, $sql );
if ( ! $db_erg )
{
  die('Ungültige Abfrage: ' . mysqli_error());
}
unlink('playlist.php');
$datei_handle=fopen("playlist.php",a);
fwrite($datei_handle,"<?php\n");
fclose($datei_handle);
while ($zeile = mysqli_fetch_array( $db_erg, MYSQL_ASSOC))
{
$title = str_replace("'", "\'", $zeile['name']);
$path = str_replace("'", "\'", $zeile['path']);
	$information = "\$playlist[]=array('artist'=>'".$_REQUEST['artistID']."','title'=>'". $title . "','mp3'=>'mp3.php?id=".$path."');\n";
	$datei_handle=fopen("playlist.php",a);
	fwrite($datei_handle,$information);
	fclose($datei_handle);

}

$information = "\$playlist=json_encode(\$playlist);\nprint_r(\$playlist);\n?>\n";

$datei_handle=fopen("playlist.php",a);
fwrite($datei_handle,$information);
fclose($datei_handle);

}

if($_REQUEST['order']=="playtitle") {

$sql = "SELECT * FROM `title` WHERE id='".$_REQUEST['albumID']."'";

$db_erg = mysqli_query( $db_link, $sql );
if ( ! $db_erg )
{
  die('Ungültige Abfrage: ' . mysqli_error());
}
unlink('playlist.php');
$datei_handle=fopen("playlist.php",a);
fwrite($datei_handle,"<?php\n");
fclose($datei_handle);
while ($zeile = mysqli_fetch_array( $db_erg, MYSQL_ASSOC))
{
$title = str_replace("'", "\'", $zeile['name']);
$path = str_replace("'", "\'", $zeile['path']);

	$information = "\$playlist[]=array('artist'=>'".$_REQUEST['artistID']."','title'=>'". $title . "','mp3'=>'mp3.php?id=".$path."');\n";
	$datei_handle=fopen("playlist.php",a);
	fwrite($datei_handle,$information);
	fclose($datei_handle);

}

$information = "\$playlist=json_encode(\$playlist);\nprint_r(\$playlist);\n?>\n";

$datei_handle=fopen("playlist.php",a);
fwrite($datei_handle,$information);
fclose($datei_handle);

}

?>