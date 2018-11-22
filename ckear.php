<?php

$a = "1111.11";
$b = (float)$a;
$c = (int)($b * 100);
$d = intval($b * 100);
$e = intval($b * 1000 / 10);
echo 'a=' . $a . PHP_EOL;
echo 'b=' . $b . PHP_EOL;
echo 'c=' . $c . PHP_EOL;
echo 'd=' . $d . PHP_EOL;
echo 'e=' . $e . PHP_EOL;

$str = 'sadasdasdas';
$rs = chunk_split($str, 2, '#');
var_dump($rs);



