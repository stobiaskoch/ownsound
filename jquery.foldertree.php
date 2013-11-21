<?php
$folders = array();
foreach (glob("/mnt/*") as $filename) {
    $folders[] = $filename;
}

print_r($folders);
?>