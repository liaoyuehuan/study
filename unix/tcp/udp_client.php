<?php
# socket 创建
$resource = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);

# sendto
$writBuf = 'hello udp server';
socket_sendto($resource, $writBuf, strlen($writBuf), 0, '127.0.0.1',10080);

$read = socket_read($resource, 1024);
echo 'read : ' . $read . PHP_EOL;