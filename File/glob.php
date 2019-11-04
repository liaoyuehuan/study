<?php

$scam_path = './';

$files = glob('*'); //作用在当前目录下或指定目录如：D/aa/*.txt
var_dump($files);
$dir_iterator = new RecursiveDirectoryIterator(__DIR__ . '', FilesystemIterator::KEY_AS_FILENAME);

foreach ($dir_iterator as $file) {
    if ($file->isFile()) {
        echo substr($file->getPathname(), 27) . ": " . $file->getSize() . " B; modified " . date("Y-m-d", $file->getMTime()) . "\n";
    } else {

    }
}

function get_dir_files($scam_path, $pattern = null)
{
    $dir_files = [];
    $files = scandir($scam_path);
    $files = array_diff($files, ['.', '..']);
    foreach ($files as $file) {
        $file_path = ltrim(rtrim($scam_path, '/') . '/' . $file, '(./)');
        if (is_dir($file_path)) {
            $dir_files = array_merge($dir_files, get_dir_files($file_path));
        } else {
            $dir_files[] = $file_path;
        }
    }
    if ($pattern !== null) {
        $dir_files =  preg_grep($pattern,$dir_files);
    }
    return $dir_files;
}

var_dump(get_dir_files($scam_path,'/\.js$/'));
