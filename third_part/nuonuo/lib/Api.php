<?php
/**
 * 
 * SDK接口访问类，类中方法为static方法
 * 每个接口有默认超时时间10s
 * @author liqiao
 *
 */

require_once __DIR__ . "/Utils.php";
require_once __DIR__ . "/NnuoException.php";

class Api
{
	/**
	 * SDK版本号
	 * @var string
	 */
	public static $VERSION = "2.0.0";

	public static $AUTH_URL = "https://open.nuonuo.com/accessToken";

	/**
	 * 
	 * 商家应用获取accessToken
	 *
	 * 返回报文:
     * {"access_token":"xxx","expires_in":86400}
     *
	 * @param appKey    开放平台appKey
	 * @param appSecret 开放平台appSecret
	 * @throws NnuoException
	 * @return 成功时返回，其他抛异常
	 */
	public static function getMerchantToken($appKey, $appSecret, $timeOut = 6)
	{
		//检测必填参数
		self::checkParam($appKey, "AppKey不能为空");
		self::checkParam($appSecret, "AppSecret不能为空");
		
		$headers = array(
			"Content-Type: application/x-www-form-urlencoded"
		);
		$params = array(
			"client_id" => $appKey,
			"client_secret" => $appSecret,
			"grant_type" => "client_credentials"
		);
		$params = http_build_query($params);
		
		$res = self::postCurl(self::$AUTH_URL, $params, $headers, $timeOut);
		return $res;
	}

	/**
     * ISV应用获取accessToken
     * 
     * 返回报文:
     * {"access_token":"xxx","expires_in":86400,"refresh_token":"xxx","userId":"xxx","oauthUser":"{\"userName\":\"xxx\",\"registerType\":\"1\"}","userName":"xxx","registerType":"1"}
     *
     * @param appKey      开放平台appKey
     * @param appSecret   开放平台appSecret
     * @param code        临时授权码
     * @param taxnum      授权商户税号
     * @param redirectUri 授权回调地址
     * @throws NnuoException
	 * @return 成功时返回，其他抛异常
     */
	public static function getISVToken($appKey, $appSecret, $code, $taxnum, $redirectUri, $timeOut = 6)
	{
		//检测必填参数
		self::checkParam($appKey, "AppKey不能为空");
		self::checkParam($appSecret, "AppSecret不能为空");
		self::checkParam($code, "code不能为空");
		self::checkParam($taxnum, "taxnum不能为空");
		self::checkParam($redirectUri, "redirectUri不能为空");
		
		$headers = array(
			"Content-Type: application/x-www-form-urlencoded"
		);
		$params = array(
			"client_id" => $appKey,
			"client_secret" => $appSecret,
			"code" => $code,
			"taxNum" => $taxnum,
			"redirect_uri" => $redirectUri,
			"grant_type" => "authorization_code"
		);
		$params = http_build_query($params);
		
		$res = self::postCurl(self::$AUTH_URL, $params, $headers, $timeOut);
		return $res;
	}

	/**
     * ISV应用刷新accessToken
     * 
     * 返回报文:
     * {"access_token":"xxx","refresh_token":"xxx","expires_in":86400}
     *
     * @param refreshToken 调用令牌
     * @param userId       oauthUser中的userId
     * @param appSecret    开放平台appSecret
     * @throws NnuoException
	 * @return 成功时返回，其他抛异常
     */
    public static function refreshISVToken($refreshToken, $userId, $appSecret, $timeOut = 6) 
    {
        self::checkParam($userId, "userId不能为空");
        self::checkParam($appSecret, "appSecret不能为空");
        self::checkParam($refreshToken, "refreshToken不能为空");
		
		$headers = array(
			"Content-Type: application/x-www-form-urlencoded"
		);
		$params = array(
			"client_id" => $userId,
			"client_secret" => $appSecret,
			"refresh_token" => $refreshToken,
			"grant_type" => "refresh_token"
		);
		$params = http_build_query($params);
		
		$res = self::postCurl(self::$AUTH_URL, $params, $headers, $timeOut);
		return $res;
    }

    /**
     * 发送HTTP POST请求 <同步>
     * @param url       请求地址
     * @param senid     流水号
     * @param appKey    appKey
     * @param appSecret appSecret
     * @param token     授权码
     * @param taxnum    税号, 普通商户可不填
     * @param method    API名称
     * @param content   私有参数, 标准JSON格式
     * @throws NnuoException
	 * @return 成功时返回，其他抛异常
     */
    public static function sendPostSyncRequest($url, $senid, $appKey, $appSecret, $token,$taxnum, $method, $content, $timeOut = 6) 
    {
        self::checkParam($senid, "senid不能为空");
        self::checkParam($token, "token不能为空");
        self::checkParam($appKey, "appKey不能为空");
        self::checkParam($method, "method不能为空");
        self::checkParam($url, "请求地址URL不能为空");
        self::checkParam($content, "content不能为空");
        self::checkParam($appSecret, "appSecret不能为空");

        try {
            $timestamp = time();
            $nonce = rand(10000, 1000000000);

            $finalUrl = "{$url}?senid={$senid}&nonce={$nonce}&timestamp={$timestamp}&appkey={$appKey}";

            $urlInfo = parse_url($url);
            if ($urlInfo === FALSE) {
            	throw new NnuoException("url解析失败");
            }

            $sign = Utils::makeSign($urlInfo["path"], $appSecret, $appKey, $senid, $nonce, $content, $timestamp);

            $headers = array(
            	"Content-Type: application/json",
            	"X-Nuonuo-Sign: {$sign}",
            	"accessToken: {$token}",
            	"userTax: {$taxnum}",
            	"method: {$method}",
            	"sdkVer: " . self::$VERSION
            );

            // 调用开放平台API
            return self::postCurl($finalUrl, $content, $headers, $timeOut);
        } catch (Exception $e) {
            throw new NnuoException("发送HTTP请求异常:" . $e->getMessage());
        }
    }

	public static function checkParam($param, $errMsg) 
	{
		if(empty($param)) {
			throw new NnuoException($errMsg);
		}
	}
	
	
	/**
	 * 以post方式发起http调用
	 * 
	 * @param string $url  url
	 * @param array $params post参数
	 * @param int $second   url执行超时时间，默认30s
	 * @throws NnuoException
	 */
	private static function postCurl($url, $params, $headers = array(), $second = 30)
	{
		$ch = curl_init();
		$curlVersion = curl_version();

		//设置超时
		curl_setopt($ch, CURLOPT_TIMEOUT, $second);
		curl_setopt($ch,CURLOPT_URL, $url);
		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch,CURLOPT_SSL_VERIFYHOST, FALSE);
		//设置header
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		//要求结果为字符串且输出到屏幕上
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

		//post提交方式
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $params);

		if (!empty($headers)) {
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		}
		
		//运行curl
		$data = curl_exec($ch);
		//返回结果
		if($data) {
			curl_close($ch);
			return $data;
		} else {
			$error = curl_error($ch);
			curl_close($ch);
			throw new NnuoException("curl出错:$error");
		}
	}

}

