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
$now = date('Y-m-d');
$now2 = date('H.m.s');
$now3 = "$now $now2";
require_once('./getid3/getid3.php');
mysql_connect("localhost", "root","strese84");
mysql_select_db("musikdatenbank") or die ("Die Datenbank existiert nicht.");
mysql_query("TRUNCATE `scanner_log`");
mysql_query("INSERT INTO scanner_log (starttime) VALUES ('$now3')");	
$dirs = array();
// Initialize getID3 engine
$getID3 = new getID3;



$out  = '';  
function scan($folder){  
  $titel = $folder; 
  global $hide, $out;  
   
  if($content = opendir($folder)){  

    while(false !== ($file = readdir($content))){  
      if(is_dir("$folder/$file") && $file != "." && $file != ".."){ 

        $out .= "$folder/$file,";   
           scan("$folder/$file");  
 
  
      } 

    }  
    closedir($content);  
  
  }  
 
}  
// function end  


echo scan('/mnt/musik/Eisregen');
$dirs = (explode(',', $out));

$dirs[] = "ende";

echo count($dirs)." Ordner gefunden. Starte Suche...<br>";




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

