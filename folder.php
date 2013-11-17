<html>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<head>
	<link rel="stylesheet" href="../test.css">
	<script>

		
		        var source = 'THE SOURCE';
         
        function start_task()
        {
            source = new EventSource('./scanner.php');
             
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







require_once('./config.inc.php');

include('./js/functions.php');

$DirectoryToScan = utf8_encode($_REQUEST['scandir']);
$bla = $_REQUEST['scandir'];
echo "<p style='font-size: 9px;'>Durchsuche ".$bla." .... Bitte warten</p>";
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

		
map_dirs($bla ,0);




<div id='statnr'></div>
<div id="progressleiste"></div>






	<script language="JavaScript">
	start_task();
	</script>


<div id="results" style="font-size: 9px; border:1px solid #000; padding:10px; width:300px; height:15px; overflow:auto; background:#eee; z-index:10000;"></div>
        <br />
         
        <div style="border:1px solid #ccc; width:300px; height:20px; overflow:auto; background:#eee;">
            <div id="progressor" style="background:#07c; width:0%; height:100%;"></div>
        </div>



</body></html>
 
