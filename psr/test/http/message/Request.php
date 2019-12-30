<?php
/**
 * Created by PhpStorm.
 * User: hj
 * Date: 2019-12-19
 * Time: 10:07
 */

namespace psr\test\http\message;


use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\UriInterface;

class Request extends Message implements RequestInterface
{

    protected $requestTarget;

    protected $method;


    /**
     * @return string
     */
    public function getRequestTarget()
    {
        return $this->requestTarget ?? '/';
    }

    public function withRequestTarget($requestTarget)
    {
        $this->requestTarget = $requestTarget;
        return $this;
    }

    public function getMethod()
    {
        return $this->method;
    }


    /**
     * 注意：
     * 1、大小写区分
     * 2、不要改变参数的值
     * @param string $method
     * @return $this|RequestInterface
     */
    public function withMethod($method)
    {
        $this->method = strtoupper($method);
        return $this;
    }

    public function getUri()
    {
        return $this->uri;
    }

    public function withUri(UriInterface $uri, $preserveHost = false)
    {
        if (false === $this->hasHeader('host')) {
            $this->withHeader('host', $uri->getHost());
        } else {
            if (!$preserveHost) {
                $this->withHeader('host', $uri->getHost());
            }
        }
        $this->uri = $uri;
        return $this;
    }

}