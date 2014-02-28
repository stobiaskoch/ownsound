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
	$ergebnis = mysql_query("SELECT * FROM user WHERE BINARY name='$name'"); 
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

	<script type="text/javascript" src="./js/jquery-1.9.1.min.js"></script>
	<script type="text/javascript" src="./js/ownsound.js"></script>
<script>
createCookie("screenwidth", screen.width , 100);
createCookie("screenheight", screen.height, 100);

function signinCallback(authResult) {
  if (authResult['status']['signed_in']) {
    // Update the app to reflect a signed in user
    // Hide the sign-in button now that the user is authorized, for example:
    alert('eingeloggt');
  } else {
    // Update the app to reflect a signed out user
    // Possible error values:
    //   "user_signed_out" - User is signed-out
    //   "access_denied" - User denied access to your app
    //   "immediate_failed" - Could not automatically log in the user
    alert('nix');
  }
}

</script>
<style type="text/css" title="currentStyle">
	@import "./css/ownsound.css";
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
   <!-- Place this asynchronous JavaScript just before your </body> tag -->
    <script type="text/javascript">
      (function() {
       var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
       po.src = 'https://apis.google.com/js/client:plusone.js';
       var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
     })();
    </script>
	<span id="signinButton">
  <span
    class="g-signin"
    data-callback="signinCallback"
    data-clientid="933799514099-osjm9s7n3nnj4nk7crg9bpp2ph8jv6f2.apps.googleusercontent.com"
    data-cookiepolicy="http://wittgenstein.homeserver.com"
    data-requestvisibleactions="http://schemas.google.com/AddActivity"
    data-scope="https://www.googleapis.com/auth/plus.login">
  </span>
</span>