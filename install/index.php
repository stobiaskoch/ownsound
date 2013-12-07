<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//DE" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<link id="favicon" rel="icon" type="image/png" href="./img/os_icon2.png"> 
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">

	<script type="text/javascript" src="../js/jquery-1.9.1.min.js"></script>
	<script type="text/javascript" src="../js/ownsound.js"></script>
<script>

	function nextstep(order, albumid, artistid){
		$.ajax({ url: "./index.php?step="+order , 
			success: function(data){
					$("#install").html(data);
			}	
		});
	}
</script>
<style type="text/css" title="currentStyle">
	@import "../css/ownsound.css";
</style>
</head>		
<center>
<div id="install">

<div id="login">
	<center><img src='../img/os_logo_small.jpg' width='70%'></center>
</div>


<?php 
if($_REQUEST['step']==1 or $_REQUEST['step']=="") {
?>
<fieldset style="width: 45%;">
		<legend>Installer - Step 1</legend>
		<table>
		<tr><td width="200">Erforderlich:</td><td width="200">Ihr System:</td></tr>
		<tr><td width="200">PHP 5.0</td><td><?php echo phpversion(); ?></td></tr>
		<tr><td>MySQL 5.0</td><td><?php echo mysql_get_client_info(); ?></td></tr>
		</table>
		<br>
		<button onclick="nextstep('2');">Weiter</button>
</fieldset>
<?php
}
?>
<?php 
if($_REQUEST['step']==2) {
?>
<fieldset style="width: 45%;">
		<legend>Installer - Step 2</legend>
		Benutzereinstellungen
		<table border="0">
		<tr><td width="200">Adresse:</td><td width="200"><input type="text" name="adress" value="localhost"></td></tr>
		<tr><td width="200">Benutzername:</td><td width="200"><input type="text" name="username"></td></tr>
		<tr><td width="200">Passwort:</td><td width="200"><input type="password" name="password"></td></tr>
		<tr><td width="200">Datenbankname:</td><td width="200"><input type="text" name="dbname" value="ownsound"/></td></tr>
		</table>
		<br>
		<table>
		<tr><td width="200">Musikordner:</td><td width="200"><input type="text" name="musicdir" value="/mnt/"></td></tr>
		</table>
		<button onclick="nextstep('1');">Zurück</button><button onclick="nextstep('3');">Weiter</button>
</fieldset>
<?php
}
?>
</div>