<?php
require_once('config.inc.php');
include('./js/functions.php');
mysql_connect(DBHOST, DBUSER,DBPASS);
mysql_select_db(DBDATABASE) or die ("Die Datenbank existiert nicht."); 
$title = $_REQUEST['title'];
$artist = $_REQUEST['artist'];
$artistID = getartistID($artist);
$size = $_REQUEST['size'];
$sql = "select * from title where name='$title' AND artist='$artistID'"; 
$query = mysql_query($sql); 
$Daten = mysql_fetch_assoc($query); 
$albumID = $Daten['album'];

$query = "select imgdata,imgtype,imgdata_small from album where id=$albumID"; 
$result = @MYSQL_QUERY($query); 


$data = @MYSQL_RESULT($result,0,"imgdata"); 



$type = @MYSQL_RESULT($result,0,"imgtype"); 

Header( "Content-type: $type"); 


if($data!="") {echo $data;}
else 
{

echo readfile('./img/no_cover.jpg');

}




?>