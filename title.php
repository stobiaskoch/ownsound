<?php
$albumid = $_REQUEST['albid'];
$albname = $_REQUEST['albname'];
echo "<title>".$albname."</title>";
?>
<html>
<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
<title><?php echo $artname; ?></title>
<head>

	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script> 

	<script src="jquery.form.js"></script> 
	
	
	<script>
$(document).ready(function()
{
	$('#upload').ajaxForm(function() { 
		var id = "get.php?picid=<?php echo $albumid; ?>&size=small";
		document.getElementById("covertest").innerHTML="<span class='crest' style='background: url("+id+") no-repeat 0 0;'></span>";
		document.upload.reset();
    }); 

})

		function google(artist, albumname, albumid, artistid){
		$.ajax({ url: "./google.php?order=search&artist="+artist+"&album="+albumname+"&albumID="+albumid+"&artistID="+artistid , success: function(data){
            $("#content").html(data);
    }
    });
	}
	
				function googledownload(pic, album, albumID, artist, artistID){
		$.ajax({ url: "./google.php?order=save&url="+pic+"&album="+album+"&albumID="+albumID+"&artist="+artist+"&artistID="+artistID});
		$.ajax({ url: "./title.php?albid="+albumID+"&art="+artist+"&artid="+artistID+"&albname="+album , success: function(data){
            $("#playalbum").html(data);
    }
    });
			getdataalbum(albumID, artist, artistID, album);

	}
	
			function addalbum(order, albumid, artistid){
		$.ajax({ url: "./addplaylist.php?order="+order+"&albumID="+albumid+"&artistID="+artistid});
		$.ajax({ url: "./player.php" , success: function(data){
            $("#playeroben").html(data);
    }
    });
	}
	

	</script>

</head>	
<?php

$artistid = $_REQUEST['artid'];

$artname = $_REQUEST['art'];



$db_link = mysqli_connect ("localhost", "root", "strese84", "musikdatenbank" );



$sql = "SELECT * FROM title WHERE album='$albumid' ORDER BY path";
 
$db_erg = mysqli_query( $db_link, $sql );
if ( ! $db_erg )
{
  die('Ungültige Abfrage: ' . mysqli_error());
}
    ?>
 <br>
<div id="content" style="
padding-left: 40px;
width: 50%;
min-height: 200px;
left: 320px;
top: 8px;
display:inline-block;
-webkit-box-shadow:0 6px 6px 0 rgba(0,0,0,0.3);
box-shadow:0 2px 6px 0 rgba(0,0,0,0.3);
background:#fff;
padding:20px;
margin:0 0 20px 12px;
position:fixed;
 overflow : auto; ">

 <?php
 $rest = $artname{0};
$titlecheck = "$artname - $albname";
$titlecheck2 = mb_strlen($titlecheck);

 if($titlecheck2>="10") {
 $titlecheck3 = "font-size:1.5em;";
 }
 if($titlecheck2>="38") {
 $titlecheck3 = "font-size:1.2em;";
 }
  if($titlecheck2>="60") {
 $titlecheck3 = "font-size:1em;";
 }
 ?>
<a style="position: absolute; top: 176px; right: 18px; font-size:0.7em;" href='#<?php echo $rest; ?>' onclick="google('<?php echo $artname; ?>', '<?php echo $albname; ?>', '<?php echo $albumid; ?>', '<?php echo $artistid; ?>')">Google-Coversuche</a>

	<h1 style="position: absolute; top: -6px; left: 20px;"><a style="color:blue; <?php echo $titlecheck3; ?>" href='#<?php echo $rest; ?>' onclick="getdata('<?php echo $artistid; ?>', '<?php echo $artname; ?>', '<?php echo $artistid; ?>')">[<?php echo $artname; ?>]</a>
  
  <?php

echo "<a style='$titlecheck3'> - $albname</a></h1><br>";

echo '<table border="0">';
while ($zeile = mysqli_fetch_array( $db_erg, MYSQL_ASSOC))
{
$path=$zeile['path'];
$count++;
if($count<="9") {$count="0$count";}
  echo "<tr>";
  	echo "<td>". $count . " - </td>";
//  	echo "<td width='253px'>". $zeile['name'] . " [". $zeile['duration'] . "]</td>";
//	echo "<td>". $zeile['duration'] . "</td>";
//	echo "<td><audio controls preload='none'><source src='mp3.php?id=".$zeile['path']."' type='audio/mp3' /><p>Dieser Browser unterstützt HTML5 Video nicht</p></audio></td>";
?> <td width='350px'><a href='#<?php echo $rest; ?>' onclick="addalbum('playtitle', '<?php echo $zeile['id']; ?>', '<?php echo $artname; ?>')"><?php echo $zeile['name']; ?></a></td><td>[<?php echo$zeile['duration'];?>]</a></td> 

<?php
	echo "</tr>";


}
?></tr><td></td><td width='253px'><a href='#<?php echo $rest; ?>' onclick="addalbum('addalbum', '<?php echo $albumid; ?>', '<?php echo $artname; ?>')">Album hinzufügen</a></td><tr><?php
echo "</table>";


?><div id="covertest">
<span class="crest" style="background: url('./get.php?picid=<?php echo $albumid; ?>&size=big') no-repeat 0 0;"></span> 
</div></div>
<?php
mysqli_free_result( $db_erg );






/*
<br><br><br>
<form method="post" name="upload" id="upload" action="./coverup.php" enctype="multipart/form-data">
<input type="file" id="img" name="img" size="40" accept="image/jpeg">
<input type="hidden" id ="albumID" name="albumID" value="<?php echo $albumid; ?>">
<input type="submit" value="Ändern">
</form>
*/
?>
