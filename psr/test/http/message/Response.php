<?php
/**
 * Created by PhpStorm.
 * User: hj
 * Date: 2019-12-21
 * Time: 16:59
 */

namespace psr\test\http\message;


use Psr\Http\Message\ResponseInterface;

class Response extends Message implements ResponseInterface
{

    private $statusCode;

    private $reasonPhrase;

    static protected $statusToDefaultReasonPhrase = [
        100 => 'Continue',
        101 => 'Switching Protocols',
        102 => 'Processing',
        103 => 'Early Hints',
        # 104 - 199 : Unassigned
        200 => 'OK',
        201 => 'Create',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',
        207 => 'Multi-Status',
        208 => 'Already Reported',
        # 209 - 225 : Unassigned
        226 => 'IM Used',
        # 227 - 299 : Unassigned
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found',
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        306 => '(Unused)',
        307 => 'Temporary Redirect',
        308 => 'Permanent Redirect',
        # 309 - 399 : Unassigned
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allow',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Require',
        408 => 'Request Timeout',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Require',
        412 => 'Precondition Failed',
        413 => 'Payload Too Large',
        414 => 'URI Too Long',
        415 => 'Unsupported Media TYpe',
        416 => 'Range Not Satisfiable',
        417 => 'Expectation Failed',
        # 418 - 420 : Unassigned
        421 => 'Misdirected Request',
        422 => 'Unprocessable Entity',
        423 => 'Locked',
        424 => 'Failed Dependency',
        425 => 'Too Early',
        426 => 'Upgrade Required',
        # 427 : Unassigned
        428 => 'Precondition Required',
        429 => 'Too Many Requests',
        # 430 : Unassigned
        431 => 'Request Header Field Too Large',
        # 432 - 450 : Unassigned，
        451 => 'Unavailable For Legal Reasons',
        # 452 - 499 : Unassigned
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Timeout',
        505 => 'Http Version Not Supported',
        506 => 'Variant Also Negotiates',
        507 => 'Insufficient Storage',
        508 => 'Loop Detected',
        # 509 : Unassigned,
        510 => 'Not Extended',
        511 => 'Network Authentication Required',
        # 511 - 599 : Unassigned
    ];

    public function getStatusCode()
    {
        return (int)$this->statusCode;
    }

    public function withStatus($code, $reasonPhrase = '')
    {
        if (!is_int($code)) {
            throw new \InvalidArgumentException('invalid status code arguments');
        }
        if ($code < 100 || $code > 999) {
            throw new \InvalidArgumentException('invalid status code range');
        }
        $this->statusCode = $code;
        $this->reasonPhrase = $reasonPhrase;
        return $this;
    }

    public function getReasonPhrase()
    {
        if (empty($this->reasonPhrase)) {
            return self::$statusToDefaultReasonPhrase[$this->statusCode];
        }
        return $this->reasonPhrase;
    }

}