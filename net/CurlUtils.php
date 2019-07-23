<?php
/**
 * Created by PhpStorm.
 * User: hj
 * Date: 2019/4/10
 * Time: 13:59
 */

class CurlUtils
{
    public static function getHeader($url)
    {
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            # 证书校验设置
            CURLOPT_SSL_VERIFYPEER => false, // 取消证书校验，要验证时设置  CURLOPT_CAINFO 或 CURLOPT_CAPATH
            CURLOPT_SSL_VERIFYHOST => false, // 检查证书的域名时候和你访问的域名一致（即：证书的"common name"）
//            CURLOPT_RANGE => '0-1',
            # 头部信息设置

            CURLOPT_HEADER => true, // 响应时输出头部信息
            CURLOPT_HTTPHEADER => [
                ''
            ], //设置请求头信息

            CURLOPT_RETURNTRANSFER => true,

//            CURLOPT_NOBODY => false,
        ]);
        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            return false;
        }
        $start = strpos($response, "\r\n") + 2;
        $end = strpos($response, "\r\n\r\n");
        $header = substr($response, $start, $end - $start);
        $headers = [];
        $headerArr = explode("\r\n", $header);
        array_walk($headerArr, function ($value) use (&$headers) {
            $headerArr = explode(': ', $value);
            $headers[$headerArr[0]] = $headerArr[1];
        });
        return $headers;
    }

    public static function getContentSizeFromHeader($header)
    {
        if (false === isset($header['Content-Range'])) {
            return false;
        }
        $contentSize = substr($header['Content-Range'], strpos($header['Content-Range'], '/') + 1);
        return $contentSize;
    }

    public static function getExtensionFromHeader($header)
    {
        if (false === isset($header['Content-Type'])) {
            return false;
        }
        if ($pos = strpos($header['Content-Type'], ';')) {
            $header['Content-Type'] = substr($header['Content-Type'], 0, $pos);
        }
        $mimeTypeToExtension = [
            'application/msword' => 'doc',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'docx',
            'application/pdf' => 'pdf',
            'application/zip' => 'zip',
            'text/plain' => 'txt',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => 'xlsx',
            'application/vnd.ms-excel' => 'xls',
            'image/png' => 'png',
            'image/jpeg' => 'jpeg',
            'image/jpg' => 'jpg',
            'image/gif' => 'gif',
            'application/octet-stream' => 'stream'
        ];
        if (false === isset($mimeTypeToExtension[$header['Content-Type']])) {
            return false;
        }
        return $mimeTypeToExtension[$header['Content-Type']];
    }

    public static function getExtensionFromUrl($url)
    {
        $urlInfo = pathinfo($url);
        return isset($urlInfo['extension']) ? $urlInfo['extension'] : null;
    }

    public static function multiDownload($url, $size, $chunkSize, callable $afterExecAll)
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
            call_user_func_array($callFunction, [$pos, $endPos]);
        }
    }
}