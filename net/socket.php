<?php

function panicSocketErr($socket)
{
    echo socket_last_error($socket) . ' : ' . socket_strerror(socket_last_error($socket)) . PHP_EOL;
    $trace = debug_backtrace();
    var_dump($trace);
    exit();
}

/**
 * socket_last_error(resource $socket ) //获取租后一个socket错误码：整数
 * socket_strerror(int $socket_error) //获取socket错误码的描述信息
 */
############################    sockOpen     #######################
function printTransport()
{
    var_dump(stream_get_transports());
}

function testFSockStream()
{

    //fsockopen();
    //pfsockopen();
    //stream_set_blocking() 不支持windows
    //stream_get_meta_data();
    //socket_get_status();
    //stream_get_contents()

    //短连接
    //$resource = fsockopen('47.107.37.69', 9501, $errno, $errstr);
    //长连接

    // http
    $host = '47.107.37.69';
    $port = 9501;
    // https
    // $host = 'ssl://www.baidu.com';
    // $port = 443;

    $resource = pfsockopen($host, $port, $errno, $errstr);
    if (false === $resource) {
        echo "$errstr ($errno)\n";
    } else {
        $http_transport = "GET / HTTP/1.1\r\n";
        $http_transport .= "Host: {$host}:{$port}\r\n";
        $http_transport .= "User-Agent: Mozilla/5.0 (Windows NT 10.0; …) Gecko/20100101 Firefox/63.0\r\n";
        $http_transport .= "Connection: keep-alive\r\n\r\n";

        stream_set_blocking($resource, true);
        stream_set_timeout($resource, 3);
        $result = fwrite($resource, $http_transport);
        if (!$result) {
            panicSocketErr($resource);
        } else {
            $response = '';
            $header = '';
            $start = time();
            while (!feof($resource)) {
                $buf = fgets($resource);;
                if ($buf == "\r\n") {
                    break;
                }
                $header .= $buf;
            }
            while (!feof($resource)) {
                $length = 8192;
                $buf = fread($resource,8192);;
                $response .= $buf;
                if (strlen($buf) < $length) {
                    break;
                }
            }
            //一次读取所有内容
            //$response = stream_get_contents($resource);
            echo (time() - $start).'s'.PHP_EOL;
            echo "header:\r\n" . $header;
            echo "response:\r\n" . $response . PHP_EOL;
        }
    }
}



############################    socket      #######################
/**
 * @todo
 */
function testSocketCreate()
{
    $fp = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
    if (!$fp) {
        die('Unable to create AF_UNIX socket');
    }

    if (!socket_bind($fp, '127.0.0.1', 8888)) {
        die(socket_last_error($fp) . ':' . socket_strerror(socket_last_error($fp)));
    }
}

function printProtos()
{
    $arr = array("ip", "icmp", "ggp", "tcp",
        "egp", "pup", "udp", "hmp", "xns-idp",
        "rdp", "rvd");
//Reads the names of protocols into an array..
    for ($i = 0; $i < 11; $i++) {
        $proname = $arr[$i];
        echo $proname . ":", getprotobyname($proname) . PHP_EOL;
    }
}

/**
 * @todo
 */
function testSocketConnect()
{
    $resource = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
    socket_set_option($resource, SOL_SOCKET, SO_SNDTIMEO, array("sec" => 2, "usec" => 0));
    if (false === $resource) {
        die('create error');
    }

    if (false === socket_connect($resource, '47.107.37.69', 9501)) {
        panicSocketErr($resource);
    }
    $request = "GET / HTTP/1.1\r\n";
    $request .= "Host: 47.107.37.69:9501\r\n";
    $request .= "User-Agent: Mozilla/5.0 (Windows NT 10.0; …) Gecko/20100101 Firefox/63.0\r\n";
    $request .= "Connection: keep-alive\r\n";
    $request .= "\r\n";
    socket_write($resource, $request, strlen($request));
    $response = '';
    $length = 8192;
    while ($buf = socket_read($resource, 8192) ){
        $response .= $buf;
        if ($length > strlen($buf)) {
            break;
        }
    }

    var_dump($response);
    socket_close($resource);

}

function testSocketListen()
{
    $resource = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
    if (false === $resource) {
        dir('socket create fail');
    }

    if (false === socket_bind($resource, '127.0.0.1', 8888)) {
        panicSocketErr($resource);
    };

    echo 'start listening ...' . PHP_EOL;
    if (false === socket_listen($resource)) {
        panicSocketErr($resource);
    }

    do {
        $client = socket_accept($resource);
        socket_write($client, 'connect success' . PHP_EOL);
        do {
            $string = socket_read($client, 1024);
            echo 'server receive is ' . hexdec(bin2hex($string)) . PHP_EOL;
        } while (hexdec(bin2hex($string)) !== 3); //SIGQUIT

        echo 'server receive fail ' . PHP_EOL;
        socket_close($client);
    } while (true);
}


testFSockStream();

