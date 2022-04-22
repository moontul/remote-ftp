<?php

/**
 * Download file from path and mimetype.
 *
 * @param      $path
 * @param      $mimetype
 * @param null $filename
 */
function download_file ($path, $mimetype, $filename = NULL) {
    if (empty($filename)) {
        $filename = pathinfo($path, PATHINFO_BASENAME);
    }

    if (!strstr($_SERVER['HTTP_USER_AGENT'], 'Firefox')) {
        $filename = rawurlencode($filename);
    }

    header('cache-control: no-cache');
    header("Content-Type: $mimetype");
    header("Content-Disposition: attachment; filename=$filename");
    header("Content-Length: " . filesize($path));
    readfile($path);
}

/**
 * Download text file from string.
 *
 * @param $filename
 * @param $string
 */
function download_txt($filename, $string){
    header('cache-control: no-cache');
    header('Content-Type: text/plain');
    header("Content-Disposition: attachment; filename={$filename}");
    header("Content-Length: " . strlen($string));
    echo $string;
}

?>
