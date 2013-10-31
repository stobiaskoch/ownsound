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

mysql_connect(DBHOST, DBUSER,DBPASS);
mysql_select_db(DBDATABASE) or die ("Die Datenbank existiert nicht.");
$albumcountsql = mysql_query("SELECT * FROM album WHERE artist='$artistid'"); 
$albumcount = mysql_num_rows($albumcountsql);
if($albumcount<=1) {$albumcount = "$albumcount Album"; } else {$albumcount = "$albumcount Alben"; }

echo "<div id='title'><title>".$artname."</title></div>";

$db_link = mysqli_connect (DBHOST, DBUSER, DBPASS, DBDATABASE );


$sql = "SELECT * FROM album WHERE artist='$artistid' ORDER BY name";
 
$db_erg = mysqli_query( $db_link, $sql );
if ( ! $db_erg )
{
  die('Ung�ltige Abfrage: ' . mysqli_error());
}
echo "<div id='playalbum'>";

  ?>
 <br><div id="album"">
<?php
 echo "<div><h1>$artname [$albumcount]</h1></div>";
echo "<table border='0' valign='top'>";
while ($zeile = mysqli_fetch_array( $db_erg, MYSQL_ASSOC))
{
$count++;
$count2++;
if ($count2==4) {
  echo "<tr>";
} else {

}

  ?>
	<td width="70px"><a href='#dhfig' onclick="getdataalbum('<?php echo $zeile['id']; ?>', '<?php echo urlencode($artname); ?>', '<?php echo $artistid; ?>', '<?php echo urlencode($zeile['name']); ?>')"><img src='get.php?picid=<?php echo $zeile['id']; ?>&size=small' width='70' height='70'></a></td>
	<td width="116px"><a href='#dhfig' onclick="getdataalbum('<?php echo $zeile['id']; ?>', '<?php echo urlencode($artname); ?>', '<?php echo $artistid; ?>', '<?php echo urlencode($zeile['name']); ?>')"><?php echo $zeile['name']; ?></a></td>
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
getdatanoalbum('<?php echo $artistid; ?>', '<?php echo urlencode($artname); ?>');
</script>
<?php
}
?>
