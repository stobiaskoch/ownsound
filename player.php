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
	<script type="text/javascript" src="./js/jquery-ui-1.10.3.custom.js"></script>
	<script type="text/javascript" src="./js/jquery.jplayer.min.js"></script>
	<script type="text/javascript" src="./js/add-on/jplayer.playlist.min.js"></script>
	<script type="text/javascript" src="./js/ownsound.js"></script>
	<script src="./js/jquery.ui.core.js"></script>
	<script src="./js/jquery.ui.widget.js"></script>
	<script src="./js/jquery.ui.mouse.js"></script>
	<script src="./js/jquery.ui.draggable.js"></script>



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

function autoplay() {
	$('#jquery_jplayer_1').jPlayer("play");
}

    document.onkeydown = function(event) {
 
        var actionBox = document.getElementById('action');
 
        if (event.keyCode == 32) {
 
          event.cancelBubble = true;
          event.preventDefault = false;
 
          $('#jquery_jplayer_1').jPlayer("play");
 
        }
 
        return event.event.preventDefault;
 
      }
	  
	  	$(function() {
		$( "#malsehenobdraggable" ).draggable({ 
			stop: function (event, ui) {
				createCookie("palletteX", ui.position.left, 100);
				createCookie("palletteY", ui.position.top, 100);
     }



		});
		$('#player').css({
'top': '200',
'left': '200',
'position': 'absolute'
});
	});
</script>

<body>

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
		
		
		<div id="malsehenobdraggable" style="position: absolute; top:-100px; left: -790px;">
 <div id="jquery_jplayer_1" class="jp-jplayer" ></div>

		<div id="jp_container_1" class="jp-audio" style="width:440px;">
			<div class="jp-type-playlist" style="width:440px;">
				<div class="jp-gui jp-interface" style="width:440px;">
					<ul class="jp-controls" style="width:440px;">
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
			
			</div>
		</div>	
	</div>
</body>
</html>
