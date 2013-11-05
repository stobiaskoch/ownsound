<html>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<head>

	<script>
		function getdataalbum(albumID, artistID){
		$.ajax({ url: "./title.php?albumID="+albumID+"&artistID="+artistID, success: function(data){
            $("#playalbum").html(data);
    }
    });
	document.getElementById("title").innerHTML="<title>"+albname+"</title>";
	}
			function getdatanoalbum(artid, albname){
		$.ajax({ url: "./noalbum.php?artid="+artid+"&albname="+albname , success: function(data){
            $("#playalbum").html(data);
    }
    });
	}
	</script>
</head>	
<?php
require_once('config.inc.php');
$artistid = $_REQUEST['artid'];
$artname= $_REQUEST['artname'];

echo "<div id='title'><title>".$artname."</title></div>";

$db_link = mysqli_connect (DBHOST, DBUSER, DBPASS, DBDATABASE );


$sql = "SELECT * FROM album WHERE imgdata='' ORDER BY name";
 
$db_erg = mysqli_query( $db_link, $sql );
if ( ! $db_erg )
{
  die('Ungültige Abfrage: ' . mysqli_error());
}
echo "<div id='playalbum'>";

  ?>
 <br><div id="album">
<?php
 echo "<div><h1>$artname</h1></div>";
echo "<table border='0' valign='top'>";
while ($zeile = mysqli_fetch_array( $db_erg, MYSQL_ASSOC))
{
$count++;
$count2++;
if ($count2==4) {
  echo "<tr>";
} else {

}
	mysql_connect(DBHOST, DBUSER,DBPASS) OR DIE ("NICHT Erlaubt");
	mysql_select_db(DBDATABASE) or die ("Die Datenbank existiert nicht.");
		$albumID = $zeile['id'];
		$sql    = "SELECT * FROM album WHERE id = '$albumID'";
		$query = mysql_query($sql); 
		$Daten = mysql_fetch_assoc($query); 
		$artistID = $Daten['artist'];
		$album = $Daten['name'];
		
		$sql    = "SELECT * FROM artist WHERE id = '$artistID'";
		$query = mysql_query($sql); 
		$Daten = mysql_fetch_assoc($query); 
		$artname = $Daten['name'];
		
  ?>
	<td width="70px"><a href='#dhfig' onclick="getdataalbum('<?php echo $albumID; ?>', '<?php echo $artistID; ?>')"><img src='get.php?picid=<?php echo $zeile['id']; ?>&size=small' width='70' height='70'></a></td>
	<td width="116px"><a href='#dhfig' onclick="getdataalbum('<?php echo $albumID; ?>', '<?php echo $artistID; ?>'); ?>')">[<?php echo $artname ."]<br>".$zeile['name']; ?></a></td>
  <link id="favicon" rel="icon" type="image/jpeg" href="get.php?picid=<?php echo $zeile['id']; ?>" /> 
  <?php
if ($count2==3) {
	$count2 = 0;
  echo "</tr>";
} else {

}
}
echo "</table><div>";



mysqli_free_result( $db_erg );


?>
