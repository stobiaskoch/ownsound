<?php

// img_up.php: Ein Bild hochladen
require_once('config.inc.php');
include('./js/functions.php');
mysql_connect(DBHOST, DBUSER,DBPASS);
mysql_select_db(DBDATABASE) or die ("Die Datenbank existiert nicht.");
$albumID = $_REQUEST['albumID'];

//if($albumID=="") {die('Keine ID');}

if (array_key_exists('img',$_FILES)) {

$tmpname = $_FILES['img']['tmp_name'];


coverinmysql($tmpname, $albumID);

}

?>
