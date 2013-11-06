<?php require_once('config.inc.php'); ?>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script> 
<script type="text/javascript" src="./js/ownsound.js"></script>
<script src="./js/jquery.form.js"></script> 
<script>
$(document).ready(function()
{
	$('#scansettings').ajaxForm(function() { 
			
			if (document.getElementsByName("truncate")[0].checked == true) {
				var truncate = 'yes';
			} else {
				var truncate = 'no';
			}
			scandir = document.getElementById("scandir").value;
			$.ajax({ url: "./folder_v2.php?scandir="+scandir+"&truncate="+truncate , success: function(data){
            $("#information").html(data);
    }
    });

    }); 

})
</script>

<div id="information"><h1>Einstellungen</h1>
	
	<div style="font-size: 12px; top: 50px; left: 890px; position:fixed;"><a href='#ownsound' onclick="settingsclose()"> schliessen </a></div>
	<div style="font-size: 12px; top: 260px; left: 868px; position:fixed;"><a href='https://github.com/stobiaskoch/ownsound'><img src='./img/git.gif'></a></div>
	<div style="font-size: 12px; top: 50px; left: 890px; position:fixed;"><a href='#ownsound' onclick="settingsclose()"> schliessen </a></div>
<form method="post" name="scansettings" id="scansettings" action="./blal.php">
<div id="scansettings" style="border: 1px solid #000000; padding: 10px; width: 250px;">
Ordner: <input style="font-size: 12px;" type="text" id="scandir" name="scandir" value="<?php echo MUSICDIR; ?>"><br>
<input type="checkbox" id="truncate" name="truncate" value="yes">Datenbank neu anlegen
<input type="submit" value=" Scan starten ">
</div>
	
	
	
	
	
	
	
	
	
	
	
	
	
	<?php















?>
</div>
