
<?php
define("DBHOST", "localhost");
define("DBUSER", "root");
define("DBPASS", "strese84");
define("DBDATABASE", "musikdatenbank");

mysql_connect(DBHOST, DBUSER,DBPASS);
mysql_select_db(DBDATABASE) or die ("Die Datenbank existiert nicht."); 
mysql_query("SET NAMES 'utf8'");
mysql_query("TRUNCATE `scanner`");
function map_dirs($path,$level) {
        if(is_dir($path)) {
                if($contents = opendir($path)) {
                        while(($node = readdir($contents)) !== false) {
                                if($node!="." && $node!="..") {
										if(substr($node, -3)=="mp3" or substr($node, -3)=="MP3") {
										$path3 = addslashes($path."/".$node);
								//		$path3 = urlencode($path3);
										mysql_query("INSERT INTO scanner (path) VALUES ('$path3')");
										echo mysql_error();
                                        }
										map_dirs("$path/$node",$level+1);
                                }
                        }
                }
        }
}
 map_dirs('/mnt/musik/Die Ärzte',0);
?>
	
