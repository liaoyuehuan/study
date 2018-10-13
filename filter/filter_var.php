<?php
$email = '1309893442@q#q.com';
$email = filter_var($email,FILTER_SANITIZE_EMAIL);
echo $email.PHP_EOL;

$validate = filter_var($email,FILTER_VALIDATE_EMAIL);
var_dump( $validate);

#参考链接 ：  https://blog.csdn.net/fafa211/article/details/5054452
#
/**
 *
 */
