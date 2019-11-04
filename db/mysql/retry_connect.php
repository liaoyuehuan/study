<?php

$host = 'p:rm-wz9c339497mprd4814o.mysql.rds.aliyuncs.com';
$port = 3306;
$username = 'rooggtconzhut';
$password = 'M4kq%h#SQBHGj484t5r5%Nx';
$db_name = 'ebg_gongzhu';
$db_link = mysqli_connect($host, $username, $password, $db_name, $port);
for ($i = 0; $i <= 100; $i++) {
    if (empty($db_link)) {
        $db_link = mysqli_connect($host, $username, $password, $db_name, $port);
    }

    mysqli_query($db_link, "insert cz_test_log(type,content)values('aa','bd')");
    if (in_array(mysqli_errno($db_link),[false,2006,2013])) {
        var_dump(mysqli_error($db_link));;
    }
    mysqli_close($db_link) && $db_link = null;
    sleep(2);
}
