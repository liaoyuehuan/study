<?php
echo 'gmt date : ' . gmdate('Y-m-d H:i:s', time()) . PHP_EOL;
echo 'date : ' . date('Y-m-d H:i:s', time()) . PHP_EOL;

# 返回年、月、日、星期、一年中第几天、时、分、秒、时间戳
$dateInfo = getdate();

# 地址：https://www.php.net/manual/zh/function.idate.php
echo 'day of month : ' . idate('d') . PHP_EOL;
echo 'day of year : ' . idate('z') . PHP_EOL;
echo 'money days : ' . idate('t') . PHP_EOL;
