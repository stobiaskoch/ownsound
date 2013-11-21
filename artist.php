<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//DE" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<link id="favicon" rel="icon" type="image/png" href="./img/os_icon2.png"> 
	<title>OwnSound</title>
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<script type="text/javascript" src="./js/jquery-1.9.1.js"></script>
	<script type="text/javascript" src="./js/ownsound.js"></script>
	<script src="./js/jquery.mmenu.js"></script>
	<script src="./js/jquery.contextMenu.js"></script> 
	<script src="./js/jquery.form.js"></script> 
	<script src="./js/jquery.jeditable.js"></script> 
	<script src="./js/jquery.loadmask.min.js"></script> 
	<script src="./js/popup.js"></script> 
	<link type="text/css" rel="stylesheet" href="./js/jquery.mmenu.all.css" />
	<link type="text/css" rel="stylesheet" href="./js/demo.css" />
	<link rel="stylesheet" href="./js/jquery.flipster.css">
	<script src="./js/jquery.flipster.js"></script>
	<script src="./js/jquery.hashchange.min.js" type="text/javascript"></script>
<script src="./js/jquery.easytabs.min.js" type="text/javascript"></script>
	<style type="text/css">
			#page
			{
				padding-top: 40px;
			}
			#menu
			{
				padding-top: 30px;
			}
			#header
			{
				position: fixed;
				left: 0;
				top: 0;
				width: 100%;
				
				-webkit-box-sizing: border-box;
				-moz-box-sizing: border-box;
				box-sizing: border-box;
			}
			#mmenu-blocker
			{
				opacity: 0;
			}
		</style>
	
<script>
createCookie("screenwidth", screen.width , 100);
createCookie("screenheight", screen.height, 100);
// Muss bei install gesetzt werden
//createCookie("notifications", 'yes' , 100);
			$(function() {
				$('nav#menu').mmenu();
			});
</script>
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
$checkuser = $_COOKIE['loggedIn'];
$db_link = mysqli_connect (DBHOST, DBUSER, DBPASS, DBDATABASE );
$sql = "SELECT name FROM user WHERE name = '$checkuser'";

$db_erg = mysqli_query( $db_link, $sql );

$zeile = mysqli_fetch_array( $db_erg, MYSQL_ASSOC);


if ( ! $zeile['name'] )
			{
				die('Ungültiger User');
			}










include('./js/functions.php');

$alphabet = range('A', 'Z');
$zahlen = range('0', '9');

?>
<div id="navigation">
<form id="search2" name="search2" action="search.php">
	<?php

	 echo "<a name='kapitel1' href='#numbers'># </a>";
	 
	foreach($alphabet as $alpha) {

		echo "<a name='kapitel1' href='#".$alpha."'> $alpha </a>";

		} 
	?>
	 | <a href="#" class="popup_oeffnen">Settings</a> | <a href='index.php?order=logout'>Logout</a><div id="searchbar" style="float: right;"><input type="text" size="25" id="search" name="search" autocomplete="off"  onblur="reset(search.value)"/>
		</form><img src="./img/lupe_icon.gif"><div id="results" style="z-index:1000;"></div></div>
	

	 
</div>
<div id="page">
			<div id="header">
				<a href="#menu"></a>
			</div>

			<nav style="position:relative;" id="menu">
<!-- Your content -->
<ul>




	<li><a id='numbers'># :</a></li>
		 <?php
		

		foreach($zahlen as $alphazahlen) {
		//	$sql = "SELECT * FROM artist WHERE name LIKE '".$alphazahlen."%'";
			$sql = "SELECT * FROM artist  WHERE navname like '".$alphazahlen."%' ORDER BY navname";

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
					$tracksql = mysql_query("SELECT * FROM album WHERE artist='$checkartistid'"); 
					$trackcount = mysql_num_rows($tracksql);
						if($trackcount>=1) {

						?>

								<li><a href='#ownsound' onclick="getdata('<?php echo $zeile['id']; ?>')"><?php echo getartist($checkartistid); ?></a></li>

						<?php
						}
				}
		}


foreach($alphabet as $alpha) {
// SELECT `id`, `title` FROM `movies` ORDER BY TRIM(LEADING 'a ' FROM TRIM(LEADING 'an ' FROM TRIM(LEADING 'the ' FROM LOWER(`title`))));
	$sql = "SELECT * FROM artist  WHERE navname like '".$alpha."%' ORDER BY navname";
//	echo $sql;
	$db_erg = mysqli_query( $db_link, $sql );
	if ( ! $db_erg )
	{
		die('Ungültige Abfrage: ' . mysqli_error());
	}

			echo "<li><a id='$alpha'>$alpha :</a></li>";

				while ($zeile = mysqli_fetch_array( $db_erg, MYSQL_ASSOC))
				{
					$checkartistid = $zeile['id'];
					mysql_connect(DBHOST, DBUSER,DBPASS);
					mysql_select_db(DBDATABASE) or die ("Die Datenbank existiert nicht.");
					$tracksql = mysql_query("SELECT * FROM album WHERE artist='$checkartistid'"); 
					$trackcount = mysql_num_rows($tracksql);
						if($trackcount>=1) {
						?>

								<li><a href='#ownsound' onclick="getdata('<?php echo $zeile['id']; ?>')"><?php echo getartist($checkartistid); ?></a></li>

						<?php
						}
				}

}

mysqli_free_result( $db_erg );
?>
				</ul>
			</nav>
		</div>



<script language="JavaScript">
stats();
playlist();
</script>
<div id="artist"></div>
<div id="album2"></div>
<!--
 <div id="statistics">
	Datenbankstatistik
	<div id="stats" style="font-size:0.6em;">
	</div>
</div>

<div id="searchartist">K&uuml;nstlersuche
		<form id="search2" name="search2" action="search.php">
			<input type="text" size="25" id="search" name="search" autocomplete="off"  onblur="reset(search.value)"/>
		</form>
	<div id="results" style="z-index:1000;" >
	</div>
</div>
	--->
<div id="playerdiv">
	<a href='#owncloud' onclick="addalbum('random', '0', '0')"><img src='./img/shuffle.png' width="7%" title="Shuffle"></a>
	<a href='#owncloud' onclick="addalbum('truncate', '0', '0')"><img src='./img/truncate.png' title="Playlist leeren"></a>
	<div id="playlist" style="font-size:0.6em;"></div>
</div>
<!--
<div id="infooben">
	<div id="information"><center><img src='./img/os_logo_smaller.JPG'></center></div><br>
	<a style="position: relative;" href='https://github.com/stobiaskoch/ownsound'><img src='./img/git.gif'></a>
--->
</div>



<?php

$lastartist = $_COOKIE['lastartist'];
$lastalbum = $_COOKIE['lastalbum'];
	?>
	<script language="JavaScript">
	getdata('<?php echo $_COOKIE['lastartist']; ?>');
	getdataalbum('<?php echo $_COOKIE['lastalbum']; ?>', '<?php echo getartistIDfromalbumID($lastalbum); ?>');
	</script>
	<?php

mysql_close();
?>
<iframe name="zip" style="visibility:hidden;display:none" ></iframe>
<iframe name="dbbackup" style="visibility:hidden;display:none" ></iframe>

    <div id="popup">
 
        <div class="schliessen"></div>
 
        <div id="popup_inhalt">
        </div>
 
    </div>
	<div id="hintergrund"></div>