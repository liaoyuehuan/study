<?php
$base = new EventBase();

$http = new EventHttp($base);

$http->bind('127.0.0.1', 10001);

$http->setCallback('/hello', function (EventHttpRequest $request, $args = null) {
    echo "-- hello start" . PHP_EOL;
    $buf = new  EventBuffer();
    $buf->add("hello");
    $request->sendReply(200, 'ok', $buf);
    echo "-- hello end" . PHP_EOL;
});

$http->setDefaultCallback(function (EventHttpRequest $request, $args = null) {
    echo "-- default start" . PHP_EOL;
    $buf = $request->getOutputBuffer();
    $buf->add("body : {$request->getInputBuffer()->read(8092)} <br>");
    $buf->add("host : {$request->getHost()} <br>");
    $buf->add("uri : {$request->getUri()} <br>");
    $headers = json_encode($request->getInputHeaders());
    $buf->add("header : {$headers} <br>");
    $request->sendReply(200, 'ok', $buf);
    echo "-- default end" . PHP_EOL;
});
echo "start" . PHP_EOL;
$base->loop();



