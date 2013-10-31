<?php
	require_once('config.inc.php');
	mysql_connect(DBHOST, DBUSER,DBPASS) OR DIE ("NICHT Erlaubt");
	mysql_select_db(DBDATABASE) or die ("Die Datenbank existiert nicht.");
	mysql_query("SET NAMES 'utf8'");
	
	$result = mysql_query("SELECT * FROM artist WHERE name LIKE '%" . $_GET['search'] . "%' LIMIT 5");
	while($row = mysql_fetch_object($result))
	{
		echo '
';
		$alpha = $row->name;
		?> <a href='#dhfig' onclick="getdata('<?php echo $row->id; ?>', '<?php echo $row->name; ?>')"><?php echo $row->name; ?></a><br> <?php
	//	echo "<a style='font-size:0.7em;' href='artist.php?order=newcover&coverid=".$row->id."&covername=".$row->name."'>".$row->name."</a><br>";
		echo '
';
	}

?>