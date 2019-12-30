<?php

function testCurl()
{
    $url = 'https://ebg.conzhu.net:443/index.php';
    $ch = curl_init();
    # 支持参数中文操作
    $urlInfo = parse_url($url);
    !isset($urlInfo['host']) &&  $urlInfo['host'] = 80;
    $requestUrl = "{$urlInfo['scheme']}://{$urlInfo['host']}:{$urlInfo['port']}{$urlInfo['path']}";
    if (!empty($urlInfo['query'])) {
        parse_str($urlInfo['query'], $paramArr);
        $requestUrl .= '?' . http_build_query($paramArr);
    }

    curl_setopt_array($ch, [

        CURLOPT_URL => $requestUrl,

        # 证书校验设置
        CURLOPT_SSL_VERIFYPEER => false, // 取消证书校验，要验证时设置  CURLOPT_CAINFO 或 CURLOPT_CAPATH
        CURLOPT_SSL_VERIFYHOST => false, // 检查证书的域名时候和你访问的域名一致（即：证书的"common name"）

        # TCP长连接设置
        CURLOPT_TCP_KEEPALIVE => true,
        CURLOPT_TCP_KEEPINTVL => 60,
        CURLOPT_TCP_KEEPALIVE => 60,

        # TCP 设置
        # 理解MSS(Maximum Segment Size) 最大报文段长度
        CURLOPT_TCP_NODELAY => true, //禁用tcp的nagle算法。对于小包（如：心跳检测、按键数据）或延迟敏感的数据禁用是个不错的选择
        #CURLOPT_TCP_FASTOPEN => true //有提高性能作用。大于7.0.7 地址：https://blog.csdn.net/for_tech/article/details/54237556

        # 头部信息设置
        CURLOPT_HEADER => true, // 响应时输出头部信息
        CURLOPT_HTTPHEADER => [], //设置请求头信息

        # cookies 设置
        # CURLOPT_COOKIE => 'name1=content1; name2=content2;',
        CURLOPT_COOKIEFILE => __DIR__ . '/curl_cookies.txt', //文件中读取请求的cookies
        CURLOPT_COOKIEJAR => __DIR__ . '/curl_cookies.txt',   //保存服务器响应的cookies到指定文件中
        CURLOPT_COOKIESESSION => true, // 启用后。只传递一个session的cookies。默认全部传递

        # 上传文件设置
//    CURLOPT_UPLOAD => true,  //开启文件上传
//    CURLOPT_POST => true,
//    CURLOPT_POSTFIELDS => [
//        'file' => new CURLFile('aa.png', 'image/png', 'test_file')
        # 多文件上传
//        'files[0]' => 'D:/32dd13da-547f-4c22-a343-e2d0e478d825_src(2).pdf',
//        'files[2]' => 'D:/hg.pdf'
//    ],

        CURLOPT_RETURNTRANSFER => true,

        # post 设置
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => [
            'a' => 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaa',
            'b' => 'bbbbbbbbbbbbbbbbbbbbbbbbbbbbb',
            'c' => 'ccccccccccccccccccccccccccccc'
        ],

        # body
        # CURLOPT_NOBODY => true, // 不返回响应体（注：可能会造成“Content-Range”不返回）
        # CURLOPT_RANGE => '1-100', // 设置响应体数据范围

        # 设置basic验证
        # CURLOPT_HTTPAUTH => CURLAUTH_ANY,
        # CURLOPT_USERPWD => $this->username . ':' . $this->password

        # 设置证书
        CURLOPT_SSLCERTTYPE => 'PEM',
        CURLOPT_SSLCERT => __DIR__ . '/cert/apiclient_cert.pem',
        CURLOPT_SSLKEYTYPE => 'PEM',
        CURLOPT_SSLKEY => __DIR__ . '/cert/apiclient_key.pem',
        
        # 允许重定向
        CURLOPT_FOLLOWLOCATION => true,

        # 查看请求头
        CURLOPT_VERBOSE => true
    ]);
    $response = curl_exec($ch);


    $curlInfo = curl_getinfo($ch);
    var_dump($curlInfo);
# info 重要参数介绍
    [
        # 通用
        'http_code' => 200,// 状态码
        'content_tupe' => 'text/html; charset=UTF-8',
        'download_content_length' => -1, // 从Content-Length 读取的数值。没有时是 -1

        # 时间
        'total_time' => 0.984, // 最后一次执行消耗的时间
        'namelookup_time' => 0.016, // 可能时域名解析消耗的时间
        'connect_time' => 0.031, // 建立链接所消耗的时间

        # 通信
        'primary_ip' => '120.78.32.148', // 域名解析的ip,
        'primary_port' => 443, // 服务端口
        'local_ip' => '120.78.32.148',// 本地ip
        'local_port' => 50702, // 本地端口

        # 速度（单位：字节）
        'size_upload' => 403, // 上传数据的总量
        'size_download' => 11, // 下载数据的总量
        'speed_download' => 11, // 平均下载速度
        'speed_upload' => 415 // 平均上传速度
    ];

    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
}

