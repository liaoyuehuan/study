<?php

if(!isset($argv[1])) {
    echo 'filename : argument 1 is required';
}
$filename = $argv[1];

$content = file_get_contents($filename);
preg_match('`.*,',$content,$rs);
var_dump($rs);
