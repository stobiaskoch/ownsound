<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
<?php
require_once('config.inc.php');
include('./js/functions.php');
mysql_connect(DBHOST, DBUSER,DBPASS) OR DIE ("NICHT Erlaubt");
mysql_select_db(DBDATABASE) or die ("Die Datenbank existiert nicht.");
$artistID = $_REQUEST['artistID'];
$artist = addslashes(getartist($_REQUEST['artistID']));
$albumID = $_REQUEST['albumID'];
$album = addslashes(getalbum($_REQUEST['albumID']));
?>
<html>
<head>

	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script> 

	<script src="./js/jquery.form.js"></script> 
	
	
<script>
	




$(document).ready(function()
{
	$('#upload').ajaxForm(function() { 
			$.ajax({ url: "./title.php?albumID=<?php echo $albumID; ?>&artistID=<?php echo $artistID; ?>" , success: function(data){
            $("#playalbum").html(data);
    }
    });
			sleep(1000);
			stats();
			getdataalbum('<?php echo $albumID; ?>', '<?php echo $artistID; ?>');
    }); 

})
	</script>

</head>	
<?php



if($_REQUEST['order']=="search") {

$albumsearch = "$artist - $album";
//$albumsearch = urlencode($albumsearch);
echo "Suche nach: ".stripslashes($albumsearch)."<br>";

$albumsearch = str_replace(" ", "+", $albumsearch);
//$albumsearch = urlencode($albumsearch);
//$jsrc = "http://ajax.googleapis.com/ajax/services/search/images?v=1.0&q=".$album."&tbs=iar:t,ift:jpg";
$jsrc = "https://ajax.googleapis.com/ajax/services/search/images?v=1.0&q=".$albumsearch."&tbs=iar:t,ift:jpg";

$json = file_get_contents($jsrc);
sleep(3);
$jset = json_decode($json, true);


for ($i = 0; $i <= 3; $i++) {
echo '<table border="0" style="float:left;">';
echo "<tr>";
$pic = $jset["responseData"]["results"][$i]["url"];
$picwidth = $jset["responseData"]["results"][$i]["width"];
$picheight = $jset["responseData"]["results"][$i]["height"];
 $pictitle = $jset["responseData"]["results"][$i]["contentNoFormatting"];

echo "<td style='width:135px'><center>$picwidth x $picheight</center></td></tr>";
?>
<tr><td style="width:135px"><a style="font-size:0.7em;" href='#fdfdf' onclick="googledownload('<?php echo $pic; ?>', '<?php echo $albumID; ?>', '<?php echo $artistID; ?>')"><img src='<?php echo $pic; ?>' width='135' height='135' title='<?php echo "$picwidth x $picheight\n$pictitle"; ?>'></a>
</td></tr>
</table>
<?php
}

?>

<form method="post" name="upload" id="upload" action="./coverup.php" enctype="multipart/form-data" >
<input type="file" id="img" name="img" size="40" accept="image/jpeg">
<input type="hidden" id ="albumID" name="albumID" value="<?php echo $albumID; ?>">
<input type="submit" value="Ändern">
</form><br>
	<a href='#dhfig' onclick="getdataalbum('<?php echo $albumID; ?>', '<?php echo $artistID; ?>')">Zurück</a>
<?php
}










if($_REQUEST['order']=="save") {
$url = $_REQUEST['url'];

  $newfname = "./tmp/".$albumID."_original.jpg";
  $file = fopen ($url, "rb");
  if ($file) {
    $newf = fopen ($newfname, "wb");

    if ($newf)
    while(!feof($file)) {
      fwrite($newf, fread($file, 1024 * 8 ), 1024 * 8 );
    }
  }

  if ($file) {
    fclose($file);
  }

  if ($newf) {
    fclose($newf);
  }
  
  

$tmpname = $newfname;
$size = getimagesize($tmpname);  
  
$src_img = imagecreatefromjpeg($tmpname);
$dst_img = imagecreatetruecolor(70,70);
imagecopyresampled($dst_img, $src_img, 0, 0, 0, 0, 70, 70, $size[0], $size[1]);
imagejpeg($dst_img, './tmp/kleinesbild.jpg');
imagedestroy($src_img);
imagedestroy($dst_img);



$src_img = imagecreatefromjpeg($tmpname);
$dst_img = imagecreatetruecolor(140,140);
imagecopyresampled($dst_img, $src_img, 0, 0, 0, 0, 140, 140, $size[0], $size[1]);
imagejpeg($dst_img, './tmp/grossesbild.jpg');
imagedestroy($src_img);
imagedestroy($dst_img);

$hndFile = fopen('./tmp/grossesbild.jpg', "r");
$data = addslashes(fread($hndFile, filesize($tmpname)));
$hndFilesmall = fopen('./tmp/kleinesbild.jpg', "r");
$datasmall = addslashes(fread($hndFilesmall, filesize($tmpname)));

mysql_query("UPDATE album SET imgdata = '$data', imgtype = '$type' WHERE id='$albumID'");
mysql_query("UPDATE album SET imgdata_small = '$datasmall', imgtype = '$type' WHERE id='$albumID'");
unlink($newfname);
unlink('./tmp/grossesbild.jpg');
unlink('./tmp/kleinesbild.jpg');


}
?>
