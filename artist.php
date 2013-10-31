<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">

	<script type="text/javascript" src="jquery-1.9.1.js"></script>
	<script type="text/javascript" src="jquery-ui-1.10.3.custom.js"></script>
	<script type="text/javascript" src="jquery.contextmenu.js"></script>

	<script>
	
	
$(document).ready(function() {
	$('#search').keyup(function() {
		if($(this).val().length >= 1) {
			$.get("rpc.php", {search: $(this).val()}, function(data) {
				$("#results").html(data);
			});
		}
	});
});
	
	
	
	function getdata(artid, artname){
		document.getElementById("results").innerHTML="";
		$.ajax({ url: "./album.php?artid="+artid+"&artname="+artname , success: function(data){
            $("#play").html(data);		
			}
		});
	}
	function nocover(artid, artname){
		document.getElementById("results").innerHTML="";
		$.ajax({ url: "./nocover.php" , success: function(data){
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

	function sleep(milliseconds) {
		  var start = new Date().getTime();
		  for (var i = 0; i < 1e7; i++) {
			if ((new Date().getTime() - start) > milliseconds){
			  break;
			}
		  }
	}

</script>
<style type="text/css" title="currentStyle">
	@import "./test.css";
</style>
</head>	
<?php
if(!$_COOKIE['loggedIn']) {
echo "<meta http-equiv='refresh' content='0; URL=login.php'>";
die();
}
require_once('config.inc.php');
$alphabet = range('A', 'Z');
?><div id="navigation"><?php
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
  die('UngÃ¼ltige Abfrage: ' . mysqli_error());
}

 ?>
 <div id="artistlist">
<?php
 echo "<h3><span id='$alpha'></span></h3>$alpha :";
echo "<table border='0'>";
while ($zeile = mysqli_fetch_array( $db_erg, MYSQL_ASSOC))
{


  echo "<tr>";
  ?>

	<td><a href='#ownsound' onclick="getdata('<?php echo $zeile['id']; ?>', '<?php echo addslashes($zeile['name']); ?>')"><?php echo $zeile['name']; ?></a></td>
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
playeroben();
</script>

 <div id="statistics">
	Datenbankstatistik
	<div id="stats" style="font-size:0.6em;">
	</div>
</div>

<div id="searchartist"">Künstlersuche
	<form id="search2" name="search2" action="search.php">
		<input type="text" size="25" id="search" name="search" autocomplete="off"  onblur="reset(this.value)"/>
	</form>
	<div id="results" style="z-index:2;" >
	</div>
</div>
	
	
<div id="playerdiv">
	<div id="playeroben" style="font-size:0.6em;">
	</div>
</div>


<div id="infooben">
	<div id="information" style="font-size:0.6em;"><center><img src='os_logo.jpg' width='70%'></center>
	</div>
</div>
	<link id="favicon" rel="icon" type="image/png" href="os_logo.jpg" /> 

