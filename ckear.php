<?php

//算金额时，取分并且向上取整
$a = "1111.11";  //但是111.11没有这个问题
$b = (float)$a;
$c = (int)($b * 100);
$d = intval($b * 100);
$e = intval($b * 1000 / 10);
$f = (ceil($b * 100));
echo 'a=' . $a . PHP_EOL;
echo 'b=' . $b . PHP_EOL;
echo 'c=' . $c . PHP_EOL;
echo 'd=' . $d . PHP_EOL;
echo 'e=' . $e . PHP_EOL;
echo 'f=' . $f . PHP_EOL;

$str = 'sadasdasdas';
$rs = chunk_split($str, 2, '#');
var_dump($rs);

$arr = [
    1.1 => 'aaa',
    2 => 'bbb'
];
var_dump($arr['1.1']);
var_dump($arr[1.1]);
var_dump($arr[1.10]);
var_dump($arr['2']);





