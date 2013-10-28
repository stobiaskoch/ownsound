<?php
//Playlist
$playlist[]=array("artist"=>"AC/DC","title"=>"Thunderstruck","mp3"=>"mp3.php?datei=01 Thunderstruck.mp3");
$playlist[]=array("artist"=>"AC/DC","title"=>"Shoot To Thrill","mp3"=>"mp3.php?datei=02 Shoot to Thrill.mp3");
$playlist[]=array("artist"=>"AC/DC","title"=>"Back In Black","mp3"=>"mp3.php?datei=03 Back in Black.mp3");
$playlist=json_encode($playlist);
print_r($playlist);
?>