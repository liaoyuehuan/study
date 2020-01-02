<?php
include __DIR__ . '/../../vendor/autoload.php';
$body = new \psr\test\http\message\RequestBodyStream();
$body->write("hello");
$len = $body->write(" world");
echo "write len : {$len}" . PHP_EOL;

echo "size : {$body->getSize()}" . PHP_EOL;

echo "tell : {$body->tell()}" . PHP_EOL;

$body->seek(1);

echo "seek : 1" . PHP_EOL;

echo "eof : {$body->eof()}" . PHP_EOL;

echo "_toString : {$body}" . PHP_EOL;






