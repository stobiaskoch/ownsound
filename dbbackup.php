<?php
require_once('config.inc.php');

$dbhost		= DBHOST;
$dbuser 	= DBUSER;
$dbpwd		= DBPASS;
$dbname 	= DBDATABASE;
$dbbackup	= "./backup.sql";

error_reporting(0);
set_time_limit(0);

// ab hier nichts mehr ändern
$conn = mysql_connect($dbhost, $dbuser, $dbpwd) or die(mysql_error());
mysql_select_db($dbname);
$f = fopen($dbbackup, "w");

$tables = mysql_list_tables($dbname);
while ($cells = mysql_fetch_array($tables))
{
	$table = $cells[0];
	fwrite($f,"DROP TABLE `".$table."`;\n"); 
	$res = mysql_query("SHOW CREATE TABLE `".$table."`");
	if ($res)
	{
		$create = mysql_fetch_array($res);
		$create[1] .= ";";
		$line = str_replace("\n", "", $create[1]);
		fwrite($f, $line."\n");
		$data = mysql_query("SELECT * FROM `".$table."`");
		$num = mysql_num_fields($data);
		while ($row = mysql_fetch_array($data))
		{
			$line = "INSERT INTO `".$table."` VALUES(";
			for ($i=1;$i<=$num;$i++)
			{
				$line .= "'".mysql_real_escape_string($row[$i-1])."', ";
			}
			$line = substr($line,0,-2);
			fwrite($f, $line.");\n");
		}
	}
}
fclose($f);

	header('Content-Type: application/zip; charset=ISO-8859-1');
	header('Content-Length: ' . filesize($dbbackup));
	header('Content-Disposition: attachment; filename=db.sql');
	readfile($dbbackup);


?>