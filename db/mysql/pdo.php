<?php

$driver = 'mysql';
$host = 'rm-wz9c339497mprd4814o.mysql.rds.aliyuncs.com';
$port = 3306;
$database = 'ebg_gongzhu';
$username = 'rooggtconzhut';
$password = 'M4kq%h#SQBHGj484t5r5%Nx';
$options = [
    PDO::MYSQL_ATTR_INIT_COMMAND => 'set names utf8',
    PDO::ATTR_PERSISTENT => true,
    # 发生错误时，总是抛出异常 PDOException
    PDO::ERRMODE_EXCEPTION,
    # 设置连接超时时间
    PDO::ATTR_TIMEOUT => 2,
];
$pdo = new PDO("{$driver}:host={$host};port={$port};dbname={$database}", $username, $password, $options);


echo '----- ::getAvailableDrivers -----' . PHP_EOL;
var_dump(PDO::getAvailableDrivers());

echo '----- inTransaction -----' . PHP_EOL;
$pdo->beginTransaction();
var_dump($pdo->inTransaction());

echo '----- quote -----' . PHP_EOL;
# 1、对输入的参数(字符串)进行转义
# 2、还不如直接用 prepare
var_dump($pdo->quote("select * from cz_test_log where type = 'a' limit 1"));

echo '----- query -----' . PHP_EOL;
var_dump($pdo->query("select id from cz_test_log  limit 1", PDO::CASE_LOWER)->fetchAll(PDO::FETCH_ASSOC));


echo '----- insert blob -----' . PHP_EOL;
$stmt = $pdo->prepare("insert into cz_test_log(`type`,content) values (?,?)");
$stmt->bindValue(1, 'dd', PDO::PARAM_STR);
$stmt->bindValue(2, 'asdasda', PDO::PARAM_LOB);
var_dump($stmt->execute());

