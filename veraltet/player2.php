<?php
	//TEST
	error_reporting(E_ALL | E_STRICT);
	ini_set('open_basedir', '/media/usb1/Musik/');
	//$pfad=$_SERVER['DOCUMENT_ROOT']."
	
	
	
?>

<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<link href="./skin/blue.monday/jplayer.blue.monday.css" rel="stylesheet" type="text/css" /> 
	<script src="./js/jquery-1.9.1.js"></script>	
	<script src="./js/jquery-ui.js"></script>
	<script type="text/javascript" src="./js/jquery.jplayer.min.js"></script>
	<script type="text/javascript" src="./js/add-on/jplayer.playlist.min.js"></script>



</head>
<script type="text/javascript">
//<![CDATA[
$(document).ready(function(){
	var cssSelector = {
        jPlayer: "#jquery_jplayer_1", 
        cssSelectorAncestor: "#jp_container_1"
			
    };
    var playlist = []; // Empty playlist
    var options = {
        swfPath: "./jplayer", 
        supplied: "mp3",
		smoothPlayBar: true,
		preload: 'metadata',
		volume: 0.5,
		autohide: true
    };
    var myPlaylist = new jPlayerPlaylist(cssSelector, playlist, options);
    $.getJSON("./playlist.php",function(data){  // get the JSON array produced by my PHP
        $.each(data,function(index,value){
            myPlaylist.add(value); // add each element in data in myPlaylist
        })
    }); 
	
	

	
});
</script>
		<div id="jp_container_1" class="jp-audio">
			<div class="jp-type-playlist">
				<div class="jp-playlist">
					<ul>
						<li></li>
					</ul>
				</div>
				<div class="jp-no-solution">
					<span>Update Required</span>
					To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
				</div>
			</div>
		</div>