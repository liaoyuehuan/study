<?php

$filename = __DIR__ . '/aa.txt';
echo 'begin open' . PHP_EOL;
$ch = fopen($filename, "a+");
echo 'after open' . PHP_EOL;
//sleep(5);
echo 'fseek: ' . fseek($ch, 100) . PHP_EOL;

var_dump(fwrite($ch, 'aa'));
echo 'write finish' . PHP_EOL;
//sleep(5);
fclose($ch);
echo 'close' . PHP_EOL;

# read
$filename = __DIR__ . '/aa.txt';
$ch = fopen($filename, 'r');
echo 'read : ' . fread($ch, filesize($filename)) . PHP_EOL;

