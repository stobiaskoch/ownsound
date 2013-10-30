<html>
<head>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script> 
	<script>
		function getdata(dir){
		$.ajax({ url: "./scan.php?dirtoscan="+dir, success: function(data){
            $("#statnr").html(data);
    }
    });
	}
	</script>

</head>		
<?php
require_once('config.inc.php');
require_once('./getid3/getid3.php');
mysql_connect(DBHOST, DBUSER,DBPASS) OR DIE ("NICHT Erlaubt");
mysql_select_db(DBDATABASE) or die ("Die Datenbank existiert nicht.");

mysql_query("TRUNCATE `scanner_log`");
/*
mysql_query("TRUNCATE `album`");
mysql_query("TRUNCATE `artist`");
mysql_query("TRUNCATE `title`");
*/
mysql_query("INSERT INTO scanner_log (starttime) VALUES (NOW())");	
$dirs = array();
// Initialize getID3 engine
$getID3 = new getID3;

$DirectoryToScan = MUSICDIR; // change to whatever directory you want to scan

$out  = '';  
function scan($folder){  
  $titel = $folder; 
  global $hide, $out;  
   
  if($content = opendir($folder)){  

    while(false !== ($file = readdir($content))){  
      if(is_dir("$folder/$file") && $file != "." && $file != ".."){ 


        $out .= "$folder/$file;";   
           scan("$folder/$file"); 
		   
      } 
    }  
    closedir($content);  
  }  
}  
// function end  

echo scan($DirectoryToScan);
$dirs = (explode(';', $out));
$dirstoscan = count($dirs);
echo count($dirs)." Ordner gefunden. Starte Suche...<br>";
*/
for ($i = 0; $i <= $dirstoscan; $i++) {
    echo "# $i - $dirs[$i]";
	echo "<br>";
}
*/
if(in_array("",$dirs)){

$pos=array_search("",$dirs);

unset($dirs[$pos]);

}

mysql_query("UPDATE scanner_log SET foldertoscan=$dirstoscan WHERE id='0'");
echo "<br>";
//print_r($dirs);
//die();
foreach ($dirs as $dirtoscan) {
?>
<script language="JavaScript">
getdata('<?php echo $dirtoscan; ?>');
</script>
<?php
}
echo "<div id='statnr'></div>";
echo '</body></html>';