//var_dump($httpCode);

#### 获取url头部信息
function getUrlHeader()
{
    $ch = curl_init('http://cz-files.oss-cn-shenzhen.aliyuncs.com/pdf_tempe298c69fe1d0cf685a91f2bce4885ff9.doc');
    curl_setopt_array($ch, [
        # 证书校验设置
        CURLOPT_SSL_VERIFYPEER => false, // 取消证书校验，要验证时设置  CURLOPT_CAINFO 或 CURLOPT_CAPATH
        CURLOPT_SSL_VERIFYHOST => false, // 检查证书的域名时候和你访问的域名一致（即：证书的"common name"）
        CURLOPT_RANGE => '0-10',
        # 头部信息设置

        CURLOPT_HEADER => true, // 响应时输出头部信息
        CURLOPT_HTTPHEADER => [
            ''
        ], //设置请求头信息

        CURLOPT_RETURNTRANSFER => true,

//        CURLOPT_CUSTOMREQUEST => 'HEAD',
        CURLOPT_NOBODY => true
    ]);
    $response = curl_exec($ch);

    $start = strpos($response, "\r\n") + 2;
    $end = strpos($response, "\r\n\r\n");
    $header = substr($response, $start, $end - $start);
    $headers = [];
    $headerList = explode("\r\n", $header);
    array_walk($headerList, function ($value) use (&$headers) {
        $headerArr = explode(': ', $value);
        $headers[$headerArr[0]] = $headerArr[1];
    });

    $contentSize = substr($headers['Content-Range'], strpos($headers['Content-Range'], '/') + 1);
}

####  下载大文件
function downBigUrl()
{
    $url = 'http://www.wysggzy.cn/wysebid/website/file/CA证书下载.zip';
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        # 证书校验设置
        CURLOPT_SSL_VERIFYPEER => false, // 取消证书校验，要验证时设置  CURLOPT_CAINFO 或 CURLOPT_CAPATH
        CURLOPT_SSL_VERIFYHOST => false, // 检查证书的域名时候和你访问的域名一致（即：证书的"common name"）
        CURLOPT_RANGE => '0-10',
        # 头部信息设置

        CURLOPT_HEADER => true, // 响应时输出头部信息
        CURLOPT_HTTPHEADER => [
            ''
        ], //设置请求头信息

        CURLOPT_RETURNTRANSFER => true,
    ]);
    $response = curl_exec($ch);
    $start = strpos($response, "\r\n") + 2;
    $end = strpos($response, "\r\n\r\n");
    $header = substr($response, $start, $end - $start);
    $headers = [];
    array_walk(explode("\r\n", $header), function ($value) use (&$headers) {
        $headerArr = explode(': ', $value);
        $headers[$headerArr[0]] = $headerArr[1];
    });
    $contentSize = substr($headers['Content-Range'], strpos($headers['Content-Range'], '/') + 1);;

    $contentSize = (int)($contentSize);
    var_dump($contentSize);
    $chunkSize = 1024 * 1024 * 1;

    $size = 0;
    $start = floor(microtime(true) * 1000);
    $p = fopen('D:/aa.zip', 'w+');
    curlMultiDownload($url, $contentSize, $chunkSize, function ($chunkBuffer) use (&$size, &$p) {
        fwrite($p, $chunkBuffer, strlen($chunkBuffer));
        $size += strlen($chunkBuffer);
        echo strlen($chunkBuffer) . ' : ' . $size . PHP_EOL;
    });
    fclose($p);
    $end = floor(microtime(true) * 1000);
    echo ($end - $start) . 'ms' . PHP_EOL;
}

