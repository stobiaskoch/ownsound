  <form action="createuser.php" method="post">
	Username: <input type="text" name="name" /><br />
	Voller Name: <input type="text" name="fullname" /><br />
	Email: <input type="text" name="email" /><br />
	Passwort: <input type="password" name="passwort" /><br />
	<input type="text" name="order" value="save"/><br />
   <input type="submit" value="speichern" />
  </form>
<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
require_once('config.inc.php');
mysql_connect(DBHOST, DBUSER,DBPASS) OR DIE ("NICHT Erlaubt");
mysql_select_db(DBDATABASE) or die ("Die Datenbank existiert nicht.");

$order=$_REQUEST['order'];

if($order=="save") {
$name=$_REQUEST['name'];
$fullname=$_REQUEST['fullname'];
$email=$_REQUEST['email'];
$password_hash = md5($_REQUEST['password']);
echo $password_hash;

mysql_query("INSERT INTO `user`(`name`, `fullname`, `email`, `password`, `group`) VALUES ('$name', '$fullname', '$email', '$password_hash', 'admin')");

}
//INSERT INTO `user`(`id`, `name`, `fullname`, `email`, `password`, `group`) VALUES ('sebkoch', 'Sebastian Koch', 's.t.koch77@gmail.com', 'blabla', 'admin')
?>
