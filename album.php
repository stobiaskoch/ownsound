<?php
$artistid = $_REQUEST['artid'];
$yearExpire = time() + 60*60*24*365; // 1 Year
setcookie('lastartist', $artistid, $yearExpire);
setcookie ("lastalbum", "", time() - 3600);
?>
<html>
	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">	
<head>
</head>	
<?php
require_once('config.inc.php');
include('./js/functions.php');
$limit = $_REQUEST['limit'];
if($limit=="") {$limit=0;}

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
  die('UngÃ¼ltige Abfrage: ' . mysqli_error());
}
echo "<div id='play'>";

  ?>
 <br><div id="album">

<div><h1><?php echo getartist($artistid); echo " [$albumcount]" ?></h1></div>
<?php
if($albumcount>=16) {
$trenner = $albumcount / 15;
$trenner = round($trenner, 0);
$trenner = $trenner +1;
}
echo "<table border='0' valign='top'>";
while ($zeile = mysqli_fetch_array( $db_erg, MYSQL_ASSOC))
{
$albumID = $zeile['id'];
$titleID = $zeile['id'];
$count++;
$count2++;



	if($albumcount!=0) {
	if ($count2==4) {
  echo "<tr>";
} else {

}
	?>
	<td width="70px"><a href='#ownsound' onclick="getdataalbum('<?php echo $albumID; ?>', '<?php echo $artistid; ?>')"><img src='get.php?picid=<?php echo $albumID; ?>&size=small' width='70' height='70'></a></td>
	<td width="116px"><a href='#ownsound' onclick="getdataalbum('<?php echo $albumID; ?>', '<?php echo $artistid; ?>')"><?php echo getalbum($albumID); ?></a></td>
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
	<!--
	<td width='300px'><a href='#dhfig' onclick="addalbum('playtitle', '<?php echo $albumID; ?>', '<?php getartist($artistid); ?>')"><?php echo $zeile['name']; ?></a></td><td>[<?php echo $zeile['duration'];?>]</a></td> 
-->
	<td width='300px'><div class="einzelsong"><a href="#"><?php echo $zeile['name']; ?></a></td><td>[<?php echo$zeile['duration'];?>]</div></td> 

		<script type="text/javascript">
		  $(document).ready(function(){

			$('.einzelsong').contextMenu('context-menu-1', {
				'Abspielen': {
					click: function(element) {  // element is the jquery obj clicked on when context menu launched
						addalbum('playtitle', '<?php echo $titleID; ?>', '<?php echo $artistid; ?>');
					},
					klass: "menu-item-1" // a custom css class for this menu item (usable for styling)
				},
				'Einreihen': {
					click: function(element){ 
					addalbum('addtitle', '<?php echo $titleID; ?>', '<?php echo $artistid; ?>');
					},
					klass: "second-menu-item"
				},
				'Umbennen': {
					click: function(element){ alert('kommt...'); },
					klass: "third-menu-item"
				},
				'Löschen': {
					click: function(element){ alert('kommt...'); },
					klass: "fourth-menu-item"
}
  },
  {

    leftClick: true // trigger on left click instead of right click
  }
);
		  });
		</script>
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
