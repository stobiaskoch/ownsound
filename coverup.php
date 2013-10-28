<?php

// img_up.php: Ein Bild hochladen

mysql_connect("localhost", "root","strese84");
mysql_select_db("musikdatenbank") or die ("Die Datenbank existiert nicht.");
$albumID = $_REQUEST['albumID'];

//if($albumID=="") {die('Keine ID');}

if (array_key_exists('img',$_FILES)) {

$tmpname = $_FILES['img']['tmp_name'];

$type = $_FILES['img']['type'];



$size = getimagesize($tmpname);

$src_img = imagecreatefromjpeg($tmpname);
$dst_img = imagecreatetruecolor(140,140);
imagecopyresampled($dst_img, $src_img, 0, 0, 0, 0, 140, 140, $size[0], $size[1]);
imagejpeg($dst_img, './tmp/kleinesbild.jpg');
imagedestroy($src_img);
imagedestroy($dst_img);



$src_img = imagecreatefromjpeg($tmpname);
$dst_img = imagecreatetruecolor(200,200);
imagecopyresampled($dst_img, $src_img, 0, 0, 0, 0, 200, 200, $size[0], $size[1]);
imagejpeg($dst_img, './tmp/grossesbild.jpg');
imagedestroy($src_img);
imagedestroy($dst_img);

$hndFile = fopen('./tmp/grossesbild.jpg', "r");
$data = addslashes(fread($hndFile, filesize($tmpname)));
$hndFilesmall = fopen('./tmp/kleinesbild.jpg', "r");
$datasmall = addslashes(fread($hndFilesmall, filesize($tmpname)));

//mysql_query("UPDATE album SET imgdata = '$data', imgtype = '$type' WHERE id='$albumID'");

mysql_query("UPDATE album SET imgdata = '$data', imgtype = '$type' WHERE id='$albumID'");
mysql_query("UPDATE album SET imgdata_small = '$datasmall', imgtype = '$type' WHERE id='$albumID'");

}
$query = "select imgdata,imgtype from album where id=$albumID"; 
$result = @MYSQL_QUERY($query); 
$data = @MYSQL_RESULT($result,0,"imgdata"); 

$type = @MYSQL_RESULT($result,0,"imgtype"); 

Header( "Content-type: $type"); 
echo $data; 
?>