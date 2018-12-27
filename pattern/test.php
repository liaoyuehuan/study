<?php
$object = 'MtClassName';
$after_object = preg_replace('/(?<=[a-z])(?=[A-Z])/','_',$object);
echo $after_object.PHP_EOL;

$object = 'i am jack,you know';
$miss_object = preg_match('/i am j((?!ac)[\w\W])+k,/',$object,$result);
var_dump($result); //空数组