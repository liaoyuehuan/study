<?php

if (!isset($argv[1])) {
    echo 'filename : argument 1 is required';
    exit();
}
$filename = $argv[1];
try {
    $content = file_get_contents($filename);
    $content = preg_replace('/\` .*,/', ',', $content);
    file_put_contents($filename, $content);
    echo 'success';
} catch (Exception $e) {
    echo $e->getTrace();
}

