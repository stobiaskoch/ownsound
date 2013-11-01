<html>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<head>

	<script>
		function getdataalbum(albid, artname, artid, albname){
		$.ajax({ url: "./title.php?albid="+albid+"&art="+artname+"&artid="+artid+"&albname="+albname , success: function(data){
            $("#playalbum").html(data);
    }
    });
	var titleoben = decodeURIComponent(albname);
	var jetzt = titleoben.replace("+", " ");
	var jetzt = jetzt.replace("+", " ");
	var jetzt = jetzt.replace("+", " ");
	var jetzt = jetzt.replace("+", " ");
	document.getElementById("title").innerHTML="<title>"+jetzt+"</title>";
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
$limit = $_REQUEST['limit'];
if($limit=="") {$limit=0;}
$artistid = $_REQUEST['artid'];
$artname= $_REQUEST['artname'];

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
<div id='title'><title><?php echo $artname; ?></title></div>
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
<?php
echo "<div><h1>$artname [$albumcount]</h1></div>";
if($albumcount>=15) {
$trenner = $albumcount / 15;
$trenner = round($trenner, 0);
$trenner = $trenner +1;
}
echo "<table border='0' valign='top'>";
while ($zeile = mysqli_fetch_array( $db_erg, MYSQL_ASSOC))
{
$count++;
$count2++;
if ($count2==4) {
  echo "<tr>";
} else {

}


	if($albumcount!=0) {
	?>
	<td width="70px"><a href='#dhfig' onclick="getdataalbum('<?php echo $zeile['id']; ?>', '<?php echo urlencode($artname); ?>', '<?php echo $artistid; ?>', '<?php echo urlencode($zeile['name']); ?>')"><img src='get.php?picid=<?php echo $zeile['id']; ?>&size=small' width='70' height='70'></a></td>
	<td width="116px"><a href='#dhfig' onclick="getdataalbum('<?php echo $zeile['id']; ?>', '<?php echo urlencode($artname); ?>', '<?php echo $artistid; ?>', '<?php echo urlencode($zeile['name']); ?>')"><?php echo $zeile['name']; ?></a></td>
	<?php
	}
	else
	{
	?>
	<td width='300px'><a href='#dhfig' onclick="addalbum('playtitle', '<?php echo $zeile['id']; ?>', '<?php echo urlencode($artname); ?>')"><?php echo $zeile['name']; ?></a></td><td>[<?php echo$zeile['duration'];?>]</a></td> 
	<?php
	}

if ($count2==3) {
	$count2 = 0;
  echo "</tr>";
} else {

}
}


?>
</table><div>

<?php
if($albumcount>=15) {
$trenner2 = 0;
for ($i = 1; $i <= $trenner; $i++) {

?>
<a href='#ownsound' onclick="getdatabig('<?php echo $artistid; ?>', '<?php echo urlencode($artname); ?>', '<?php echo $trenner2; ?>')"><?php echo $i; ?></a>

<?php
$trenner2 = $i * 15;
}
}
mysqli_free_result( $db_erg );

?>
