<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//DE" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<link id="favicon" rel="icon" type="image/png" href="./img/os_icon2.png"> 
<head>
	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">

	<script type="text/javascript" src="./js/jquery-1.9.1.js"></script>
	<script type="text/javascript" src="./js/jquery-ui-1.10.3.custom.js"></script>
	<script type="text/javascript" src="./js/ownsound.js"></script>
	<script src="./js/jquery.ui.core.js"></script>
	<script src="./js/jquery.ui.widget.js"></script>
	<script src="./js/jquery.ui.mouse.js"></script>
	<script src="./js/jquery.ui.draggable.js"></script>

<style type="text/css" title="currentStyle">
	@import "./test.css";
</style>
<script>
	  	$(function() {
		$( "#player" ).draggable({ 
			stop: function (event, ui) {
				createCookie("palletteX", ui.position.left, 100);
				createCookie("palletteY", ui.position.top, 100);
     }



		});
		$('#player').css({
'top': readCookie("palletteX"),
'left': readCookie("palletteY"),
'position': 'relative'
});
	});
	




	</script>
</head>	
<?php

if(!$_COOKIE['loggedIn']) {
echo "<meta http-equiv='refresh' content='0; URL=index.php'>";
die();
}

require_once('config.inc.php');
include('./js/functions.php');

$alphabet = range('A', 'Z');
$zahlen = range('0', '9');

?><div id="navigation"><?php

 echo "<a name='kapitel1' href='#numbers'># </a>";
 
foreach($alphabet as $alpha) {

	echo "<a name='kapitel1' href='#".$alpha."'> $alpha </a>";

	} 
?>
 | <a href='#ownsound' onclick="settings()"> Einstellungen </a> | <a href='index.php?order=logout'>Logout</a>

 
</div>
<div id='artistlist'>
<a id='numbers'></a># :
<table border='0'>
 <?php
$db_link = mysqli_connect (DBHOST, DBUSER, DBPASS, DBDATABASE );

foreach($zahlen as $alphazahlen) {
$sql = "SELECT * FROM artist WHERE name LIKE '".$alphazahlen."%'";

$db_erg = mysqli_query( $db_link, $sql );
if ( ! $db_erg )
{
  die('Ung�ltige Abfrage: ' . mysqli_error());
}

	while ($zeile = mysqli_fetch_array( $db_erg, MYSQL_ASSOC))
	{
		$checkartistid = $zeile['id'];
		mysql_connect(DBHOST, DBUSER,DBPASS);
		mysql_select_db(DBDATABASE) or die ("Die Datenbank existiert nicht.");
		$tracksql = mysql_query("SELECT * FROM title WHERE artist='$checkartistid'"); 
		$trackcount = mysql_num_rows($tracksql);
			if($trackcount>=1) {

			?>
				<tr>
					<td><a href='#ownsound' onclick="getdata('<?php echo $zeile['id']; ?>')"><?php echo getartist($checkartistid); ?></a></td>
				</tr>
			<?php
			}

		 
	}


}

echo "</table></div><br>";



foreach($alphabet as $alpha) {
$sql = "SELECT * FROM artist WHERE name like '".$alpha."%'";

$db_erg = mysqli_query( $db_link, $sql );
if ( ! $db_erg )
{
  die('Ung�ltige Abfrage: ' . mysqli_error());
}
echo "<div id='artistlist' style='position:relative;'>";
echo "<a id='$alpha' style='position:absolute; top:-8px;visibility: hidden;'></a>$alpha :";
echo "<table border='0'>";
	while ($zeile = mysqli_fetch_array( $db_erg, MYSQL_ASSOC))
	{
		$checkartistid = $zeile['id'];
		mysql_connect(DBHOST, DBUSER,DBPASS);
		mysql_select_db(DBDATABASE) or die ("Die Datenbank existiert nicht.");
		$tracksql = mysql_query("SELECT * FROM title WHERE artist='$checkartistid'"); 
		$trackcount = mysql_num_rows($tracksql);
			if($trackcount>=1) {
			?>
				<tr>
					<td><a href='#ownsound' onclick="getdata('<?php echo $zeile['id']; ?>')"><?php echo getartist($checkartistid); ?></a></td>
				</tr>
			<?php
			}
		 
	}
echo "</table></div><br>";
}

mysqli_free_result( $db_erg );
?>
<div id="play" style="position:fixed; bottom: 8px; left:480px; overflow : auto; "></div>

<script language="JavaScript">
stats();
player();
playlist();
</script>

 <div id="statistics">
	Datenbankstatistik
	<div id="stats" style="font-size:0.6em;">
	</div>
</div>

<div id="searchartist">K�nstlersuche
		<form id="search2" name="search2" action="search.php">
			<input type="text" size="25" id="search" name="search" autocomplete="off"  onblur="reset(search.value)"/>
		</form>
	<div id="results" style="z-index:2;" >
	</div>
</div>
	
	
<div id="playerdiv">
	<a href='#owncloud' onclick="addalbum('random', '0', '0')"><img src='./img/shuffle.png' width="5%" title="Shuffle"></a>
	<a href='#owncloud' onclick="addalbum('truncate', '0', '0')"><img src='./img/truncate.jpg' width="5%" title="Playlist leeren"></a>
	<div id="playlist" style="font-size:0.6em;"></div>
</div>
	
	
	

<div id="infooben">
	<div id="information"><center><img src='./img/os_logo_smaller.JPG'></center></div>
	<div style="font-size: 12px; top: 260px; left: 868px; position:fixed;"><a href='https://github.com/stobiaskoch/ownsound'><img src='./img/git.gif'></a></div>

</div>

<div id="player" style="font-size:0.6em;"></div>




	<title>OwnSound</title>

<?php

if ( ! isset ( $_COOKIE['lastalbum'] ) )
{
?>

<script language="JavaScript">
getdata('<?php echo $_COOKIE['lastartist']; ?>');
</script>
<?php
}
else
{

?>
<script language="JavaScript">
getdataalbum('<?php echo $_COOKIE['lastalbum']; ?>', '<?php echo $_COOKIE['lastartist']; ?>');
</script>
<?php










}
?>