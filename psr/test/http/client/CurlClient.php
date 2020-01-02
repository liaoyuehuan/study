<?php
/**
 * Created by PhpStorm.
 * User: hj
 * Date: 2019-12-25
 * Time: 10:48
 */

namespace psr\test\http\client;


use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use psr\test\http\client\exceptions\HostNotFoundException;
use psr\test\http\client\exceptions\RequestException;
use psr\test\http\message\RequestBodyStream;
use psr\test\http\message\Response;

class CurlClient implements ClientInterface
{
    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        if (empty($request->getUri()->getHost())) {
            throw new HostNotFoundException($request, 'host not found');
        }

        $ch = curl_init($request->getUri());
        if ($headers = $request->getHeaders()) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, array_map(function ($name) use ($request) {
                return $name . ': ' . $request->getHeaderLine($name);
            }, array_keys($headers)));
        }

        if ($request->getMethod() === 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, (string)$request->getBody());
        }
        if ($request->getUri()->getScheme() === 'https') {
            curl_setopt_array($ch, [
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_SSL_VERIFYPEER => false,
            ]);
        }
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 10,
        ]);

        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            throw new RequestException($request, sprintf("curl error : %s, error_msg : %s", curl_errno($ch), curl_error($ch)));
        }
        return (new Response())->withBody(new RequestBodyStream($response))->withStatus(curl_getinfo($ch, CURLINFO_HTTP_CODE));
    }

}