<?php
if($_COOKIE['loggedIn']) {
	echo "<meta http-equiv='refresh' content='0; URL=artist.php'>";
		exit;
}
if($_REQUEST ['order']=="login") {

	require_once('config.inc.php');
	mysql_connect(DBHOST, DBUSER,DBPASS) OR DIE ("NICHT Erlaubt");
	mysql_select_db(DBDATABASE) or die ("Die Datenbank existiert nicht.");
	
	$name = $_POST["name"]; 
	$password = $_POST["password"]; 
	$password = md5($password);
	$abfrage = mysql_query("SELECT id FROM login WHERE name LIKE '$name'");
	$ergebnis = mysql_query($abfrage); 
	$row = mysql_fetch_object($ergebnis);
	if($row->password == $password)
		{ 
		echo "Login fehlgeschlagen";
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
	<center><img src='os_logo.jpg' width='70%'></center>
</div>
<div>Bitte enloggen<br>
  <form action="login.php" method="post">
   Username: <input type="text" name="name" /><br />
   Passwort: <input type="password" name="password" /><br />
   <input type="hidden" name="order" value="login"/><br />
   <input type="submit" value="Anmelden" />
  </form>
</div>