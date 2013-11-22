<?php
if($_REQUEST ['order']=="logout") {
	$name = $_COOKIE['loggedIn']; 
	setcookie ("loggedIn", $name, time() - 3600);
}

if($_COOKIE['loggedIn']) {
	// nur ein test
	// 	mail('s.t.koch77@gmail.com', 'Dein OwnSound-Passwort', 'Vergessen, wa?');
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
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//DE" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<link id="favicon" rel="icon" type="image/png" href="./img/os_icon2.png"> 
<head>
	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">

	<script type="text/javascript" src="./js/jquery-1.9.1.js"></script>
	<script type="text/javascript" src="./js/jquery-ui-1.10.3.custom.js"></script>
	<script type="text/javascript" src="./js/ownsound.js"></script>
<script>
createCookie("screenwidth", screen.width , 100);
createCookie("screenheight", screen.height, 100);
</script>
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
			<a style="font-size: 9px;" href="passreset.php">Passwort vergessen?</a>
	</fieldset>
