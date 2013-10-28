<?php
$albumid = $_REQUEST['albid'];
$albname = $_REQUEST['albname'];
$artistid = $_REQUEST['artistid'];
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

$rest = $albname{0};


$db_link = mysqli_connect ("localhost", "root", "strese84", "musikdatenbank" );



$sql = "SELECT * FROM title WHERE artist='$artistid' ORDER BY path";
 
$db_erg = mysqli_query( $db_link, $sql );
if ( ! $db_erg )
{
  die('Ungültige Abfrage: ' . mysqli_error());
}
    ?>
 <br><div style="
padding-left: 40px;
width: auto;
display:inline-block;
-webkit-box-shadow:0 2px 6px 0 rgba(0,0,0,0.3);
box-shadow:0 2px 6px 0 rgba(0,0,0,0.3);
background:#fff;
padding:20px;
margin:0 0 20px 12px;
position:relative;">

<div style="
padding-left: 40px;
width: auto;
display:inline-block;
-webkit-box-shadow:0 6px 6px 0 rgba(0,0,0,0.3);
box-shadow:0 2px 6px 0 rgba(0,0,0,0.3);
background:#fff;
padding:20px;
margin:0 0 20px 12px;
position:relative;
 overflow : auto; ">

<?php

echo "$albname</h1><br>";
echo '<br><table border="0">';

while ($zeile = mysqli_fetch_array( $db_erg, MYSQL_ASSOC))
{
$path=$zeile['path'];
$count++;

  echo "<tr>";
  	echo "<td>". $count . "</td>";
  	echo "<td>". $zeile['name'] . "</td>";


	echo "<td>". $zeile['duration'] . "</td>";
	?> <td><a href='#<?php echo $rest; ?>' onclick="addalbum('playtitle', '<?php echo $zeile['id']; ?>', '<?php echo $artname; ?>')">Track hinzufügen</a></td> <?php
	echo "</tr>";



}


echo "</table></div>";

//echo "<div id='cover'><img src='get.php?picid=$albumid' width='200' height='200'></div>";
mysqli_free_result( $db_erg );

?>


