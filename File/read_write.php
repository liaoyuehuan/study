<?php

$filename = __DIR__ . '/aa.txt';
echo 'begin open' . PHP_EOL;
$ch = fopen($filename, "a+");
echo 'after open' . PHP_EOL;
sleep(5);
fseek($ch,100);

var_dump(fwrite($ch,'aa'));
echo 'write finish' . PHP_EOL;
sleep(5);
fclose($ch);
echo 'close' . PHP_EOL;

