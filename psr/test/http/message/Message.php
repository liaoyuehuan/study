<?php
/**
 * Created by PhpStorm.
 * User: hj
 * Date: 2019-12-21
 * Time: 17:02
 */

namespace psr\test\http\message;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;
use Psr\Http\Message\MessageInterface;

class Message implements MessageInterface
{
    /**
     * @var UriInterface
     */
    protected $uri;

    protected $version;

    /**
     * @var [][]string
     */
    protected $headers;

    /**
     * @var StreamInterface
     */
    protected $body;

    /**
     * 说明：HTTP protocol version
     * 例子：”1.1“，”1.0“,”2.0“
     * @return string
     */
    public function getProtocolVersion()
    {
        return $this->version;
    }

    public function withProtocolVersion($version)
    {
        $this->version = $version;
        return $this;
    }

    public function getHeaders()
    {
        return $this->headers;
    }

    public function hasHeader($name)
    {
        return isset($this->headers[$this->getTrueName($name)]);
    }

    /**
     * @param string $name
     * @return array
     */
    public function getHeader($name)
    {
        return $this->headers[$this->getTrueName($name)] ?? [];
    }

    /**
     * @param string $name
     * @return string
     */
    public function getHeaderLine($name)
    {
        $header = $this->getHeader($name);
        return $header ? implode(',', $header) : '';
    }

    /**
     * @param string $name
     * @param string|string[] $value
     * @return $this|RequestInterface
     */
    public function withHeader($name, $value)
    {
        $trueName = $this->getTrueName($name);
        if (is_string($value)) {
            $this->headers[$trueName] = [$value];
        } else if (is_array($value)) {
            false === isset($this->headers[$trueName]) && $this->headers[$trueName] = [];
            $this->headers[$trueName] = $value;
        } else {
            throw new \InvalidArgumentException('invalid header value');
        }
        return $this;
    }

    /**
     * @param string $name
     * @param string|string[] $value
     * @return $this|RequestInterface
     */
    public function withAddedHeader($name, $value)
    {
        $trueName = $this->getTrueName($name);
        false === isset($this->headers[$trueName]) && $this->headers[$trueName] = [];
        $this->headers[$trueName] = $value;
        return $this;
    }

    /**
     * @param string $name
     * @return $this|RequestInterface
     */
    public function withoutHeader($name)
    {
        $trueName = $this->getTrueName($name);
        if (array_key_exists($trueName, $this->headers)) {
            unset($this->headers[$trueName]);
        }
        return $this;
    }

    /**
     * @return StreamInterface|RequestBodyStream
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param StreamInterface $body
     * @return $this|RequestInterface
     */
    public function withBody(StreamInterface $body)
    {
        $this->body = $body;
        return $this;
    }

    private function getTrueName($name)
    {
        return strtolower($name);
    }
}