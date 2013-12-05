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
$listID = $_REQUEST['listID'];
?>
<html>
<head>
	<script src="./js/jquery.form.js"></script> 
	<script src="./js/jquery.loadmask.min.js"></script> 
<script>
	




$(document).ready(function()
{
	$('#upload').ajaxForm(function() { 
			$.ajax({ url: "./title.php?albumID=<?php echo $albumID; ?>&artistID=<?php echo $artistID; ?>" , success: function(data){
            $("#album2").html(data);
    }
    });
			getdata('<?php echo $artistID; ?>', '<?php echo $listID; ?>');
			getdataalbum('<?php echo $albumID; ?>', '<?php echo $artistID; ?>');
    }); 

})
	</script>

</head>	
<?php



if($_REQUEST['order']=="search") {

$albumsearch = "$artist - $album";
//$albumsearch = utf8_decode($albumsearch);
echo "Suche nach: ".stripslashes(utf8_decode($albumsearch))."<br>";

//$albumsearch = str_replace(" ", "+", $albumsearch);
$albumsearch = urlencode($albumsearch);
//$jsrc = "http://ajax.googleapis.com/ajax/services/search/images?v=1.0&q=".$album."&tbs=iar:t,ift:jpg";
$jsrc = "https://ajax.googleapis.com/ajax/services/search/images?v=1.0&q=".$albumsearch."&tbs=iar:t,ift:jpg";


$json = file_get_contents($jsrc);
sleep(1);
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
<div id="googlecover"><tr><td style="width:135px"><a style="font-size:0.7em;" href='#OwnSound' onclick="googledownload('<?php echo $pic; ?>', '<?php echo $albumID; ?>', '<?php echo $artistID; ?>', '<?php echo $listID; ?>')"><img src='<?php echo $pic; ?>' width='135' height='135' title='<?php echo "$picwidth x $picheight\n$pictitle"; ?>'></a>
</td></tr></div>
</table>
<?php
}

?>
<br><br><br><br><br><br><br><br>
<form method="post" name="upload" id="upload" action="./coverup.php" enctype="multipart/form-data" >
<input type="file" id="img" name="img" size="40" accept="image/jpeg">
<input type="hidden" id ="albumID" name="albumID" value="<?php echo $albumID; ?>">
<input type="hidden" id ="listID" name="listID" value="<?php echo $listID; ?>">
<input type="submit" value="Ändern">
</form><br>
	<a href='#dhfig' onclick="getdataalbum('<?php echo $albumID; ?>', '<?php echo $artistID; ?>')">Zurück</a>
<?php
}










if($_REQUEST['order']=="save") {
require_once './js/thumb/ThumbLib.inc.php';
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
  
coverinmysql($newfname, $albumID);

}
?>
