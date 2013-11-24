<?php
require_once('config.inc.php');
$folders = array();
foreach (glob(MUSICDIR."/*", GLOB_ONLYDIR) as $filename) {
    $folders[] = $filename;
}
?>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<script type="text/javascript" src="./js/ownsound.js"></script>
<script src="./js/jquery.form.js"></script> 
<script src="./js/jquery.desknoty.js"></script>	
	<script src="./js/jquery.easytabs.min.js" type="text/javascript"></script>

  <style>
    /* Example Styles for Demo */
    .etabs { margin: 0; padding: 0; }
    .tab { display: inline-block; zoom:1; *display:inline; background: #eee; border: solid 1px #999; border-bottom: none; -moz-border-radius: 4px 4px 0 0; -webkit-border-radius: 4px 4px 0 0; }
    .tab a { font-size: 14px; line-height: 2em; display: block; padding: 0 10px; outline: none; }
    .tab a:hover { text-decoration: underline; }
    .tab.active { background: #fff; padding-top: 6px; position: relative; top: 1px; border-color: #666; }
    .tab a.active { font-weight: bold; }
    .tab-container .panel-container { background: #fff; border: solid #666 1px; padding: 10px; -moz-border-radius: 0 4px 4px 4px; -webkit-border-radius: 0 4px 4px 4px; }
    .panel-container { margin-bottom: 10px; }
  </style>

<script>

$(function() {
        $('button#forum2').click(function(){
			scandir = document.getElementById("scandir").value;
			document.getElementById('scandir').value="Starte Scan...";
			document.getElementById('scandir').disabled=true;
			if (document.getElementsByName("truncate")[0].checked == true) {

				var truncate = 'yes';
			} else {
				var truncate = 'no';
			}
			document.getElementById("scanner").innerHTML="<object type='text/html' data='./folder.php?scandir="+scandir+"&truncate="+truncate+"' width='500' height='200' etc.></object>";

    });

    }); 



function cTrig() { 
      if (document.getElementsByName('truncate')[0].checked == false) {
        return false;
      } else {
       var box= confirm(unescape("Ernsthaft?\nDieser Vorgang kann nicht r%FCckg%E4ngig gemacht werden!"));
        if (box==true)
            return true;
        else
           document.getElementsByName('truncate')[0].checked = false;

      }
    }
		
$(function() {
        $('button#noti').click(function(){
		
		var notifications = readCookie("notifications");
		
		if (notifications == 'yes') {
            $.desknoty({
                icon: "./img/os_icon2noti.jpg",
                title: "OwnSound",
                body: "Benachrichtigungen sind ausgeschaltet"
				
            });
			createCookie("notifications", 'no' , 100);
			}
			else
			{
			    $.desknoty({
                icon: "./img/os_icon2noti.jpg",
                title: "OwnSound",
                body: "Benachrichtigungen sind angeschaltet"
				
            });
			createCookie("notifications", 'yes' , 100);
			}
			
        });
    });
	
	$(function() {
        $('button#dbbackup').click(function(){
		
			dbbackupp();
			
        });
    });
	
    $(document).ready( function() {
      $('#tab-container').easytabs();
    });
</script>

<div id="tab-container" class='tab-container'>
 <ul class='etabs'>
   <li class='tab'><a href="#tabs1-html">Datenbank</a></li>
   <li class='tab'><a href="#tabs1-js">Benutzerverwaltung</a></li>
   <li class='tab'><a href="#tabs1-css">Info</a></li>
 </ul>
 <div class='panel-container'>
  <div id="tabs1-html">
<div id="scansettings" style="border: 1px solid #000000; padding: 10px; width: 250px;">
<select style="width:250px" id="scandir" name="scandir">
<?php
echo "<option>".MUSICDIR."</option>";
foreach($folders as $folder) {

echo "<option value='$folder'>".str_replace(MUSICDIR.'/', "", $folder)."</option>";

}
?>
</select>




<br>
<div style="font-size:1.0em;">
<input type="checkbox" id="truncate" name="truncate" value="yes" onchange="cTrig()">Datenbank neu anlegen

</form>

</div><button id="forum2">Scan starten</button><button id="dbbackup">Datenbank-Backup</button></div>

  </div>
   <div id="tabs1-js">


   <pre>

Später...
  </pre>

  </div>
  <div id="tabs1-css">
  <?php
require_once('config.inc.php');
mysql_connect(DBHOST, DBUSER,DBPASS);
mysql_select_db(DBDATABASE) or die ("Die Datenbank existiert nicht."); 

$artistresult = mysql_query("SELECT * FROM artist"); 
$artist = mysql_num_rows($artistresult);

$albumresult = mysql_query("SELECT * FROM album"); 
$album = mysql_num_rows($albumresult);

$titleresult = mysql_query("SELECT * FROM title"); 
$title = mysql_num_rows($titleresult);

$nocoverresult = mysql_query("SELECT * FROM album WHERE cover='no'"); 
$nocover = mysql_num_rows($nocoverresult);

echo "$artist Künstler<br>";
echo "$album Alben<br>";
echo "$title Tracks<br>";
?>
<a href='#ownsound' onclick="nocover()"><?php echo $nocover; ?> ohne Cover</a><br>

<button id="noti">Dis/Enable notifications</button>

  </div>
 </div>
</div>

<div id="scanner"></div>