function curlMultiDownload($url, $size, $chunkSize, callable $afterExecAll)
{
    $callFunction = function ($pos, $endPos) use ($url, $chunkSize, $afterExecAll) {
        $chs = [];
        for (; $pos < $endPos - 1; $pos += $chunkSize) {
            $handle = curl_init($url);
            $end = $pos + $chunkSize;

            if ($end >= $endPos) {
                $end = $endPos - 1;
            }
            curl_setopt_array($handle, [
                CURLOPT_SSL_VERIFYPEER => false, // 取消证书校验，要验证时设置  CURLOPT_CAINFO 或 CURLOPT_CAPATH
                CURLOPT_SSL_VERIFYHOST => false, // 检查证书的域名时候和你访问的域名一致（即：证书的"common name"）
                CURLOPT_RANGE => "{$pos}-{$end}",
                # 头部信息设置

                CURLOPT_HEADER => false, // 响应时输出头部信息
                CURLOPT_HTTPHEADER => [
                    ''
                ], //设置请求头信息

                CURLOPT_RETURNTRANSFER => true,
            ]);

            $chs[] = [
                'size' => ($end - $pos + 1),
                'handle' => $handle
            ];
            $pos++;
        }

        $mh = curl_multi_init();
        foreach ($chs as $ch) {
            curl_multi_add_handle($mh, $ch['handle']);
        }
        do {
            $mr = curl_multi_exec($mh, $active);
        } while ($mr == CURLM_CALL_MULTI_PERFORM);
        do {
            curl_multi_select($mh, 0.5);
            $mr = curl_multi_exec($mh, $active);
        } while ($mr == CURLM_OK && $active);

        foreach ($chs as $ch) {
            $failedCount = 0;
            $maxAllowFailedCount = 5;
            $buffer = curl_multi_getcontent($ch['handle']);
            $reCall = function () use ($ch, &$maxAllowFailedCount, &$failedCount, &$reCall) {
                $ch['handle'] = curl_copy_handle($ch['handle']);
                $buffer = curl_exec($ch['handle']);
                try {
                    if (curl_errno($ch['handle'])) {
                        throw new Exception(curl_error($ch['handle']), curl_errno($ch['handle']));
                    }
                    echo strlen($buffer) . ' -- ' . $ch['size'] . PHP_EOL;
                    if (strlen($buffer) != $ch['size']) {
                        throw new Exception('buffer not complete');
                    }
                } catch (Exception $e) {
                    var_dump($e->getMessage());
                    $failedCount++;
                    if ($failedCount <= $maxAllowFailedCount) {
                        $failedCount++;
                        return call_user_func($reCall);
                    }
                } finally {
                    curl_close($ch['handle']);
                }
                return $buffer;
            };
            if (strlen($buffer) != $ch['size']) {
                $buffer = call_user_func($reCall);
            }
            call_user_func_array($afterExecAll, [$buffer]);
            curl_multi_remove_handle($mh, $ch['handle']);
        }
        curl_multi_close($mh);
        unset($chs);
    };
    $maxBufferSize = 1024 * 1024 * 30;
    for ($pos = 0; $pos < $size; $pos += $maxBufferSize) {
        $endPos = $pos + $maxBufferSize;
        if ($endPos > $size) {
            $endPos = $size;
        }
        var_dump([$pos, $endPos]);
        call_user_func_array($callFunction, [$pos, $endPos]);
    }
}

testCurl();