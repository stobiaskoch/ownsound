<?php
require_once('config.inc.php');
include('./js/functions.php');
require_once './js/thumb/ThumbLib.inc.php';
$albumID = $_REQUEST['albumID'];
$artistID = $_REQUEST['artistID'];
$yearExpire = time() + 60*60*24*365; // 1 Year
setcookie('lastalbum', $albumID, $yearExpire);
$db_link = mysqli_connect (DBHOST, DBUSER, DBPASS, DBDATABASE );
?>
<html>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<head>

	<script src="./js/jquery.contextMenu.js"></script> 
	<script src="./js/jquery.loadmask.min.js"></script> 

</head>	
<?php
		$sql    = "SELECT coverbig FROM album WHERE id = '$albumID'";
		$query = mysql_query($sql); 
		$Daten = mysql_fetch_assoc($query); 
		if($Daten['coverbig']=="no") { goto coverjump; }
		if($Daten['coverbig']!="yes") {
		thumbreflection($albumID);
		}
	
coverjump:
$sql = "SELECT * FROM title WHERE album='$albumID' ORDER BY ABS(track)";
 
$db_erg = mysqli_query( $db_link, $sql );
if ( ! $db_erg )
{
  die('Ungültige Abfrage: ' . mysqli_error());
}
    ?>





<h1 style="position: absolute; top: -6px; left: 20px;"><a style="color:blue;" href='#dhfig' onclick="getdata('<?php echo $artistID; ?>')">[<?php echo getartist($artistID); ?>] - </a>
<a id="<?php echo $albumID; ?>"><?php 
if(strlen(getalbum($albumID))>=30) {
echo substr(getalbum($albumID), 0, 30) . "..."; 
}
else
{
echo getalbum($albumID); 
}

?>


</a></h1>

<a style="position: relative; top: -14px; float: right;" href="#OwnSound" onclick="addalbum('addalbum', '<?php echo $albumID; ?>', '<?php echo $artistID; ?>');" class="button add">Hinzufügen</a>
<a style="position: relative; top: -14px; float: right;" href="#OwnSound" onclick="addalbum('playalbum', '<?php echo $albumID; ?>', '<?php echo $artistID; ?>');" class="button play">Abspielen</a>
<div class="target_album">
<a style="position: relative; top: -14px; float: right;" href='#OwnSound' class="button options">Optionen</a>
</div>
<br><table border="0">

