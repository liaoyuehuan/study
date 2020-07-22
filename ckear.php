<?php

$a  = '开户许可证|J5510039419102|核准号:|编号:5510-02249037|经审核,湖南客尚电梯服务有限公司|符合开户条件,准予|开立基本存款账户。|法定代表人(单位负责人)李鹏程|开户银行长沙银行股份有限公司高升路支行|账号|800232826408012|限公司|发证机关(盖章|20180711|年月日|厨中';

preg_match('/(?<=(经审核,)).+?\|/',$a,$res);
var_dump(trim($res[0],'|'));

preg_match('/(?<=(开户银行)).+?\|/',$a,$res);
var_dump(trim($res[0],'|'));

preg_match('/(?<=(账号)).+?\|/',$a,$res);
var_dump(trim($res[0],'|'));

exit();
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





