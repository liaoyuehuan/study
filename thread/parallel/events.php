<?php
$runner = function ($channel) {
    $events = new parallel\Events();
    $events->addChannel($channel);
    $events->setBlocking(true);
//    $events->setTimeout(1000000);
    while (true) {
        $event = $events->poll();
        var_dump($event);
        $events->addChannel($channel);
        if ($event->type == parallel\Events\Event\Type::Read) {
            $data = $event->object->recv();
            echo "source : {$event->source}, data : {$data}" . PHP_EOL;
        };
    }
};
$runnerSend = function ($channel) {
    $i = 0;
    while (true) {
        $i++;
        $channel->send("hi_{$i}");
        sleep(1);
    }
};
$channel = new parallel\Channel();
$runtime = new parallel\Runtime();
$runtimeSend = new parallel\Runtime();
$runtime->run($runner, [$channel]);
$runtimeSend->run($runnerSend, [$channel]);


