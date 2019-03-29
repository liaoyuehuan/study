<?php
$ch = curl_init('https://ebg.conzhu.net/index.php');
curl_setopt_array($ch, [

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
//    ],

    CURLOPT_RETURNTRANSFER => true,

    # post 设置
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => [
        'a' => 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaa',
        'b' => 'bbbbbbbbbbbbbbbbbbbbbbbbbbbbb',
        'c' => 'ccccccccccccccccccccccccccccc'
    ]

]);

$response = curl_exec($ch);

$curlInfo = curl_getinfo($ch);

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

$httpCode = curl_getinfo($ch,CURLINFO_HTTP_CODE);
var_dump($httpCode);

