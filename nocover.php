<html>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<head>

	<script>
		function getdataalbum(albid, artname, artid, albname){
		$.ajax({ url: "./title.php?albid="+albid+"&art="+artname+"&artid="+artid+"&albname="+albname , success: function(data){
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
 <br><div style="
padding-left: 40px;
width: auto;
left: 320px;
top: 262px;
display:inline-block;
-webkit-box-shadow:0 6px 6px 0 rgba(0,0,0,0.3);
box-shadow:0 2px 6px 0 rgba(0,0,0,0.3);
background:#fff;
padding:20px;
margin:0 0 20px 12px;
position:fixed;
">
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
	<td width="70px"><a href='#dhfig' onclick="getdataalbum('<?php echo $albumID; ?>', '<?php echo $artname; ?>', '<?php echo $artistID; ?>', '<?php echo urlencode($album); ?>')"><img src='get.php?picid=<?php echo $zeile['id']; ?>&size=small' width='70' height='70'></a></td>
	<td width="116px"><a href='#dhfig' onclick="getdataalbum('<?php echo $albumID; ?>', '<?php echo $artname; ?>', '<?php echo $artistID; ?>', '<?php echo urlencode($album); ?>')">[<?php echo $artname ."]<br>".$zeile['name']; ?></a></td>
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
if($count=="" or $count=="0") { ?>
<script language="JavaScript">
getdatanoalbum('<?php echo $artistid; ?>', '<?php echo $artname; ?>');
</script>
<?php
}
?>