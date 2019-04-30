<?php
$email = '1309893442@q#q.com';
$email = filter_var($email, FILTER_SANITIZE_EMAIL);
echo $email . PHP_EOL;

$validate = filter_var($email, FILTER_VALIDATE_EMAIL);
echo 'FILTER_VALIDATE_EMAIL : ' . $validate . PHP_EOL;

$ip = '127.0.0.1';
$validate = filter_var($ip, FILTER_VALIDATE_IP);
echo 'FILTER_VALIDATE_IP : ' . $validate . PHP_EOL;


$url = 'https://www.pdflib.com/download/pdflib-product-family/';
$validate = filter_var($ip, FILTER_VALIDATE_URL);
echo 'FILTER_VALIDATE_URL : ' . $validate . PHP_EOL;


#参考链接 ：  https://blog.csdn.net/fafa211/article/details/5054452
#
/**
 *
 */
