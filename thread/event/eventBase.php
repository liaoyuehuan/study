<?php

$eventBase = new EventBase();

# 创建socket
$resource = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

# bind
socket_bind($resource, '0.0.0.0', '10080');

# listen
socket_listen($resource, 1082);

socket_set_nonblock($resource);

# 客户端资源对象存储
$clientList = [];

# 事件资源对象存储
$eventList = [];

function accept($fd, $what, $eventBase)
{
    global $clientList;
    global $eventList;
    # accept
    $clientResource = socket_accept($fd);
    $id = (int)($clientResource);
    # 设置非阻塞
//    socket_set_nonblock($clientResource);

    # 客户端socket的read事件
    $eventList[$id] = new Event($eventBase, $clientResource, Event::READ | Event::PERSIST, function ($fd, $what, $args = null) use(&$eventBase) {
        global $clientList, $eventList;
        $id = (int)$fd;
        # read
        $buf = socket_read($fd, 8192);

        # false一般是，客户端非法断开（需要删除event对象和移除client对象）
        if ($buf === false) {
            unset($eventList[$id], $clientList[$id]);
            return '';
        }

        # 退出整个服务
        if (ord($buf) === 3) {
            $eventBase->exit();
        }

        // 打印读取的数据
        echo 'read ： ' . $buf . PHP_EOL;
        # write
        $writeBuf = 'hello client';
        socket_write($fd, 'hello client', strlen($writeBuf));
    });
    # 执行event->add()，使事件挂起
    $eventList[$id]->add();
    # 一定要绑定"$clientResource"，否则"$clientResource"会释放对象，导致客户端断开连接
    $clientList[$id] = $clientResource;
}

$event = new Event($eventBase, $resource, Event::READ | Event::PERSIST, 'accept', $eventBase);

$event->add();

echo "start" . PHP_EOL;
$eventBase->loop(EVentBase::STARTUP_IOCP);

