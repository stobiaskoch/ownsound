<?php
if($_REQUEST ['order']=="logout") {
	$name = $_COOKIE['loggedIn']; 
	setcookie ("loggedIn", $name, time() - 3600);
}

if($_COOKIE['loggedIn']) {
	echo "<meta http-equiv='refresh' content='0; URL=artist.php'>";
		exit;
}

if($_REQUEST ['order']=="login") {
	require_once('config.inc.php');
	mysql_connect(DBHOST, DBUSER,DBPASS) OR DIE ("NICHT Erlaubt");
	mysql_select_db(DBDATABASE) or die ("Die Datenbank existiert nicht.");
	$name = $_POST["name"]; 
	$password = md5($_POST["password"]);
	$ergebnis = mysql_query("SELECT * FROM user WHERE name='$name'"); 
	$row = mysql_fetch_object($ergebnis);
	if($row->password != $password)
		{ 
		echo "<center>Login fehlgeschlagen</center>";
		echo "<meta http-equiv='refresh' content='3; URL=index.php'>";
		die();
		}
	else
		{
		$yearExpire = time() + 60*60*24*365; // 1 Year
		setcookie('loggedIn', $name, $yearExpire);
		echo "<meta http-equiv='refresh' content='0; URL=artist.php'>";
		}

}	
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<style type="text/css" title="currentStyle">
	@import "./test.css";
</style>
</head>	
<center>
<div id="login">
	<center><img src='./img/os_logo_small.jpg' width='70%'></center>
</div>
<fieldset style="width: 300px;">
		<legend style="margin-right: 240px;">Login</legend>
			<table>
			<tr>
				<form action="index.php" method="post">
				<td>Username</td><td><input type="text" name="name" size="20"/></td>
				</tr><td>Passwort</td><td><input type="password" name="password" size="20"/></td>
			<tr>
				<input type="hidden" name="order" value="login"/>

				<td><input type="submit" value="Anmelden" /></td>
				</form>
			</tr>
			</table>
	</fieldset>