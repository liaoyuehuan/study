<?php
$object = 'MtClassName';
$after_object = strtolower(preg_replace('/(?<=[a-z])(?=[A-Z])/', '_', $object));
echo $after_object . PHP_EOL;

$classAfterObject = str_replace('_','',ucwords($after_object,'_'));
echo $classAfterObject.PHP_EOL;

$object = 'i am jack,you know';
$miss_object = preg_match('/i am j((?!ac)[\w\W])+k,/', $object, $result);
var_dump($result); //空数组

#$使用
$object = 'hello';
$after_object = preg_replace('/hello/', '${0}', $object);
echo $after_object . PHP_EOL;
$object = 'hello 11 33 44';
$after_object = preg_replace('/hello (\d(\d)) (\d*) (\d*)/', '${0},${1},${2},${3}', $object);
echo $after_object . PHP_EOL;

$object = 'MtClassName';
preg_match('/^(?!Mt).*/', $object, $res);

# 中文汉字
$object = '我是超）'; // 无法匹配
$object = '我是超a';  // 无法匹配
$object = '我是超人'; // 匹配成功
preg_match('/^[\x{4e00}-\x{9fa5}]+$/u', $object, $res);

# 中文符号
$object = '（。啊';
preg_match_all('/[\x{3002}|\x{ff1f}|\x{ff01}|\x{ff0c}|\x{3001}|\x{ff1b}|\x{ff1a}|\x{201c}|\x{201d}|\x{2018}|\x{2019}|\x{ff08}|\x{ff09}|\x{300a}|\x{300b}|\x{3008}|\x{3009}|\x{3010}|\x{3011}|\x{300e}|\x{300f}|\x{300c}|\x{300d}|\x{fe43}|\x{fe44}|\x{3014}|\x{3015}|\x{2026}|\x{2014}|\x{ff5e}|\x{fe4f}|\x{ffe5}]/u', $object, $res);


# 字段转换
$object = 'aa_bb';
$field_object = str_replace('_', '', lcfirst(ucwords($object, '_')));

# split时就不会包含空的字符
$object = '1/24 * *       *  * ';
$res = preg_split('/\s/',$object,-1,PREG_SPLIT_NO_EMPTY);

# 非获取匹配（反向否定）
$object = "dasda'as\'das\"d";
$res = preg_replace('/(?<!(\\\))\'/','\\\'',$object);
var_dump($res);
