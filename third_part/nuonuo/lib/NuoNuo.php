<?php


class NuoNuo
{
    private $appKey;

    private $appSecret;

    private $accessTokenGateway;

    private $gateway;

    private $redirectUri;

    public static $VERSION = "2.0.0";

    public function __construct(array $config)
    {
        $this->appKey = $config['app_key'];
        $this->appSecret = $config['app_secret'];
        $this->accessTokenGateway = $config['access_token_gateway'];
        $this->gateway = $config['gateway'];
        $this->redirectUri = $config['redirect_uri'];
    }

    public function getAccessToken($code, $taxNum = '')
    {
        return $this->request($this->accessTokenGateway, [
            'code' => $code,
            'client_id' => $this->appKey,
            'client_secret' => $this->appSecret,
            'grant_type' => 'authorization_code',
            'taxNum' => $taxNum,
            'redirect_uri' => $this->redirectUri
        ]);
    }

    public function post($url, $param, $extra = [])
    {
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => is_array($param) ? http_build_query($param) : $param,
            CURLOPT_HTTPHEADER => $extra['http_header'] ?? [],
            CURLOPT_TIMEOUT => $extra['timeout'] ?? 30,
            CURLOPT_RETURNTRANSFER => true
        ]);
        $response = curl_exec($ch);
        if ($errorNo = curl_errno($ch)) {
            throw new RuntimeException("curl error - error_no: {$errorNo}, error_msg : " . curl_error($ch));
        }
        return $response;
    }

    public function request($url, $param, $extra = [])
    {
        $response = $this->post($url, $param, $extra);
        $data = json_decode($response, true);
        if (empty($data)) {
            throw new RuntimeException('not a json');
        }
        if (isset($data['error'])) {
            throw new RuntimeException("error : {$data['error']}, error_msg : {$data['error_description']}");
        }
        return $data;
    }

    public function makeSign($path, $appSecret, $appKey, $senId, $nonce, $body, $timestamp)
    {
        $pieces = explode('/', $path);
        $signStr = "a={$pieces[3]}&l={$pieces[2]}&p={$pieces[1]}&k={$appKey}&i={$senId}&n={$nonce}&t={$timestamp}&f={$body}";
        $sign = base64_encode(hash_hmac("sha1", $signStr, $appSecret, true));
        return $sign;
    }

    public function apiRequest($accessToken, $method, array $param, $taxNum = '')
    {
        $senid = uniqid();
        $nonce = mt_rand(1000000000, 9999999999);
        $timestamp = time();
        $content = json_encode($param);
        $finalUrl = "{$this->gateway}?senid={$senid}&nonce={$nonce}&timestamp={$timestamp}&appkey={$this->appKey}";
        $urlInfo = parse_url($this->gateway);
        if ($urlInfo === FALSE) {
            throw new NnuoException("url解析失败");
        }
        $sign = $this->makeSign($urlInfo["path"], $this->appSecret, $this->appKey, $senid, $nonce, $content, $timestamp);
        $headers = array(
            "Content-Type: application/json",
            "X-Nuonuo-Sign: {$sign}",
            "accessToken: {$accessToken}",
            "userTax: {$taxNum}",
            "method: {$method}",
            "sdkVer: " . self::$VERSION
        );
        return $this->request($finalUrl, $content, [
            'http_header' => $headers
        ]);
    }
}