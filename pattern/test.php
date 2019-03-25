<?php
$object = 'MtClassName';
$after_object = preg_replace('/(?<=[a-z])(?=[A-Z])/','_',$object);
echo $after_object.PHP_EOL;

$object = 'i am jack,you know';
$miss_object = preg_match('/i am j((?!ac)[\w\W])+k,/',$object,$result);
var_dump($result); //空数组

#$使用
$object = 'hello';
$after_object = preg_replace('/hello/','${0}',$object);
echo $after_object.PHP_EOL;

$object = 'hello 11 33 44';
$after_object = preg_replace('/hello (\d(\d)) (\d*) (\d*)/','${0},${1},${2},${3}',$object);
echo $after_object.PHP_EOL;

$object = 'MtClassName';
preg_match('/^(?!Mt).*/',$object,$res);
var_dump($res);