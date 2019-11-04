<?php

# 创建socket
$resource = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);

# bind
socket_bind($resource, '0.0.0.0', '10080');

while (true) {
    socket_set_block($resource);
    socket_recvfrom($resource, $buf, 8096, 0, $address, $port);
    echo 'read : ' . $buf . PHP_EOL;
    socket_set_nonblock($resource);
    $writeBuf = 'hello udp client';
    socket_sendto($resource, $writeBuf, strlen($writeBuf), 0, $address, $port);

}
