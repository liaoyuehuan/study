<?php
/**
 * Created by PhpStorm.
 * User: hj
 * Date: 2019-12-25
 * Time: 11:27
 */

namespace psr\test\http\client\exceptions;


use Psr\Http\Client\RequestExceptionInterface;
use Psr\Http\Message\RequestInterface;

class RequestException extends ClientException implements RequestExceptionInterface
{
    private $request;

    public function __construct(RequestInterface $request, string $message = "", int $code = 0, \Throwable $previous = null)
    {
        $this->request = $request;
        parent::__construct($message, $code, $previous);
    }

    public function getRequest(): RequestInterface
    {
        return $this->request;
    }

}