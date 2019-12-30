<?php
/**
 * Created by PhpStorm.
 * User: hj
 * Date: 2019-12-20
 * Time: 18:21
 */

namespace psr\test\http\message;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UploadedFileInterface;

/**
 * Class ServerRequest
 * 封装的数据：
 * 1、$_SERVER
 * 2、$_COOKIE
 * 3、$_GET or parse via parse_url()
 * 4、$_FILES
 * 5、$_POST or deSerialized body parameters
 * 注意：
 * 1、$_SERVER 是不可改变的
 *
 * @package psr\test\http\message
 */
class ServerRequest extends Request implements ServerRequestInterface
{

    protected $serverParams;

    protected $cookieParams;

    protected $queryParams;

    protected $uploadedFiles;

    private $parsedBody;

    private $attributes = [];


    public function __construct(array $serverParams = [])
    {
        $this->serverParams = $serverParams;
    }

    /**
     * @return array
     */
    public function getServerParams()
    {
        return $this->serverParams ?? [];
    }

    public function getCookieParams()
    {
        return $this->cookieParams ?? [];
    }

    public function withCookieParams(array $cookies)
    {
        $this->cookies = $cookies;
        return $this;
    }

    public function getQueryParams()
    {
        return $this->queryParams ?? null;
    }

    /**
     * 例子：$_GET
     * @param array $query
     * @return $this|ServerRequestInterface
     */
    public function withQueryParams(array $query)
    {
        $this->queryParams = $query;
        return $this;
    }

    /**
     * 注意：
     * 1、无文件时，必须返回空数组 array
     * @return array
     */
    public function getUploadedFiles()
    {
        return $this->uploadedFiles;
    }

    /**
     * @param UploadedFileInterface[] $uploadedFiles
     * @return $this|ServerRequestInterface
     */
    public function withUploadedFiles(array $uploadedFiles)
    {
        $this->uploadedFiles = $uploadedFiles;
        return $this;
    }

    /**
     * @return array|null|\stdClass
     */
    public function getParsedBody()
    {
        return $this->parsedBody;
    }

    /**
     * 例子：$_POST
     * @param array|null|\stdClass $data
     * @return $this|ServerRequestInterface
     */
    public function withParsedBody($data)
    {
        if (!is_null($data) && !is_array($data) && !is_object($data)) {
            throw new \InvalidArgumentException('an unsupported argument type is provided.');
        }
        $this->parsedBody = $data;
        return $this;
    }

    public function getAttributes()
    {
        return $this->attributes;
    }

    public function getAttribute($name, $default = null)
    {
        return $this->attributes[$name] ?? $default;
    }

    public function withAttribute($name, $value)
    {
        $this->attributes[$name] = $value;
        return $this;
    }

    public function withoutAttribute($name)
    {
        if (array_key_exists($name, $this->attributes)) {
            unset($this->attributes[$name]);
        }
        return $this;
    }
}