<?php
# socket 创建
$resource = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
# connect
socket_connect($resource, '127.0.0.1', 10080);
# write
$writeBuf = 'hello server';
socket_write($resource, $writeBuf, strlen($writeBuf));
# read
$buf = socket_read($resource, 1024);
echo 'read : ' . $buf . PHP_EOL;