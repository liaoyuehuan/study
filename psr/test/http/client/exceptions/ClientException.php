<?php
/**
 * Created by PhpStorm.
 * User: hj
 * Date: 2019-12-25
 * Time: 11:28
 */

namespace psr\test\http\client\exceptions;


use Psr\Http\Client\ClientExceptionInterface;

class ClientException extends \RuntimeException implements ClientExceptionInterface
{

}