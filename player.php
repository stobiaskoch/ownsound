<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">

	<script type="text/javascript" src="./js/ownsound.js"></script>
	<script src="./js/jquery.loadmask.min.js"></script> 
	
	<script src="./js/jquery.desknoty.js"></script>	
	<script type="text/javascript" src="./js/jquery.jplayer.min.js"></script>
	<script type="text/javascript" src="./js/add-on/jplayer.playlist.min.js"></script>
</head>
<script type="text/javascript">

function notify(strtext, albumID) {
$.desknoty({
      icon: "./get.php?picid="+albumID+"&size=small",
      title: 'OwnSound spielt:',
      body: strtext
 
            });
  }  

$(document).ready(function() {




//<![CDATA[

	var cssSelector = {
        jPlayer: "#jquery_jplayer_1", 
        cssSelectorAncestor: "#jp_container_1"
			
    };
    var playlist = []; // Empty playlist
	var oldvolume = readCookie("volume");
    var options = {
        swfPath: "./js", 
        supplied: "mp3",
		smoothPlayBar: true,
		preload: 'none',
		volume: oldvolume,
		autohide: true
    };
    var myPlaylist = new jPlayerPlaylist(cssSelector, playlist, options);
    $.getJSON("./playlist.php",function(data){  // get the JSON array produced by my PHP
        $.each(data,function(index,value){
            myPlaylist.add(value); // add each element in data in myPlaylist
        })
		
    }); 
	$('#jquery_jplayer_1').bind($.jPlayer.event.play, function(event) { // binding to the play event so this runs every time media is played
          var current = myPlaylist.current; //This is an integer which represents the index of the array object currently being played.
          var playlist = myPlaylist.playlist //This is an array, which holds each of the set of the items youve defined (e.q. title, mp3, artist etc...)

          $.each(playlist, function(index, object) { //$.each is a jQuery iteration method which lets us iterate over an array(playlist), so we actually look at playlist[index] = object
                  if(index == current) {   
                   		var play = $('.currentSong p').text(object.title);
						var albumID = (object.artistID);
						var songtitle = (object.title);
						var artist = (object.artist);
						str = songtitle.replace(/\'/g,'\\\'');
						document.getElementById("playnow").innerHTML="Now playing: "+artist+" - "+str+"";
						document.getElementById("playercover").innerHTML="<img src='./get.php?picid="+albumID+"&size=small' width='69' height='70'>";
						strtext = artist+' - '+str;
						var notifications = readCookie("notifications");
						if (notifications == 'yes') {
							notify(strtext, albumID);
						}
                  }
            });
});	

	$('#jquery_jplayer_1').bind($.jPlayer.event.volumechange , function(event) {		
						var voolume = $("#jquery_jplayer_1").data("jPlayer").options.volume;
						createCookie("volume", voolume, 100);
						});
});


</script>

<body>

				<div id="jp_container_1" class="jp-audio" style="width:100%;">
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
		<?php
		$left = $_COOKIE["screenwidth"];
		$left = $left / 2;
		$left = $left - 255;
		?>
		<div id="malsehenobdraggable" style="position: fixed; bottom:1px; right: 5px;">
		
 <div id="jquery_jplayer_1" class="jp-jplayer" ></div>
	
		<div id="jp_container_1" class="jp-audio" style="width:510px;">
		
			<div class="jp-type-playlist" style="width:440px;">
			
				<div class="jp-gui jp-interface" style="width:440px;">
				
					<ul class="jp-controls" style="width:441px;">
						<li><a href="javascript:;" class="jp-previous" tabindex="1">prev</a></li>
						<li><a href="javascript:;" class="jp-play" tabindex="1">play</a></li>
						<li><a href="javascript:;" class="jp-pause" tabindex="1">pause</a></li>
						<li><a href="javascript:;" class="jp-next" tabindex="1">next</a></li>
						<li><a href="javascript:;" class="jp-stop" tabindex="1">stop</a></li>
						<li><a href="javascript:;" class="jp-mute" tabindex="1" title="mute" style="top: 20px; right: 146px;">mute</a></li>
						<li><a href="javascript:;" class="jp-unmute" tabindex="1" title="unmute" style="top: 20px; right: 146px;">unmute</a></li>
						<li><a href="javascript:;" class="jp-volume-max" tabindex="1" title="max volume" style="top: 20px; right: 120px;">max volume</a></li>
					</ul>
					<div class="jp-progress"><br>
						<div class="jp-seek-bar"><br>
							<div class="jp-play-bar" style="overflow: visible;"></div>

						</div>
					</div>
					<div class="jp-volume-bar" style="top: 20px;">
						<div class="jp-volume-bar-value" style="top: 20px;"></div>
					</div>
					<div class="jp-current-time" style="margin-left: 15px;"></div>
					<div class="jp-duration" style="margin-right: 15px;"></div>
					<div id="playnow" style="position: relative; left:30px; top: 53px; font-size: 9px;"></div>
					<ul class="jp-toggles">
						<li><a href="javascript:;" class="jp-shuffle" tabindex="1" title="shuffle">shuffle</a></li>
						<li><a href="javascript:;" class="jp-shuffle-off" tabindex="1" title="shuffle off">shuffle off</a></li>
						<li><a href="javascript:;" class="jp-repeat" tabindex="1" title="repeat">repeat</a></li>
						<li><a href="javascript:;" class="jp-repeat-off" tabindex="1" title="repeat off">repeat off</a></li>
					</ul>
					
				</div>
			<div id="playercover" style="
			position: absolute;
			right: 1px;
			bottom: 1px;
			width: 70px;
			height: 70px;
			background: #191919 url('./css/jplayer/jplayer.midnight.black.interface.png') repeat-x;
			"></div>
			</div>
		</div>	
		
	</div>
</body>
</html>
