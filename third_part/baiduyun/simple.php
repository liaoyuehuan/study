<?php

class TestBaidu
{
    public function request($servicePath, $param)
    {
        $timestamp = gmdate('Y-m-d\TH:i:s\Z');
        $accessKeyId = '550ebfb039784b989f3d432a4814d598';
        $expirationPeriodInSeconds = 1800;
        $authStringPrefix = "bce-auth-v1/{$accessKeyId}/{$timestamp}/{$expirationPeriodInSeconds}";
        echo "authStringPrefix : {$authStringPrefix}" . PHP_EOL;
        $rHttpMethod = 'POST';
        $rCanonicalURI = $servicePath;
        $rCanonicalQueryString = '';

        # 生成 $rCanonicalHeader
        $headers = [
            'host' => 'aip.baidubce.com',
            'x-bce-date' => $timestamp,
            'x-bce-request-id' => uniqid(),
        ];
        $headers = array_change_key_case($headers, CASE_LOWER);
        $headerValues = [];
        foreach ($headers as $name => $value) {
            $headerValues[] = urlencode($name) . ':' . urlencode($value);
        }
        sort($headerValues);
        $rCanonicalHeader = implode("\n", $headerValues);

        # 生成 $canonicalRequest
        $canonicalRequest = implode("\n", [
            $rHttpMethod,
            $rCanonicalURI,
            $rCanonicalQueryString,
            $rCanonicalHeader
        ]);
        echo ($canonicalRequest) . PHP_EOL;

        # 生成 $signedHeaders
        $headerKeys = array_keys($headers);
        sort($headerKeys);
        $signedHeaders = implode(';', $headerKeys);

        # 生成 $signingKey
        $accessSecret = '4c6a395d39ed4eceba08f2cec51aacdf';
        $signingKey = hash_hmac('sha256', $authStringPrefix, $accessSecret);
        echo "signingKey : {$signingKey}" . PHP_EOL;

        # 生成 $signature
        $signature = hash_hmac('sha256', $canonicalRequest, $signingKey);
        echo "signature : {$signature}" . PHP_EOL;

        # 生成 $authorization
        $authorization = "{$authStringPrefix}/{$signedHeaders}/$signature";
        echo "authorization : {$authorization}" . PHP_EOL;

        # 生成 $body
        $body = http_build_query($param);

        $httpHeaders = array_merge($headers, [
            'authorization' => $authorization,
            'content-length' => strlen($body)
        ]);
        $httpHeaderLines = [];
        foreach ($httpHeaders as $name => $value) {
            $httpHeaderLines[] = "{$name}: {$value}";
        }
        $ch = curl_init('https://aip.baidubce.com' . $servicePath);
        curl_setopt_array($ch, [
            CURLOPT_HTTPHEADER => $httpHeaderLines,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $body,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
//    CURLOPT_VERBOSE => true
        ]);

        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            exit('error_no : ' . curl_errno($ch) . ', error_msg : ' . curl_error($ch));
        }
        return $response;
    }

    public function testGetBusinessInfo()
    {
        $servicePath = '/rest/2.0/ocr/v1/business_license';
        return $this->request($servicePath,
            [
                'image' => base64_encode(file_get_contents(__DIR__ . '/images/营业执照二.jpg')),
                'detect_direction' => 'true',
                'accuracy' => 'high'
            ]
        );
    }

    public function testIdCard(){
        $servicePath = '/rest/2.0/ocr/v1/idcard';
        return $this->request($servicePath,
            [
                'image' => base64_encode(file_get_contents(__DIR__ . '/身份证.png')),
                'id_card_side' => 'front',
                'detect_direction' => 'true',
            ]
        );
    }

    public function testOpenBankAccount(){
        $servicePath = '/rest/2.0/ocr/v1/general_basic';
        return $this->request($servicePath,
            [
                'image' => base64_encode(file_get_contents(__DIR__ . '/images/银行开户许可证.png')),
                'detect_direction' => 'true'
            ]
        );
    }
}

$obj = new TestBaidu();
$response = $obj->testGetBusinessInfo();
echo $response;
exit();


