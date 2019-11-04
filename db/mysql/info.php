<?php
$host = 'p:rm-wz9c339497mprd4814o.mysql.rds.aliyuncs.com';
$port = 3306;
$username = 'rooggtconzhut';
$password = 'M4kq%h#SQBHGj484t5r5%Nx';
$db_name = 'ebg_gongzhu';
$db_link = mysqli_connect($host, $username, $password, $db_name, $port);
$charset = mysqli_get_charset($db_link);
var_dump($charset);
[
    'charset' => 'utf8',  # 编码方式,
    'collation' => 'utf8_general_ci', # 指定数据集如何排序.
    'dir' => '', # 不知道
    'min_length' => 1, # 最小字符字节大小
    'max_length' => 3, # 最大字符字节大小
    'number' => 33,
    'state' => 1,
    'comment' => 'UTF-8 Unicode'

];