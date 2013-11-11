<html>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<head>
	<link rel="stylesheet" href="./themes/base/jquery.ui.all.css">
	<script src="./js/jquery-1.9.1.js"></script>
	<script type="text/javascript" src="./js/ownsound.js"></script>
	<script src="./js/jquery.ui.core.js"></script>
	<script src="./js/jquery.ui.widget.js"></script>
	<script src="./js/jquery.ui.progressbar.js"></script>
	<script src="./js/jquery.jeditable.js"></script> 
	<script>
	$(function() {
		
		var progressbar = $( "#progressbar" ),
			progressLabel = $( ".progress-label" ),
			progressvalue = readCookie("progress2"),
			progressvalue = progressvalue * 1;

		progressbar.progressbar({
			value: false,
			change: function() {
				progressLabel.text( progressbar.progressbar( "value" ) + "%" );
			},
			complete: function() {
				progressLabel.text( "Complete!" );
			}
		});

		function progress() {
			var val = progressbar.progressbar( "value" ) || 0;

			progressbar.progressbar( "value", val + readCookie("progress2") * 1 );

			if ( val < 99 ) {
				setTimeout( progress, 100 );
			}
		}

		setTimeout( progress, 3000 );
	});
	
	function getdatascandirfuckyou(dir){
                $.ajax({ url: "./scan_v2.php?dirtoscan="+dir, success: function(data){
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
mysql_query("SET NAMES 'utf8'");

mysql_query("TRUNCATE `scanner_log`");
if($_REQUEST['truncate']=="yes") {
mysql_query("TRUNCATE `album`");
mysql_query("TRUNCATE `artist`");
mysql_query("TRUNCATE `title`");
}
mysql_query("INSERT INTO scanner_log (starttime) VALUES (NOW())");	
$dirs = array();
// Initialize getID3 engine
$getID3 = new getID3;

//$DirectoryToScan = MUSICDIR; // change to whatever directory you want to scan
$DirectoryToScan = utf8_encode($_REQUEST['scandir']);

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
echo "Durchsuche $$DirectoryToScan ...<br>";
echo $dirstoscan -1 ." Ordner gefunden. Starte Suche...<br>";
/*
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
?> <div id="progressbar"><div class="progress-label">Loading...</div></div> <?php
//print_r($dirs);

foreach ($dirs as $dirtoscan) {
?>
<script language="JavaScript">
getdatascandirfuckyou('<?php echo urlencode($dirtoscan); ?>');
</script>
<?php
}
?>

<div id='statnr'></div>

</body></html>


