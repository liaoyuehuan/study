<?php
$runner = function ($workerId, \parallel\Channel $channel) {
    while ($data = $channel->recv()) {
        $data = $channel->recv();
        echo "worker_id : {$workerId} - {$data}" . PHP_EOL;
    }
};

$channel = parallel\Channel::make('test_channel');
$runtimeList = [];
$workerNum = 5;
for ($i = 0; $i <= $workerNum; $i++) {
    $runtimeList[$i] = new \parallel\Runtime();
}
for ($i = 0; $i <= $workerNum; $i++) {
    $runtimeList[$i]->run($runner, [$i, $channel]);
}

while (true) {
    $i++;
    usleep(1000 * mt_rand(100, 999));
    $channel->send("hello_{$i}");
}