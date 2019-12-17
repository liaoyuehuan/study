<?php
/**
 * Created by PhpStorm.
 * User: hj
 * Date: 2019-12-16
 * Time: 11:14
 */

namespace psr\test\http\message;


use Psr\Http\Message\UriInterface;

class Uri implements UriInterface
{

    private $url;

    private $schema;

    private $host;

    private $port;

    private $userInfo;

    private $path;

    private $query;

    private $fragment;


    public function __construct($url)
    {
        $this->url = $url;
        $info = parse_url($url);
        $this->withScheme($info['scheme'] ?? '');
        $this->withHost($info['host'] ?? '');
        $this->withPort($info['port'] ?? null);
        $this->withUserInfo($info['user'] ?? '', $info['pass'] ?? null);
        $this->withQuery($info['query'] ?? '');
        $this->withFragment($info['fragment'] ?? '');
        $this->withPath($info['path'] ?? '');
    }

    /**
     * 例子：http、https
     * 1、未存在schema时，返回空字符串（If no scheme is present, this method MUST return an empty string.）
     * 2、必须全部小写（The value returned MUST be normalized to lowercase, per RFC 3986）
     * 3、不包含“:”
     * @return string
     */
    public function getScheme()
    {
        return $this->schema;
    }

    /**
     *  例子： http://user:passwd@httpbin.org/basic-auth/user/passw
     *  组成：authority   = [ userinfo "@" ] host [ ":" port ]
     * 1、未存在authority时，返回空字符
     * 2、If the port component is not set or is the standard port for the current scheme, it SHOULD NOT be included.
     * @return string
     */
    public function getAuthority()
    {
        $userInfoString = $this->userInfo ? $this->userInfo . '@' : '';
        $portString = $this->port ? ':' . $this->port : '';
        return $userInfoString . $this->host . $portString;
    }

    /**
     * 例子：xiaoliao[:123456]
     * 1、不存在userInfo时，返回空字符串
     * @return string
     */
    public function getUserInfo()
    {
        return $this->userInfo;
    }

    /**
     * 例子：www.baidu.com
     * 1、不存在host时，返回空字符串
     * 2、必须全部小写，RFC 3986
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }

    public function getPort()
    {
        static $schemaToStandardPort = [
            'https' => 443,
            'http' => 80
        ];
        if ($this->port === null) {
            return null;
        }

        if (isset($schemaToStandardPort[$this->schema]) && $schemaToStandardPort[$this->schema] === $this->port) {
            return null;
        }
        return $this->port;
    }

    public function getPath()
    {
        return $this->path;
    }

    /**
     * 1、为存在query,返回空的字符串
     * 2、？ 不是query的组成部分
     * @return string
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * 例子：https://www.baidu。com?#hello => 返回hello
     * 1、为存在fragment,返回空字符串
     * 2、# 不是fragment的组成部分
     * @return string
     */
    public function getFragment()
    {
        return $this->fragment;
    }

    public function withScheme($scheme)
    {
        if (!is_string($scheme)) {
            throw  new \InvalidArgumentException('invalid schemes');
        }
        $this->schema = strtolower($scheme);
        return $this;
    }

    public function withUserInfo($user, $password = null)
    {
        if ($user) {
            $this->userInfo = $user . ($password ? ':' . $password : '');
        } else {
            $this->userInfo = '';
        }
        return $this;
    }

    public function withHost($host)
    {
        if (!is_string($host)) {
            throw  new \InvalidArgumentException('invalid hostname');
        }
        $this->host = strtolower($host);
        return $this;
    }

    public function withPort($port)
    {
        if ($port === null) {
            $this->port = null;
            return $this;
        }
        if (false === is_int($port) || $port < 1 || $port > 65535) {
            throw  new \InvalidArgumentException('invalid port');
        }
        $this->port = $port;
        return $this;
    }

    public function withPath($path)
    {
        if (!is_string($path)) {
            throw  new \InvalidArgumentException('invalid path');
        }
        $this->path = $this;
        return $this;
    }

    public function withQuery($query)
    {
        if (!is_string($query)) {
            throw  new \InvalidArgumentException('invalid query');
        }
        $this->query = $query;
        return $this;
    }

    public function withFragment($fragment)
    {
        if (!is_string($fragment)) {
            throw  new \InvalidArgumentException('invalid fragment');
        }
        $this->fragment = $fragment;
        return $this;
    }

    public function __toString()
    {
        return $this->url;
    }

}