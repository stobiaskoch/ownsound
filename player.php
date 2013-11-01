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

	<link href="./skin/pink.flag/jplayer.pink.flag.css" rel="stylesheet" type="text/css" /> 
	<script src="./jquery-1.9.1.js"></script>	
	<script src="./jquery-ui.js"></script>
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
		autoPlay: true 
    };
    var myPlaylist = new jPlayerPlaylist(cssSelector, playlist, options);
    $.getJSON("./playlist.php",function(data){  // get the JSON array produced by my PHP
        $.each(data,function(index,value){
            myPlaylist.add(value); // add each element in data in myPlaylist
        })
    }); 
	
	

	
});
//]]>
</script>

<body>

 <div id="jquery_jplayer_1" class="jp-jplayer"></div>

		<div id="jp_container_1" class="jp-audio">
			<div class="jp-type-playlist">
				<div class="jp-gui jp-interface">
					<ul class="jp-controls">
						<li><a href="javascript:;" class="jp-previous" tabindex="1">previous</a></li>
						<li><a href="javascript:;" class="jp-play" tabindex="1">play</a></li>
						<li><a href="javascript:;" class="jp-pause" tabindex="1">pause</a></li>
						<li><a href="javascript:;" class="jp-next" tabindex="1">next</a></li>
						<li><a href="javascript:;" class="jp-stop" tabindex="1">stop</a></li>
						<li><a href="javascript:;" class="jp-mute" tabindex="1" title="mute">mute</a></li>
						<li><a href="javascript:;" class="jp-unmute" tabindex="1" title="unmute">unmute</a></li>
						<li><a href="javascript:;" class="jp-volume-max" tabindex="1" title="max volume">max volume</a></li>
					</ul>
					<div class="jp-progress"><br>
						<div class="jp-seek-bar"><br>
							<div class="jp-play-bar"></div>

						</div>
					</div>
					<div class="jp-volume-bar">
						<div class="jp-volume-bar-value"></div>
					</div>
					<div class="jp-current-time"></div>
					<div class="jp-duration"></div>
					<ul class="jp-toggles">
						<li><a href="javascript:;" class="jp-shuffle" tabindex="1" title="shuffle">shuffle</a></li>
						<li><a href="javascript:;" class="jp-shuffle-off" tabindex="1" title="shuffle off">shuffle off</a></li>
						<li><a href="javascript:;" class="jp-repeat" tabindex="1" title="repeat">repeat</a></li>
						<li><a href="javascript:;" class="jp-repeat-off" tabindex="1" title="repeat off">repeat off</a></li>
					</ul>
				</div>
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






	

</body>
</html>
