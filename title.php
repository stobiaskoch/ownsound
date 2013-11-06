<?php
require_once('config.inc.php');
include('./js/functions.php');
$albumID = $_REQUEST['albumID'];
$artistID = $_REQUEST['artistID'];
$yearExpire = time() + 60*60*24*365; // 1 Year
setcookie('lastalbum', $albumID, $yearExpire);
$db_link = mysqli_connect (DBHOST, DBUSER, DBPASS, DBDATABASE );



?>
<html>
<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
<head>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script> 
	<script src="./js/jquery.jeditable.js"></script> 
	<script src="./js/jquery.contextMenu.js"></script> 
	<script src="./js/jquery.form.js"></script> 
	<script type="text/javascript" src="./js/ownsound.js"></script>
	<script>
$(document).ready(function() {

   $('.edit').editable('jeditable.php', {
       indicator : "Saving...",  
       submit   : 'OK'                  
	});  
 });
 
 
		function google(artistID, albumID){
		$.ajax({ url: "./google.php?order=search&artistID="+artistID+"&albumID="+albumID , success: function(data){
            $("#content").html(data);
    }
    });
	}
	
				function googledownload(pic, albumID, artistID){
		$.ajax({ url: "./google.php?order=save&url="+pic+"&albumID="+albumID+"&artistID="+artistID});
		sleep(2500);
		$.ajax({ url: "./title.php?albumID="+albumID+"&artistID="+artistID , success: function(data){
            $("#playalbum").html(data);
            stats();
    }
    });
			
			getdataalbum(albumID, artistID);
	}
	

	

	</script>

</head>	
<?php

$sql = "SELECT * FROM title WHERE album='$albumID' ORDER BY track";
 
$db_erg = mysqli_query( $db_link, $sql );
if ( ! $db_erg )
{
  die('Ungültige Abfrage: ' . mysqli_error());
}
    ?>
 <br>
<div id="content">



	<h1 style="position: absolute; top: -6px; left: 20px;"><a style="color:blue;" href='#dhfig' onclick="getdata('<?php echo $artistID; ?>')">[<?php echo getartist($artistID); ?>] - </a>
  

<a class='edit' id="<?php echo $albumID; ?>" title="Klicken zum Bearbeiten"><?php echo getalbum($albumID); ?></a></h1><br>
<table border="0">

<?php
while ($zeile = mysqli_fetch_array( $db_erg, MYSQL_ASSOC))
{
$path=$zeile['path'];
$titleID = $zeile['id'];
$artist = getartist($artistID);

$count++;
if($count<="9") {$count="0$count";}
  echo "<tr>";
  	echo "<td>". $count . " - </td>";
?> 
<!--
	<td width='300px'><div class="target<?php echo $count; ?>"><a href='#dhfig' onclick="addalbum('playtitle', '<?php echo $titleID; ?>', '<?php getartist($artistID); ?>')"><?php gettitle($titleID); ?></a></td><td>[<?php echo$zeile['duration'];?>]</a></div></td> 
-->
	<td width='300px'><div class="target<?php echo $count; ?>"><a href="#"><?php echo gettitle($titleID); ?></a></td><td>[<?php echo$zeile['duration'];?>]</div></td> 

		<script type="text/javascript">
		  $(document).ready(function(){

			$('.target<?php echo $count; ?>').contextMenu('context-menu-1', {
				'<?php echo addslashes(getartist($artistID)); ?> - <?php echo addslashes(gettitle($titleID)); ?>': {},
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
?>
		</tr>
	<td></td><tr>
	

</table>
<br><div class="target_album"><a href='#'>Album hinzufügen</a></div></td>
		<script type="text/javascript">
		  $(document).ready(function(){

			$('.target_album').contextMenu('context-menu-1', {
				'<?php echo addslashes($artist); ?> - <?php echo addslashes(getalbum($albumID)); ?><br>': {},
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

<div id="covertitle">
	<a href='#dhfig' onclick="google('<?php echo $artistID; ?>', '<?php echo $albumID; ?>')"><img src='./get.php?picid=<?php echo $albumID; ?>&size=big' width="140" height="140" title="Cover ändern"></a>
</div>






</div>
<?php
ende:
mysqli_free_result( $db_erg );


?>
