<html>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<head>
	<link rel="stylesheet" href="../test.css">
	<script>

	function getdatascandirfuckyou(){

                $.ajax({ 	url: "./scan.php",
							async: false,
							success: function(data){
								$("#statnr").html(data);
							}
				});
    }
		
		
		        var source = 'THE SOURCE';
         
        function start_task()
        {
            source = new EventSource('./test.php');
             
            //a message is received
            source.addEventListener('message' , function(e) 
            {
                var result = JSON.parse( e.data );
                 
                add_log(result.message);
                 
                document.getElementById('progressor').style.width = result.progress + "%";
                 
                if(e.data.search('TERMINATE') != -1)
                {
                    add_log('Scan fertig');
                    source.close();
                }
            });
             
            source.addEventListener('error' , function(e)
            {
                add_log('Error occured');
                 
                //kill the object ?
                source.close();
            });
        }
         
        function stop_task()
        {
            source.close();
            add_log('Interrupted');
        }
         
        function add_log(message)
        {
            var r = document.getElementById('results');
            r.innerHTML += message + '<br>';
            r.scrollTop = r.scrollHeight;
        }
	</script>

</head>	
<?php

set_time_limit(3000);






echo "Starte Scan.... Bitte warten";
require_once('./ownsound.config.php');
require_once './class.progress_bar.php';


$DirectoryToScan = utf8_encode($_REQUEST['scandir']);
//echo $DirectoryToScan;
//$DirectoryToScan = "/mnt/musik/Metallica";
//if($_REQUEST['scandir']=="") {die();}
mysql_connect(DBHOST, DBUSER,DBPASS) OR DIE ("NICHT Erlaubt");
mysql_select_db(DBDATABASE) or die ("Die Datenbank existiert nicht.");
mysql_query("SET NAMES 'utf8'");
if($_REQUEST['truncate']=="yes") {
mysql_query("TRUNCATE `album`");
mysql_query("TRUNCATE `artist`");
mysql_query("TRUNCATE `title`");
}

mysql_query("TRUNCATE `scanner`");
//if (substr($file, -3)==".mp3") 

// Gibt rekursiv alle Ordner, alle Unterordner und Dateien eines Verzeichnisses aus
function get_dir ($dir) {
	$fp=opendir($dir);
	while($datei=readdir($fp)) {
		set_time_limit(100);
		if (substr($datei, -3)=="mp3"){
			$file = utf8_encode($dir."/".$datei);
			mysql_query("INSERT INTO scanner (path) VALUES ('$file')");
		}
		if (is_dir($dir."/".$datei) && $datei!="." && $datei!=".."){
			get_dir($dir."/".$datei);
		}
	}
	closedir($fp);
}
get_dir($DirectoryToScan);





?>




<div id='statnr'></div>
<div id="progressleiste"></div>







<?php

$scanchecker = $checkscan / 20;



//$num_tasks = $scanchecker; // the number of tasks to be completed. 
	?>
	<script language="JavaScript">
	start_task();
	</script>


<div id="results" style="border:1px solid #000; padding:10px; width:300px; height:15px; overflow:auto; background:#eee; z-index:10000;"></div>
        <br />
         
        <div style="border:1px solid #ccc; width:300px; height:20px; overflow:auto; background:#eee;">
            <div id="progressor" style="background:#07c; width:0%; height:100%;"></div>
        </div>



</body></html>
