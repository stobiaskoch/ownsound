<?
if($_REQUEST['action']=="getdir") {
	$dirnum=$_REQUEST['dirnum']-1;
	$datei =file("./tmp/dirs.txt");
	foreach($datei AS $ausgabe)
	{
	   $zerlegen = explode(",", $ausgabe);
	}
	echo $zerlegen[$dirnum];
	exit;
}
?>
<html>
<head>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script> 
	<script>
		function getdata(dir,dirnum,total){
		$.ajax({ url: "./scan.php?dirtoscan="+dir, success: function(data){
            $("#statnr").html(data);
			//alert('Dirnum:'+dirnum+' Total:'+total);
			getdir(dirnum,total);
		}
		});
		}
		function getdir(dirnum,total) {
			if(dirnum!=total) {
				$.ajax({ url: "./folder.php?action=getdir&dirnum="+dirnum, success: function(data){
					$("#scanned").html(data);
					var dirnumx = dirnum+1;
					getdata(data,dirnumx,total);
				}
				});
			}
		}
	</script> 
	

</head>		
<?php
require_once('config.inc.php');
$now = date('Y-m-d');
$now2 = date('H.m.s');
$now3 = "$now $now2";
require_once('./getid3/getid3.php');
mysql_connect(DBHOST, DBUSER,DBPASS) OR DIE ("NICHT Erlaubt");
mysql_select_db(DBDATABASE) or die ("Die Datenbank existiert nicht.");
mysql_query("TRUNCATE `scanner_log`");
mysql_query("INSERT INTO scanner_log (starttime) VALUES ('$now3')");	
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

        $out .= "$folder/$file,";   
           scan("$folder/$file");  
      } 
    }  
    closedir($content);  
  }  
}  
// function end  

echo scan($DirectoryToScan);
$dirs = (explode(',', $out));
$dirgesamt=count($dirs);
echo $dirgesamt." Ordner gefunden. Starte Suche...<br><div id='scanned'></div>";
$dirsx=implode(",",$dirs);
$datei_handle=fopen("./tmp/dirs.txt",w);
fwrite($datei_handle,$dirsx);
fclose($datei_handle);
echo "<br>"; 
//print_r($dirs);
//die();
?>
<script language="JavaScript">
getdir(77,<?php echo $dirgesamt;?>);
</script>
<?php 
//foreach ($dirs as $dirtoscan) {

//}
echo "<div id='statnr'></div>";
echo '</body></html>';

