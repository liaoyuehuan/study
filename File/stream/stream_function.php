<?php

class TestStreamFunction
{
    private $file = __DIR__ . '/../files/function.txt';

    private $fp;

    public function __construct()
    {
        $this->fp = fopen($this->file, 'r');
    }

    public function testGetFilterRegister()
    {
        return stream_get_filters();
    }

    public function testFilterAppend()
    {
        stream_filter_append($this->fp, 'string.toupper', STREAM_FILTER_READ);
        $data = fread($this->fp, 10);
        return $data;
    }

    // 获取套接字传输协议列表：udp、tcp、ssl、tls、tlsv1.0、tlsv1.2
    public function testGetTransport()
    {
        return stream_get_transports();
    }

    // 返回已注册并可使用的刘类型列表：php、file、glob、data、http、zip、compress.zlib、https、ftps、phar
    public function testGetWrappers()
    {
        return stream_get_wrappers();
    }

    // 判断流是都是本地流。http就不是本地的
    public function testCheckoutIsLocal()
    {
        return stream_is_local($this->fp);
    }
}

$obj = new TestStreamFunction();
$res = $obj->testCheckoutIsLocal();
var_dump($res);