<?php

# 创建socket
$resource = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

# bind
socket_bind($resource, '0.0.0.0', '10080');

# listen
socket_listen($resource, 1082);

# accept
$clientResource = socket_accept($resource);

# 获取客户端的真实IP、端口
socket_getpeername($clientResource, $address, $port);

# read
$buf = socket_read($clientResource, 1000);
echo 'read ： ' . $buf . PHP_EOL;

# write
$writeBuf = 'hello client';
socket_write($clientResource, 'hello client', strlen($writeBuf));



