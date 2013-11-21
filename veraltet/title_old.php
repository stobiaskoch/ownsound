<?php
//mysql_connect("localhost", "root","strese84");
//mysql_select_db("musikdatenbank") or die ("Die Datenbank existiert nicht.");
$artistid = $_REQUEST['artid'];
$albumid = $_REQUEST['albid'];
echo "<img src='get.php?picid=$albumid' width='100' height='100'>";
$db_link = mysqli_connect ("localhost", "root", "strese84", "musikdatenbank" );



$sql = "SELECT * FROM title WHERE album='$albumid' ORDER BY path";
 
$db_erg = mysqli_query( $db_link, $sql );
if ( ! $db_erg )
{
  die('Ungültige Abfrage: ' . mysqli_error());
}
 
echo '<table border="1">';
while ($zeile = mysqli_fetch_array( $db_erg, MYSQL_ASSOC))
{
$count++;
  echo "<tr>";
  echo "<td>". $count . "</td>";
  echo "<td>". $zeile['name'] . "</td>";
	echo "<td>". $zeile['duration'] . "</td>";

  echo "</tr>";
}
echo "</table>";
 
mysqli_free_result( $db_erg );
echo "<a href='artist.php'>zurück</a>";
?>