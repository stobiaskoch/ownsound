<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//DE" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<link id="favicon" rel="icon" type="image/png" href="./img/os_icon2.png"> 
	<title>OwnSound</title>
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<script type="text/javascript" src="./js/jquery-1.9.1.min.js"></script>
	<script type="text/javascript" src="./js/ownsound.js"></script>
	<script src="./js/jquery.mmenu.min.all.js"></script>
	<script src="./js/jquery.loadmask.min.js"></script> 
	<script src="./js/popup.js"></script> 
	<link type="text/css" rel="stylesheet" href="./css/jquery.mmenu.all.css" />
	<link type="text/css" rel="stylesheet" href="./css/demo.css" />
	<link type="text/css" rel="stylesheet" href="./css/ownsound.css" />
	<link href="./css/jplayer/jplayer.midnight.black.css" rel="stylesheet" type="text/css" /> 
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

			$(function() {
				$('nav#menu').mmenu();
			});

</script>
</head>	
<?php

require_once('config.inc.php');
include('./js/functions.php');

logincheck();

$db_link = mysqli_connect (DBHOST, DBUSER, DBPASS, DBDATABASE );




$alphabet = range('A', 'Z');
$zahlen = range('0', '9');

?>

<div id="navigation" style="z-index: 1005; font-size: 14px;">
<form id="search2" name="search2" action="rpc.php">
<a name="kapitel1" class="#menu" href="#numbers"># </a>

	<?php
	foreach($alphabet as $alpha) {
		echo "<a name='kapitel1' href='#".$alpha."'> $alpha </a>";
	} 
	?>
	
| <a href="#" class="popup_oeffnen">Einstellungen</a> | <a href='#OwnSound' onclick="getdata('lastten');">Neue Alben</a> | <a href='index.php?order=logout' onclick="return confirm('Wirklich ausloggen?');">Logout</a><div id="searchbar" style="float: right;"><input type="text" size="25" id="search" name="search" autocomplete="off"  onblur="reset(search.value);"/>
</form><img src="./img/lupe_icon.gif"></div><div id="results" style="z-index:1005;"></div>
</div>
<div id="page">
			<div id="header" style="z-index: 2;">
				<a href="#menu"></a>
			</div>

			<nav style="position:relative;" id="menu">

<ul>



	<li>Place </li>
	<li><a id='numbers'># :</a></li>
		 <?php
		

foreach($zahlen as $alphazahlen) {
		$sql = "SELECT * FROM artist WHERE navname like '".$alphazahlen."%' ORDER BY navname";

			$db_erg = mysqli_query( $db_link, $sql );
			if ( ! $db_erg )
			{
				die('Ungültige Abfrage: ' . mysqli_error());
			}

				while ($zeile = mysqli_fetch_array( $db_erg, MYSQL_ASSOC))
				{
					$trackcount = trackcount($zeile['id']);
						if($trackcount>=1) {
						if($zeile['fav']=="1") {$icon = "./img/favyes.png";} else {$icon = "";}
						?>

							<li><a href='#OwnSound' onclick="getdata('<?php echo $zeile['id']; ?>')"><?php echo getartist($zeile['id']); ?> <img type="float: right;" src="<?php echo $icon; ?>" width="3%"></a></li>

						<?php
						}
				}
		}


foreach($alphabet as $alpha) {

	$sql = "SELECT * FROM artist  WHERE navname like '".$alpha."%' ORDER BY navname";
	$db_erg = mysqli_query( $db_link, $sql );
	if ( ! $db_erg )
	{
		die('Ungültige Abfrage: ' . mysqli_error());
	}

			echo "<li><a id='$alpha'>$alpha :</a></li>";

				while ($zeile = mysqli_fetch_array( $db_erg, MYSQL_ASSOC))
				{
						$trackcount = trackcount($zeile['id']);
						if($trackcount>=1) {
						if($zeile['fav']=="1") {$icon = "./img/favyes.png";} else {$icon = "";}
						?>
								<li><a href='#OwnSound' onclick="getdata('<?php echo $zeile['id']; ?>')"><?php echo getartist($zeile['id']); ?> <img type="float: right;" src="<?php echo $icon; ?>" width="3%"></a></li>
						<?php
						}
				}

}

mysqli_free_result( $db_erg );
?>
				</ul>
			</nav>
		</div>

<div id="artist" style="opacity:0.8;"></div>
<div id="album2" style="opacity:0.8;"></div>

<div id="playerdiv">
	<a href='#OwnCloud' onclick="addalbum('random', '0', '0')"><img src='./img/shuffle.png' width="7%" title="Shuffle"></a>
	<a href='#OwnCloud' onclick="addalbum('truncate', '0', '0')"><img src='./img/truncate.png' title="Playlist leeren"></a>
	<div id="playlist" style="font-size:0.6em;"></div>
</div>
<?php

$lastartist = $_COOKIE['lastartist'];
$lastalbum = $_COOKIE['lastalbum'];
	?>
	<script language="JavaScript">
	getdata('<?php echo $_COOKIE['lastartist']; ?>');
	getdataalbum('<?php echo $_COOKIE['lastalbum']; ?>', '<?php echo getartistIDfromalbumID($lastalbum); ?>');
	playlist();
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
		<div id="hintergrund2" style="
    width:250%; 
    height: 500px; 
	top: 30px;
    left: 0px; 
	position: fixed;
    z-index: -2;
	"></div>
	