<?php

include __DIR__ . '/../../vendor/autoload.php';

$httpClint = new \psr\test\http\client\CurlClient();
$request = (new \psr\test\http\message\Request())
    ->withBody(new \psr\test\http\message\RequestBodyStream(http_build_query(['name' => 'a'])))
    ->withHeader("Content-Type", 'application/json')
    ->withUri(new \psr\test\http\message\Uri('http://127.0.0.1:8008/api/v1/index.php'))
    ->withMethod('post');
try {
    $response = $httpClint->sendRequest($request);
    var_dump($response->getBody()->getContents());
} catch (\Psr\Http\Client\ClientExceptionInterface $e) {
    echo $e->getTraceAsString();
}
