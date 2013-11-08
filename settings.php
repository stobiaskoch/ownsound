<?php
require_once('config.inc.php');
$folders = array();
foreach (glob(MUSICDIR."/*", GLOB_ONLYDIR) as $filename) {
    $folders[] = $filename;
}
?>
<script type="text/javascript" src="./js/ownsound.js"></script>
<script src="./js/jquery.form.js"></script> 
<script src="./js/jquery.desknoty.js"></script>	
<script>
$(document).ready(function()
{
	$('#scansettings').ajaxForm(function() { 
			scandir = document.getElementById("scandir").value;
			document.getElementById('scandir').value="Starte Scan...";
			document.getElementById('scandir').disabled=true;
			if (document.getElementsByName("truncate")[0].checked == true) {
				var truncate = 'yes';
			} else {
				var truncate = 'no';
			}
			
			$.ajax({ url: "./folder_v2.php?scandir="+scandir+"&truncate="+truncate , success: function(data){
            $("#information").html(data);
    }
    });

    }); 

})

$(function() {
        $('button#noti').click(function(){
            $.desknoty({
                icon: "./img/os_icon2noti.jpg",
                title: "OwnSound",
                body: "Benachrichtigungen sind angeschaltet"
 
            });
        });
    });
	
createCookie("progress2", 1, 100);
</script>
<div id="information"><h1>Einstellungen</h1>
	
	<div style="font-size: 12px; top: 50px; left: 890px; position:fixed;"><a href='#ownsound' onclick="settingsclose()"> schliessen </a></div>
	<div style="font-size: 12px; top: 260px; left: 868px; position:fixed;"><a href='https://github.com/stobiaskoch/ownsound'><img src='./img/git.gif'></a></div>
<form method="post" name="scansettings" id="scansettings" action="./null.php" onsubmit="javascipt:document.scansettings.scandir.readonly='true'">
<div id="scansettings" style="border: 1px solid #000000; padding: 10px; width: 250px;">
<select style="width:250px" id="scandir" name="scandir">
<?php
echo "<option>".MUSICDIR."</option>";
foreach($folders as $folder) {

echo "<option>$folder</option>";

}
?>
</select>




<br>
<input type="checkbox" id="truncate" name="truncate" value="yes">Datenbank neu anlegen
<input type="submit" value=" Scan starten ">
</form>
</div>
	<br><button id="noti">Enable notifications</button>
	
	

</div>