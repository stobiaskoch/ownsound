<?php
	require_once('config.inc.php');
	mysql_connect(DBHOST, DBUSER,DBPASS) OR DIE ("NICHT Erlaubt");
	mysql_select_db(DBDATABASE) or die ("Die Datenbank existiert nicht.");
	mysql_query("SET NAMES 'utf8'");
	include('./js/functions.php');
	
	$result = mysql_query("SELECT * FROM artist WHERE name LIKE '%" . $_GET['search'] . "%' LIMIT 5");
	while($row = mysql_fetch_object($result))
	{
		echo '';
		$trackcount = trackcount($row->id);
		if($trackcount>=1) {
		?> 
		<a style="font-size: 12px;" href='#OwnSound' onclick="getdata('<?php echo $row->id; ?>')"><?php echo $row->name; ?> [Artist]</a><br>
		<?php
		}
		echo '';
	}
echo '<br>';
	
	$result = mysql_query("SELECT * FROM album WHERE name LIKE '%" . $_GET['search'] . "%' LIMIT 5");
	while($row = mysql_fetch_object($result))
	{
		echo '';
		?>
		<a style="font-size: 12px;" href='#OwnSound' onclick="
										getdataalbum('<?php echo $row->id; ?>', '<?php echo $row->artist; ?>');
										getdata('<?php echo $row->artist; ?>');">
										<?php echo getartist($row->artist)." - ". $row->name; ?> [Album]</a><br>
		<?php
		echo '';
	}
mysql_close();
?>