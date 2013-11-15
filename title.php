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
<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
<head>

	<script src="./js/jquery.jeditable.js"></script> 
	<script src="./js/jquery.contextMenu.js"></script> 
	<script src="./js/jquery.loadmask.min.js"></script> 
	<script>
$(document).ready(function() {

   $('.edit').editable('jeditable.php', {
       indicator : "<img src='img/indicator.gif'>", 
	event     : "dblclick",
	cancel    : "Cancel",
	submit   : 'OK',
	tooltip   : "Click to edit..."	   
});  
 });
 
 

	

	

	</script>

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
 <br>
<div id="content">



	<h1 style="position: absolute; top: -6px; left: 20px;"><a style="color:blue;" href='#dhfig' onclick="getdata('<?php echo $artistID; ?>')">[<?php echo getartist($artistID); ?>] - </a>
  

<a class='edit' id="<?php echo $albumID; ?>"><?php echo getalbum($albumID); ?></a></h1><br>
<table border="0">

<?php
while ($zeile = mysqli_fetch_array( $db_erg, MYSQL_ASSOC))
{
$path=$zeile['path'];
$titleID = $zeile['id'];
$artist = getartist($artistID);
$track = $zeile['track'];
$count++;
if($track<="9") {$track="0$track";}
  echo "<tr>";
  	echo "<td>". $track . " - </td>";
?> 
<!--
	<td width='300px'><div class="target<?php echo $count; ?>"><a href='#dhfig' onclick="addalbum('playtitle', '<?php echo $titleID; ?>', '<?php getartist($artistID); ?>')"><?php gettitle($titleID); ?></a></td><td>[<?php echo$zeile['duration'];?>]</a></div></td> 
-->
	<td width='300px'><div class="targettrack<?php echo $count; ?>"><a href="#"><?php echo gettitle($titleID); ?></a></td><td>[<?php echo $zeile['duration'];?>]</div></td> 

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
					click: function(element){ alert('kommt...'); },
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
?>
		</tr>
	<td></td><tr>
	

</table>
<div class="target_album"><a href='#OwnSound'>Albumsoptionen</a></div></td>
		<script type="text/javascript">
		  $(document).ready(function(){

			$('.target_album').contextMenu('context-menu-1', {
				'<?php echo addslashes($artist); ?> - <?php echo addslashes(getalbum($albumID)); ?><br>': {
					klass: "menu-item-oben" 
				},
				'Abspielen': {
					click: function(element) {  // element is the jquery obj clicked on when context menu launched
						addalbum('playalbum', '<?php echo $albumID; ?>', '<?php echo $artistID; ?>')
					},
					klass: "menu-item-1" // a custom css class for this menu item (usable for styling)
				},
				'Einreihen': {
					click: function(element){ 
					addalbum('addalbum', '<?php echo $albumID; ?>', '<?php echo $artistID; ?>')
					},
					klass: "second-menu-item"
				},
				'Download': {
					click: function(element){ 
					zipalbum('<?php echo $albumID; ?>')
					},
					klass: "third-menu-item"
				},
				'Umbennen': {
					click: function(element){ alert('kommt...'); },
					klass: "third-menu-item"
				},
				'Löschen': {
					click: function(element){ 
					if (confirm('Willst Du <?php echo getalbum($albumID); ?> wirklich endgültig löschen?'))
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


<map name="Landkarte">
	 <area shape="rect" coords="1,1,249,139" href='#OwnSound' onclick="google('<?php echo $artistID; ?>', '<?php echo $albumID; ?>')"></a>
</map>
<img src='./get.php?picid=<?php echo $albumID; ?>&size=big' width="140" title="Cover ändern" usemap="#Landkarte" border=0>
<?php echo "<br>Genre: " . getgenrefromalbumID($albumID); ?>
</div>

</div>
<?php
ende:
mysqli_free_result( $db_erg );
mysql_close();
?>
