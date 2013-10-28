<?php
if (isset($_REQUEST['mp3'])) {
$mp3 = $_REQUEST['mp3'];
}


if(file_exists($mp3)) {
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");    // Date in the past
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // always modified
        header("Cache-Control: no-store, no-cache, must-revalidate");  // HTTP/1.1
        header("Pragma: no-cache");                          // HTTP/1.0
        header("Content-Type: audio/mpeg\n");
        $filesize = filesize($mp3);
        header("Content-Length: $filesize");
        $fp = @fopen($mp3,"rb");
        fpassthru($fp);
        fclose($fp);
}
?>