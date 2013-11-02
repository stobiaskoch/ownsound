<html>
	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
<head>

	<script>
		function getdataalbum(albumID, artistID){
		$.ajax({ url: "./title.php?albumID="+albumID+"&artistID="+artistID , success: function(data){
            $("#playalbum").html(data);
    }
    });
	}

		function getdatabig(artid, artname, limit){
		document.getElementById("results").innerHTML="";
		$.ajax({ url: "./album.php?artid="+artid+"&artname="+artname+"&limit="+limit , success: function(data){
            $("#play").html(data);		
			}
		});
	}
	</script>
</head>	
<?php
require_once('config.inc.php');
include('./js/functions.php');
$limit = $_REQUEST['limit'];
if($limit=="") {$limit=0;}

$artistid = $_REQUEST['artid'];


mysql_connect(DBHOST, DBUSER,DBPASS);
mysql_select_db(DBDATABASE) or die ("Die Datenbank existiert nicht.");

$albumcountsql = mysql_query("SELECT * FROM album WHERE artist='$artistid'"); 
$albumcount = mysql_num_rows($albumcountsql);
if($albumcount<=1) {$albumcount = "$albumcount Album"; } else {$albumcount = "$albumcount Alben"; }
	if($albumcount==0) {
		$albumcount = "Keine Alben gefunden";
		$sql = "SELECT * FROM title WHERE artist='$artistid' ORDER BY path";
	}
	else
	{
		$sql = "SELECT * FROM album WHERE artist='$artistid' ORDER BY name LIMIT ".$limit.", 12";
	}
?>
<div id='title'><title><?php getartist($artistid); ?></title></div>
<?php

$db_link = mysqli_connect (DBHOST, DBUSER, DBPASS, DBDATABASE );




 
$db_erg = mysqli_query( $db_link, $sql );
if ( ! $db_erg )
{
  die('Ung�ltige Abfrage: ' . mysqli_error());
}
echo "<div id='playalbum'>";

  ?>
 <br><div id="album">

<div><h1><?php getartist($artistid); echo " [$albumcount]" ?></h1></div>
<?php
if($albumcount>=15) {
$trenner = $albumcount / 15;
$trenner = round($trenner, 0);
$trenner = $trenner +1;
}
echo "<table border='0' valign='top'>";
while ($zeile = mysqli_fetch_array( $db_erg, MYSQL_ASSOC))
{
$albumID = $zeile['id'];
$count++;
$count2++;



	if($albumcount!=0) {
	if ($count2==4) {
  echo "<tr>";
} else {

}
	?>
	<td width="70px"><a href='#dhfig' onclick="getdataalbum('<?php echo $albumID; ?>', '<?php echo $artistid; ?>')"><img src='get.php?picid=<?php echo $albumID; ?>&size=small' width='70' height='70'></a></td>
	<td width="116px"><a href='#dhfig' onclick="getdataalbum('<?php echo $albumID; ?>', '<?php echo $artistid; ?>')"><?php getalbum($albumID); ?></a></td>
	<?php
	if ($count2==3) {
	$count2 = 0;
  echo "</tr>";
} else {

}
	}
	else
	{
	?>
	<tr>
	<td width='300px'><a href='#dhfig' onclick="addalbum('playtitle', '<?php echo $albumID; ?>', '<?php getartist($artistid); ?>')"><?php echo $zeile['name']; ?></a></td><td>[<?php echo $zeile['duration'];?>]</a></td> 
	</tr>
	<?php
	}


}


?>
</table><div>

<?php
if($albumcount>=15) {
$trenner2 = 0;
for ($i = 1; $i <= $trenner; $i++) {

?>
<a style="font-size: 12px;" href='#ownsound' onclick="getdatabig('<?php echo $artistid; ?>', '<?php echo urlencode($artname); ?>', '<?php echo $trenner2; ?>')"><?php echo $i; ?></a>

<?php
$trenner2 = $i * 15;
}
}
mysqli_free_result( $db_erg );

?>
