<html>
<head>
	<style type="text/css">BODY,TD,TH { font-family: sans-serif; font-size: 9pt; }</style>
	<script type="text/javascript" src="jquery-1.9.1.js"></script>
	<script type="text/javascript" src="jquery-ui-1.10.3.custom.js"></script>

	<script>
		function getdata(artid, artname){
		document.getElementById("results").innerHTML="";
		$.ajax({ url: "./album.php?artid="+artid+"&artname="+artname , success: function(data){
            $("#play").html(data);
			
    }
    });
	}
			function getdatanewcover(artid, artname){
		$.ajax({ url: "./album.php?artid="+artid+"&artname="+artname+"#gshd" , success: function(data){
            $("#play").html(data);
			
    }
    });
	}
		function stats(){
		$.ajax({ url: "./databasestats.php" , success: function(data){
            $("#stats").html(data);
    }
    });
	}
	
			function playeroben(){
		$.ajax({ url: "./player.php" , success: function(data){
            $("#playeroben").html(data);
    }
    });
	}


	
$(document).ready(function()
{
	$('#search').keyup(function()
	{
		if($(this).val().length >= 1)
		{
			$.get("rpc.php", {search: $(this).val()}, function(data)
			{
				$("#results").html(data);
			});
		}
	});
});
</script>
<style type="text/css" title="currentStyle">
	@import "./test.css";
</style>
</head>	
<?php
$count=0;
require_once('config.inc.php');
$alphabet = range('A', 'Z');
echo "<div id='navi' style='
 top: 8px;
padding-left: 40px;
width: 250;
display:inline-block;
-webkit-box-shadow:0 2px 6px 0 rgba(0,0,0,0.3);
box-shadow:0 2px 6px 0 rgba(0,0,0,0.3);
background:#fff;
padding:20px;
margin:0 0 20px 12px;
position:fixed; z-index:2;'>";
foreach($alphabet as $alpha) {

 echo "<a name='kapitel1' href='#".$alpha."'> $alpha </a>";
} 
echo "</div><br><br><br><br>";
$db_link = mysqli_connect (DBHOST, DBUSER, DBPASS, DBDATABASE );

foreach($alphabet as $alpha) {
$sql = "SELECT * FROM artist WHERE name like '".$alpha."%'";

$db_erg = mysqli_query( $db_link, $sql );
if ( ! $db_erg )
{
  die('Ungültige Abfrage: ' . mysqli_error());
}

 ?>
 <div style="
  top: 10px;
padding-left: 40px;
width: 250;
display:inline-block;
-webkit-box-shadow:0 2px 6px 0 rgba(0,0,0,0.3);
box-shadow:0 2px 6px 0 rgba(0,0,0,0.3);
background:#fff;
padding:20px;
margin:0 0 20px 12px;
position:relative;">
<?php
 echo "<h3><span id='$alpha'></span></h3>$alpha :";
echo "<table border='0'>";
while ($zeile = mysqli_fetch_array( $db_erg, MYSQL_ASSOC))
{

$count++;
  echo "<tr>";
  ?>
	<td><a href='#<?php echo $alpha; ?>' onclick="getdata('<?php echo $zeile['id']; ?>', '<?php echo $zeile['name']; ?>')"><?php echo $zeile['name']; ?></a></td>
  <?php
  echo "</tr>";
 
}
echo "</table></div><br>";
  
 }


mysqli_free_result( $db_erg );
?>
<div id="play" style="position:fixed; bottom: 8px; left:480px; overflow : auto; "></div></div>

<?php
if($_REQUEST['order']=="newcover") { 
$coverid = $_REQUEST['coverid'];
$covername = $_REQUEST['covername'];

?>
<script language="JavaScript">
getdatanewcover('<?php echo $coverid; ?>', '<?php echo $covername ?>');
playeroben();
</script>
<?php } ?>
<script language="JavaScript">
stats();

</script>
 <div style="
 right:10px;
 top:8px;
 min-height: 74px;
padding-left: 40px;
width: 14%;
display:inline-block;
-webkit-box-shadow:0 2px 6px 0 rgba(0,0,0,0.3);
box-shadow:0 2px 6px 0 rgba(0,0,0,0.3);
background:#fff;
padding:20px;
margin:0 0 20px 12px;
position:fixed;">
Datenbankstatistik
<div id="stats" style="font-size:0.6em;"></div></div></div>




	<div id="div-1a" style="
 right:10px;
 top:130px;
padding-left: 40px;
width: 14%;
 min-height: 72px;
display:inline-block;
-webkit-box-shadow:0 2px 6px 0 rgba(0,0,0,0.3);
box-shadow:0 2px 6px 0 rgba(0,0,0,0.3);
background:#fff;
padding:20px;
margin:0 0 20px 12px;
position:fixed;
z-index:2;">Künstlersuche
	
	<form id="search2" name="search2" action="search.php">
		<input type="text" size="25" id="search" name="search" autocomplete="off"  onblur="reset(this.value)"/>
	</form>
	<div id="results" style="z-index:2;" ></div></div>
	 <div style="
 right:10px;
 top:250px;
padding-left: 40px;
width: 14%;
display:inline-block;
-webkit-box-shadow:0 2px 6px 0 rgba(0,0,0,0.3);
box-shadow:0 2px 6px 0 rgba(0,0,0,0.3);
background:#fff;
padding:20px;
margin:0 0 20px 12px;
position:fixed;">
<div id="playeroben" style="font-size:0.6em;"></div></div></div>


<div style="
padding-left: 40px;
width: 50%;
left: 320px;
min-height: 200px;
top: 8px;
display:none;
-webkit-box-shadow:0 6px 6px 0 rgba(0,0,0,0.3);
box-shadow:0 2px 6px 0 rgba(0,0,0,0.3);
background:#fff;
padding:20px;
margin:0 0 20px 12px;
position:fixed;
"><div id="information" style="font-size:0.6em;"><center><img src='http://api.discogs.com/image/A-18839-1376591828-3354.jpeg' width='auto'></center></div></div></div>
