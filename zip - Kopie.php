<?php

function addzip($source)
{
    if (!extension_loaded('zip') || !file_exists($source)) {
        return false;
    }
	$tempfile = tempnam("./tmp","zip");
    $zip = new ZipArchive();
    $zip->open($tempfile,ZipArchive::OVERWRITE);

    $source = str_replace('\\', '/', realpath($source));

    if (is_dir($source) === true)
    {
        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source), RecursiveIteratorIterator::SELF_FIRST);

        foreach ($files as $file)
        {
            $file = str_replace('\\', '/', $file);

            // Ignore "." and ".." folders
            if( in_array(substr($file, strrpos($file, '/')+1), array('.', '..')) )
                continue;

            $file = realpath($file);

            if (is_dir($file) === true)
            {
                $zip->addEmptyDir(str_replace($source . '/', '', $file . '/'));
            }
            else if (is_file($file) === true AND (substr(strrchr($file, '.'), 1)) == "jpg")
            {
                $zip->addFromString(str_replace($source . '/', '', $file), file_get_contents($file));
            }
        }
    }
    else if (is_file($source) === true)
    {
        $zip->addFromString(basename($source), file_get_contents($source));
    }

    $zip->close();
	header('Content-Type: application/zip');
	header('Content-Length: ' . filesize($tempfile));
	header('Content-Disposition: attachment; filename="myzippedfiles.zip"');
	readfile($tempfile);
	unlink($tempfile); 
}

addzip ("/mnt/musik/Eisregen/1998 - Krebskolonie/Cover");
?>