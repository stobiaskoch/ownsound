<?php
	mysql_connect("localhost","root","strese84") or die ("Keine Verbindung moeglich");
	mysql_select_db("musikdatenbank") or die ("Die Datenbank existiert nicht");
	mysql_query("SET NAMES 'utf8'");
	
	$result = mysql_query("SELECT * FROM artist WHERE name LIKE '%" . $_GET['search'] . "%' LIMIT 5");
	while($row = mysql_fetch_object($result))
	{
		echo '
';
	//	echo preg_replace('/(' . $_GET['search'] . ')/Usi', '<span class="result">\\1</span>', $row->name);
		?> <a href='#<?php echo $alpha; ?>' onclick="getdata('<?php echo $row->id; ?>', '<?php echo $row->name; ?>')"><?php echo $row->name; ?></a><br> <?php
	//	echo "<a style='font-size:0.7em;' href='artist.php?order=newcover&coverid=".$row->id."&covername=".$row->name."'>".$row->name."</a><br>";
		echo '
';
	}

?>