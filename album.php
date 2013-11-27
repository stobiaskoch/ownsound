<?php
$artistID = $_REQUEST['artid'];
$yearExpire = time() + 60*60*24*365; // 1 Year
setcookie('lastartist', $artistID, $yearExpire);
$limit = $_REQUEST['limit'];
//setcookie('artist'.$artistID.'page', $limit, $yearExpire);
?>
<html>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<head>
	<script src="./js/jquery.contextMenu.js"></script> 
	<script src="./js/jquery.loadmask.min.js"></script> 
	<script src="./js/jquery.flipster.js"></script>
	<link rel="stylesheet" href="./js/jquery.flipster.css">
	<link rel="stylesheet" href="./js/flowflipsternavtabs.css">
	<script>

 	$(function(){ 
	 
		$(".flipster").flipster({
			start: 'center',
			style: 'coverflow',
		});
	});
 
</script>	
	
	
</head>	

<?php
require_once('config.inc.php');
include('./js/functions.php');

$limit = $_COOKIE["artist".$artistID."page"];
if($limit=="") {$limit=0;}

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
$db_link = mysqli_connect (DBHOST, DBUSER, DBPASS, DBDATABASE );
$db_erg = mysqli_query( $db_link, $sql );
if ( ! $db_erg )
{
  die('Ungültige Abfrage: ' . mysqli_error());
}


  ?>


<h1><span style="top: -6px; left: 20px;" id="<?php echo $artistID; ?>"><?php echo getartist($artistID); ?></span><span><?php echo " [$albumcount]" ?></span></h1></div><br>
<a id="albumtitle2" style="
    width: 900px;
    height: 20px;
	 font-size:12px;
	 bottom: 150px;
"><a>
<!-- Flipster List -->	
		<div class="flipster" style="width: 90%; overflow:off; font-size:10px; bottom: 50px;">
		  <ul>



<?php
while ($zeile = mysqli_fetch_array( $db_erg, MYSQL_ASSOC))
{
$albumID = $zeile['id'];
$titleID = $zeile['id'];

		$sql    = "SELECT cover FROM album WHERE id = '$albumID'";
		$query = mysql_query($sql); 
		$Daten = mysql_fetch_assoc($query); 
		if($Daten['cover']=="no") { goto coverjump; }
		if($Daten['cover']!="yes") {
		
			require_once('./getid3/getid3.php');
			$getID3 = new getID3;
			$sql    = "SELECT path FROM title WHERE album = '$albumID'";
			$query = mysql_query($sql); 
			$Daten = mysql_fetch_array($query);
			$ThisFileInfo = $getID3->analyze($Daten[0]);
			getid3_lib::CopyTagsToComments($ThisFileInfo);
			if($getID3->info['id3v2']['APIC'][0]['data']!="") {
				$artworktmp = './tmp/front'.$albumID.'.jpeg';
				file_put_contents($artworktmp, $getID3->info['id3v2']['APIC'][0]['data']);
				
					thumbnail($artworktmp, $albumID);

					mysql_query("UPDATE album SET cover='yes' WHERE id = '$albumID'");
				}
				else
				{
					mysql_query("UPDATE album SET cover='no' WHERE id = '$albumID'");
					mysql_query("UPDATE album SET coverbig='no' WHERE id = '$albumID'");
				}
			}
coverjump:



		  
	?>		
		
		<li id="Coverflow-1" title="<?php echo getartist($artistID); ?>" data-flip-category="<?php echo getalbum($albumID); ?>">
			<a href='#OwnSound' onclick="getdataalbum('<?php echo $albumID; ?>', '<?php echo $artistID; ?>')">
			<img src='get.php?picid=<?php echo $albumID; ?>' title="<?php echo getalbum($albumID); ?>" width="140" height="140">
		</li>


	<?php

	}
	?>
			  </ul>
		</div>
<!-- End Flipster List -->


<?php
mysqli_free_result( $db_erg );
mysql_close();
?>
