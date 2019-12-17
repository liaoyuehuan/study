<?php
include __DIR__ . '/../../vendor/autoload.php';

$url = 'https://liao@123456@esb.conzhu.com:443/?name=xiaoliao#a';
$uri = new \psr\test\http\message\Uri($url);
echo "schema : {$uri->getScheme()}" . PHP_EOL;

echo "host : {$uri->getHost()}" . PHP_EOL;

echo "port : {$uri->getPort()}" . PHP_EOL;

echo "authority : {$uri->getAuthority()}" . PHP_EOL;

echo "userInfp : {$uri->getUserInfo()}" . PHP_EOL;

echo "path : {$uri->getPath()}" . PHP_EOL;

echo "query : {$uri->getQuery()}" . PHP_EOL;

echo "fragment : {$uri->getFragment()}" . PHP_EOL;

echo "_toString : {$uri}" . PHP_EOL;