<?php
function testXA()
{
    $pdo1 = null;
    $pdo2 = null;
    $xid = uniqid();
    try {
        $dsn1 = 'mysql:host=127.0.0.1;port=3307;dbname=ebg_gongzhu;charset=utf8';
        $dsn2 = 'mysql:host=rm-wz9t15w7xkikfwmjm0o.mysql.rds.aliyuncs.com;dbname=ebg_gongzhu;charset=utf8';
        $options = [
            PDO::ATTR_AUTOCOMMIT => true,
            PDO::ATTR_PERSISTENT => true,
            PDO::MYSQL_ATTR_INIT_COMMAND => 'set names utf8'
        ];
        $pdo1 = new PDO($dsn1, 'root', '123456', $options);
        $pdo2 = new PDO($dsn2, 'rooggtconzhut', 'U3swlqf7%w9&rd8E&7fm', $options);

        $pdo1->query("xa start '{$xid}'");
        $pdo2->query("xa start '{$xid}'");
        $affectedRow1 = $pdo1->exec("insert cz_test_log(type,content)values('test','test1')");
        $affectedRow2 = $pdo2->exec("insert cz_test_log(type,content)values('test','test2')");
        $pdo1->query("xa end '{$xid}'");
        $pdo2->query("xa end '{$xid}'");
        if ($affectedRow2 < 2) {
            throw new PDOException('pdo1 inert failed : '. $pdo1->errorInfo()['2']);
        }
        if ($affectedRow1 < 1) {
            throw new PDOException('pdo1 inert failed : '. $pdo1->errorInfo()['2']);
        }

        $pdo1->query("xa prepare '{$xid}'");
        $pdo2->query("xa prepare '{$xid}'");

        $pdo1->query("xa commit '$xid'");
        $pdo2->query("xa commit '$xid'");
        echo 'pdo1 connect success' . PHP_EOL;
    } catch (PDOException $e) {
        if ($pdo1) {
            $pdo1->query("xa rollback '$xid'");
        }
        if ($pdo2) {
            $pdo2->query("xa rollback '$xid'");
        }
        echo "error code : {$e->getCode()}" . PHP_EOL;
        echo "error message : {$e->getMessage()}" . PHP_EOL;
        echo "file : {$e->getFile()}" . PHP_EOL;
        echo "file line : {$e->getLine()}" . PHP_EOL;
    }

}

testXA();



