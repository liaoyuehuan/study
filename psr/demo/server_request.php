<?php
include __DIR__ . '/../../vendor/autoload.php';
$serverRequest = new \psr\test\http\message\ServerRequest($_SERVER);
$serverRequest
    # message
    ->withProtocolVersion(
        substr($_SERVER['SERVER_PROTOCOL'], strpos($_SERVER['SERVER_PROTOCOL'], '/') + 1
        ))
    # ->withBody(file_get_contents('php://input')) // multipart/form-data 不奇效
    # request
    ->withMethod($_SERVER['REQUEST_METHOD'])
    ->withUri(new \psr\test\http\message\Uri($_SERVER['REQUEST_URI']))
    # server
    ->withCookieParams($_COOKIE)
    ->withQueryParams($_GET)
    ->withUploadedFiles(array_map(function ($file) {
        if (is_array($file['name'])) {
            $uploadedFiles = [];
            foreach ($file['name'] as $key => $item) {
                $uploadedFiles[] = new \psr\test\http\message\LocalUploadedFile([
                    'name' => $file['name'][$key],
                    'type' => $file['type'][$key],
                    'tmp_name' => $file['tmp_name'][$key],
                    'error' => $file['error'][$key],
                    'size' => $file['size'][$key],
                ]);
            }
            return $uploadedFiles;
        } else {
            $uploadedFile = new \psr\test\http\message\LocalUploadedFile($file);
            return $uploadedFile;
        }
    }, $_FILES))
    ->withParsedBody($_POST)
    ->withAttribute('request_id', uniqid());
ob_start();
echo "<div>protocolVersion : {$serverRequest->getProtocolVersion()}</div>";
echo "<div>method : {$serverRequest->getMethod()}</div>";
echo "<div>uri : {$serverRequest->getUri()}</div>";
echo "<div>cookies :<div></div>";
echo json_encode($serverRequest->getCookieParams());
echo "<hr></div>";
echo "<div>queryParams :<div></div>";
echo json_encode($serverRequest->getQueryParams());
echo "<hr></div>";
echo "<div>serverParams :<div></div>";
echo json_encode($serverRequest->getServerParams());
echo "<hr></div>";
echo "<div>parsedBody : <div></div>";
echo json_encode($serverRequest->getParsedBody());
echo "<hr></div>";
echo "<div>attributes : <div></div>";
echo json_encode($serverRequest->getAttributes());
echo "<hr></div>";

$response = new \psr\test\http\message\Response();
$response
    ->withProtocolVersion($serverRequest->getProtocolVersion())
    ->withBody(new \psr\test\http\message\RequestBodyStream(ob_get_clean()))
    ->withHeader('Content-Type', 'text/html')
    ->withStatus(200);
header("http/{$response->getProtocolVersion()} {$response->getStatusCode()} {$response->getReasonPhrase()}");
foreach ($response->getHeaders() as $name => $value) {
    header(sprintf('%s: %s', $name, implode($value)));
}
echo $response->getBody();

