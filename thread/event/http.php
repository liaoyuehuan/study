<?php
$base = new EventBase();

$http = new EventHttp($base);

$http->bind('0.0.0.0', 10002);

$http->setCallback('/hello', function (EventHttpRequest $request, $args = null) {
    echo "-- hello start" . PHP_EOL;
    $buf = new  EventBuffer();
    $buf->add("hello");
    $request->sendReply(200, 'ok', $buf);
    serialize($request);
    echo "-- hello end" . PHP_EOL;
});

$http->setCallback('/connection/close', function (EventHttpRequest $request, $arg = null) {
    echo "-- connection/close start" . PHP_EOL;
    $request->closeConnection();
    echo "-- connection/close end" . PHP_EOL;
});

$http->setCallback('/pressure/test', function (EventHttpRequest $request, $arg = null) {
    $buf = $request->getOutputBuffer();
    $buf->add('hello');
    $request->sendReply(200,'ok',$buf);
});

$http->setCallback('/error',function (EventHttpRequest $request, $arg = null){
    $buf = $request->getOutputBuffer();
    // $request->sendReplyChunk($buf); 没有用
    $request->sendError(400);
});

$http->setDefaultCallback(function (EventHttpRequest $request, $args = null) {
    echo "-- default start" . PHP_EOL;
    $buf = $request->getOutputBuffer();
    $buf->add("body : {$request->getInputBuffer()->read(8092)} <br>");
    $buf->add("host : {$request->getHost()} <br>");
    $buf->add("uri : {$request->getUri()} <br>");
    $buf->add("command : {$request->getCommand()} <br>");
    $headers = json_encode($request->getInputHeaders());
    $buf->add("header : {$headers} <br>");

    # 设置响应头部
    $request->addHeader('oss-timestamp', time(), EventHttpRequest::OUTPUT_HEADER);
    $request->sendReply(200, 'ok', $buf);
    echo "-- default end" . PHP_EOL;
});
echo "start" . PHP_EOL;
$base->loop();



