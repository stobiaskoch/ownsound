<?php
$artistID = $_REQUEST['artid'];
$yearExpire = time() + 60*60*24*365; // 1 Year
setcookie('lastartist', $artistID, $yearExpire);
$limit = $_REQUEST['limit'];
//setcookie('artist'.$artistID.'page', $limit, $yearExpire);
?>
<!doctype html>
<html lang="en">
<head>
	<script src="./js/jquery.contextMenu.js"></script> 
	<script src="./js/jquery.loadmask.min.js"></script> 
	<meta name="viewport" content="width=device-width">
	<link rel="stylesheet" href="./css/horizontal.css">
	<script src="./js/modernizr.js"></script>
</head>
<body>
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
		
		<li>
			<img src='get.php?picid=<?php echo $albumID; ?>' title="<?php echo getalbum($albumID); ?>" width="140" height="140" onclick="getdataalbum('<?php echo $albumID; ?>', '<?php echo $artistID; ?>')">
		</li>


	<?php

	}
	?>

		
			<!-- Scripts -->
	<script src="./js/sly.min.js"></script>
	<script src="./js/horizontal.js"></script>