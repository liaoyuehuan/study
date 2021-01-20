<?php
/**
 * 
 * 工具类
 * @author liqiao
 *
 */

class Utils
{
	
	/**
     * 计算签名
     *
     * @param path       请求地址
     * @param senid     流水号
     * @param appKey    appKey
     * @param appSecret appSecret
     * @param nonce     随机码
     * @param body    请求包体
     * @param timestamp    时间戳
	 * @return 返回签名
     */
	public static function MakeSign($path, $appSecret, $appKey, $senid, $nonce, $body, $timestamp) 
	{
		$pieces = explode('/', $path);
		$signStr = "a={$pieces[3]}&l={$pieces[2]}&p={$pieces[1]}&k={$appKey}&i={$senid}&n={$nonce}&t={$timestamp}&f={$body}";
		
		$sign = base64_encode(hash_hmac("sha1", $signStr, $appSecret, true));
		return $sign;
	}
}

