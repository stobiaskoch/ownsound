<?php
require_once('config.inc.php');
include('./js/functions.php');
require_once './js/thumb/ThumbLib.inc.php';
$albumID = $_REQUEST['albumID'];
$artistID = getartistIDfromalbumID($albumID);
$listID = $_REQUEST['listID'];
$yearExpire = time() + 60*60*24*365; // 1 Year
setcookie('lastalbum', $albumID, $yearExpire);
$db_link = mysqli_connect (DBHOST, DBUSER, DBPASS, DBDATABASE );
$backroundheight = $_COOKIE['screenheight'];
$backroundwidth = $_COOKIE['screenwidth'];
?>
<html>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<head>

	<script src="./js/jquery.contextMenu.js"></script> 
	<script src="./js/jquery.loadmask.min.js"></script> 

</head>	
<!--
<div id="background" style="
    width:250%; 
    height: 500px; 
	top: 30px;
    left: 0px; 
	position: fixed;
    z-index: -2;
	">
    <img src="./get.php?picid=<?php echo $albumID; ?>&size=big" width="<?php echo $backroundwidth; ?>" alt="" style="-webkit-filter: grayscale(0.8) blur(5px);"/>
</div>
-->
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






<h1 style="position: absolute; top: -6px; left: 20px;"><a style="color:blue;" href='#OwnSound' onclick="getdata('<?php echo $artistID; ?>')">[<?php echo getartist($artistID); ?>] - </a>
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
$gsecs=0;
function zeitformat($sec) 
  { 
  $sec = abs($sec);     // Ganzzahlwert bilden 
  return sprintf("%02d:%02d:%02d", ($sec/60/60)%24,($sec/60)%60,$sec%60);
  } 
while ($zeile = mysqli_fetch_array( $db_erg, MYSQL_ASSOC))
{
$path=$zeile['path'];
$titleID = $zeile['id'];
$artist = getartist($artistID);
$track = $zeile['track'];

$duration=explode(":",$zeile['duration']);
$sekunden+=$duration[0]*60+$duration[1];

$count++;
if($track<="9") {$track="0$track";}

  	echo "<tr><td>". $track . " - </td>";
?> 
	<td width='300px'><div class="targettrack<?php echo $count; ?>"><a style="font-size: 12px;" href="#"><?php echo gettitle($titleID); ?></a></td><td>[<?php echo $zeile['duration'];?>]<font size='0.2em'>    <?php echo $zeile['plays'];?> plays</font></td></div> 

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

$gesamtdauer=zeitformat($sekunden);
?>
		</tr>
	<tr>
	

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
				'Album umbennen': {
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
				'Interpret umbennen': {
					click: function(element){
					var newtitle = window.prompt("Bitte neuen Interpreten eingeben", "<?php echo addslashes($artist); ?>");
					 if (newtitle != undefined) {
					 newtitle = encodeURIComponent(newtitle);
					$.ajax({ url: "./jeditable.php?order=artist&id=<?php echo $artistID; ?>&value="+newtitle ,
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
<table><tr>
<td>
<map name="Landkarte">
	 <area shape="rect" coords="1,1,249,139" href='#OwnSound' onclick="google('<?php echo $artistID; ?>', '<?php echo $albumID; ?>', '<?php echo $listID; ?>')"></a>
</map>
<img src='./get.php?picid=<?php echo $albumID; ?>&size=big' width="140" title="Cover ändern" usemap="#Landkarte" border=0>
<br></td><td width='140'>
<?php echo "Genre: " . getgenrefromalbumID($albumID).'<br/>Gesamtdauer: '.$gesamtdauer.'<br/>'.getalbumplays($albumID).' mal abgespielt'; ?>
</td></tr></table>
</div>


<?php
ende:
mysqli_free_result( $db_erg );
mysql_close();
?>