<?php
while ($zeile = mysqli_fetch_array( $db_erg, MYSQL_ASSOC))
{
$path=$zeile['path'];
$titleID = $zeile['id'];
$artist = getartist($artistID);
$track = $zeile['track'];
$duration=$zeile['duration'];
$count++;
if($track<="9") {$track="0$track";}
$gesamtdauer+=strtotime($duration);
  	echo "<tr><td>". $track . " - </td>";
?> 
	<td width='300px'><div class="targettrack<?php echo $count; ?>"><a style="font-size: 12px;" href="#"><?php echo gettitle($titleID); ?></a></td><td>[<?php echo $zeile['duration'];?>]</td></div> 

		<script type="text/javascript">
		  $(document).ready(function(){

			$('.targettrack<?php echo $count; ?>').contextMenu('context-menu-1', {
				'<?php echo addslashes(getartist($artistID)); ?> - <?php echo addslashes(gettitle($titleID)); ?>': {
				klass: "menu-item-oben" 
				},
				'Abspielen': {
					click: function(element) {  // element is the jquery obj clicked on when context menu launched
						addalbum('playtitle', '<?php echo $titleID; ?>', '<?php echo $artistID; ?>');
					},
					klass: "menu-item-1" // a custom css class for this menu item (usable for styling)
				},
				'Einreihen': {
					click: function(element){ 
					addalbum('addtitle', '<?php echo $titleID; ?>', '<?php echo $artistID; ?>');
					},
					klass: "second-menu-item"
				},
				'Umbennen': {
					click: function(element){ 
					var newtitle = window.prompt("Bitte neuen Titelnamen eingeben", "<?php echo addslashes(gettitle($titleID)); ?>");
					 if (newtitle != undefined) {
					 newtitle = encodeURIComponent(newtitle);
					$.ajax({ url: "./jeditable.php?order=title&id=<?php echo $titleID; ?>&value="+newtitle ,
						success: function(data){
						}
					});
					getdataalbum(<?php echo $albumID; ?>, <?php echo $artistID; ?>);
					}
					
					},
					klass: "third-menu-item"
				},
				'Löschen': {
					click: function(element){ 
						if (confirm('Willst Du <?php echo addslashes(gettitle($titleID)); ?> wirklich endgültig löschen?'))
					{
						deletetitle('<?php echo $titleID; ?>', '<?php echo $albumID; ?>', '<?php echo $artistID; ?>');
					}
					
					},
					klass: "fourth-menu-item"
				},
				'Track-Nummer ändern': {
					click: function(element){ 
					var newtitle = window.prompt("Bitte neuen Titelnamen eingeben", "<?php echo $track; ?>");
					 if (newtitle != undefined) {
					 newtitle = encodeURIComponent(newtitle);
					$.ajax({ url: "./jeditable.php?order=track&id=<?php echo $titleID; ?>&value="+newtitle ,
						success: function(data){
						}
					});
					getdataalbum(<?php echo $albumID; ?>, <?php echo $artistID; ?>);
					}
					
					},
					klass: "fifth-menu-item"
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

$gesamtdauer=date("i:s",$gesamtdauer);
?>
		</tr>
	<td></td><tr>
	

</table>

		<script type="text/javascript">
		  $(document).ready(function(){

			$('.target_album').contextMenu('context-menu-1', {
				'<?php echo addslashes($artist); ?> - <?php echo addslashes(getalbum($albumID)); ?><br>': {
					klass: "menu-item-oben" 
				},

				'Download': {
					click: function(element){ 
						zipalbum('<?php echo $albumID; ?>')
					},
					klass: "third-menu-item"
				},
				'Umbennen': {
					click: function(element){
					var newtitle = window.prompt("Bitte neuen Titelnamen eingeben", "<?php echo addslashes(getalbum($albumID)); ?>");
					 if (newtitle != undefined) {
					 newtitle = encodeURIComponent(newtitle);
					$.ajax({ url: "./jeditable.php?order=album&id=<?php echo $albumID; ?>&value="+newtitle ,
						success: function(data){
						}
					});
						getdata(<?php echo $artistID; ?>);
						getdataalbum(<?php echo $albumID; ?>, <?php echo $artistID; ?>);
					}},
					klass: "third-menu-item"
				},
				'Löschen': {
					click: function(element){ 
						if (confirm('Willst Du <?php echo addslashes(getalbum($albumID)); ?> wirklich endgültig löschen?'))
					{
						deletealbum('<?php echo $albumID; ?>', '<?php echo $artistID; ?>');
					}
					
					},
					klass: "fourth-menu-item"
}
  },
  {

    leftClick: true // trigger on left click instead of right click
  }
);
		  });
		</script>

<div id="covertitle" style="font-size:0.6em;">
<table>
<td>
<map name="Landkarte">
	 <area shape="rect" coords="1,1,249,139" href='#OwnSound' onclick="google('<?php echo $artistID; ?>', '<?php echo $albumID; ?>')"></a>
</map>
<img src='./get.php?picid=<?php echo $albumID; ?>&size=big' width="140" title="Cover ändern" usemap="#Landkarte" border=0>
<br></td><td width='140'>
<?php echo "Genre: " . getgenrefromalbumID($albumID).'<br/>Gesamtdauer: '.$gesamtdauer; ?>
</td></table>
</div>


<?php
ende:
mysqli_free_result( $db_erg );
mysql_close();
?>
