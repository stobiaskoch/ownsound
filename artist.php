<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//DE" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<link id="favicon" rel="icon" type="image/png" href="./img/os_icon2.png"> 
<head>
	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">

	<script type="text/javascript" src="./js/jquery-1.9.1.js"></script>
	<script type="text/javascript" src="./js/jquery-ui-1.10.3.custom.js"></script>
	<script type="text/javascript" src="./js/ownsound.js"></script>

<style type="text/css" title="currentStyle">
	@import "./test.css";
</style>
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
 <?php
echo "</div><br>";

$db_link = mysqli_connect (DBHOST, DBUSER, DBPASS, DBDATABASE );

echo "<div id='artistlist'>";
echo "<h3><span id='numbers'></span></h3># :";
echo "<table border='0'>";
foreach($zahlen as $alphazaheln) {
$sql = "SELECT * FROM artist WHERE name LIKE '".$alphazaheln."%'";

$db_erg = mysqli_query( $db_link, $sql );
if ( ! $db_erg )
{
  die('Ungültige Abfrage: ' . mysqli_error());
}

while ($zeile = mysqli_fetch_array( $db_erg, MYSQL_ASSOC))
{
	$checkartistid = $zeile['id'];
	mysql_connect(DBHOST, DBUSER,DBPASS);
	mysql_select_db(DBDATABASE) or die ("Die Datenbank existiert nicht.");
	$tracksql = mysql_query("SELECT * FROM title WHERE artist='$checkartistid'"); 
	$trackcount = mysql_num_rows($tracksql);
	  if($trackcount>=1) {
	  echo "<tr>";
	  ?>
		<td><a href='#ownsound' onclick="getdata('<?php echo $zeile['id']; ?>')"><?php getartist($checkartistid); ?></a></td>
	  <?php
		
	  echo "</tr>";
	}
	 
}


 }

echo "</table></div><br>";



foreach($alphabet as $alpha) {
$sql = "SELECT * FROM artist WHERE name like '".$alpha."%'";

$db_erg = mysqli_query( $db_link, $sql );
if ( ! $db_erg )
{
  die('Ungültige Abfrage: ' . mysqli_error());
}
echo "<div id='artistlist'>";
echo "<h3><span id='$alpha'></span></h3>$alpha :";
echo "<table border='0'>";
while ($zeile = mysqli_fetch_array( $db_erg, MYSQL_ASSOC))
{
	$checkartistid = $zeile['id'];
	mysql_connect(DBHOST, DBUSER,DBPASS);
	mysql_select_db(DBDATABASE) or die ("Die Datenbank existiert nicht.");
	$tracksql = mysql_query("SELECT * FROM title WHERE artist='$checkartistid'"); 
	$trackcount = mysql_num_rows($tracksql);
	  if($trackcount>=1) {
	  echo "<tr>";
	  ?>
		<td><a href='#ownsound' onclick="getdata('<?php echo $zeile['id']; ?>')"><?php getartist($checkartistid); ?></a></td>
	  <?php
		
	  echo "</tr>";
	}
	 
}
echo "</table></div><br>";

 }


mysqli_free_result( $db_erg );
?>
<div id="play" style="position:fixed; bottom: 8px; left:480px; overflow : auto; "></div></div>

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
		<input type="text" size="25" id="search" name="search" autocomplete="off"  onblur="reset(search.value)"/>
	</form>
	<div id="results" style="z-index:2;" >
	</div>
</div>
	
	
<div id="playerdiv">
<a href='#dhfig' onclick="addalbum('random', '0', '0')"><img src='./img/shuffle.png' width="5%"></a>
	<div id="playeroben" style="font-size:0.6em;">
	</div>
</div>


<div id="infooben">
	<div id="information"<center><img src='./img/os_logo_smaller.JPG'></center>
	</div>
</div>
	<title>OwnSound</title>
