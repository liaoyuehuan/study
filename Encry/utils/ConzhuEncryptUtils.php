<?php
/**
 * Created by PhpStorm.
 * User: hj
 * Date: 2019/1/8
 * Time: 15:08
 */

class ConzhuEncryptUtils
{


    /**
     * 获取公钥私钥
     * @return array
     */
    public static function generalPublicKeyAndPrivateKey()
    {
        $resource = openssl_pkey_new();
        openssl_pkey_export($resource, $privateKey);
        $detail = openssl_pkey_get_details($resource);
        return ['publicKey' => $detail['key'], 'privateKey' => $privateKey];
    }

    /**
     * 公钥加密
     * @param $plaintext
     * @param $publicKey
     * @return string
     */
    public static function encryptWithPublicKey($plaintext, $publicKey)
    {
        $crypto = '';
        if ($plaintext) {
            foreach (str_split($plaintext, 245) as $chunk) {
                openssl_public_encrypt($chunk, $encryptData, $publicKey);
                $crypto .= $encryptData;
            }

            $crypto = base64_encode($crypto);
        }
        return $crypto;
    }

    /**
     * 私钥解密
     * @param $encryptData
     * @param $privateKey
     * @return mixed
     */
    public static function decryptWithPrivateKey($encryptData, $privateKey)
    {
        $crypto = '';
        foreach (str_split(base64_decode($encryptData), 256) as $chunk) {
            openssl_private_decrypt($chunk, $decryptData, $privateKey);
            $crypto .= $decryptData;
        }
        return $crypto;
    }

    /**
     * AES加密
     * @param $plaintext
     * @param string $key
     * @param string $cipher
     * @return string
     */

    public static function aesEncript($plaintext, $key = 'ebg.conzhu.net', $cipher = 'AES-256-CBC')
    {
        $ivlen = openssl_cipher_iv_length($cipher);
        $iv = openssl_random_pseudo_bytes($ivlen);
        $ciphertext_raw = openssl_encrypt($plaintext, $cipher, $key, $options = OPENSSL_RAW_DATA, $iv);
        $hmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary = true);
        return base64_encode($iv . $hmac . $ciphertext_raw);
    }

    /**
     * AES解密
     * @param $ciphertext
     * @param string $key
     * @param string $cipher
     * @return string
     */
    public static function aesDecrypt($ciphertext, $key = 'ebg.conzhu.net', $cipher = 'AES-256-CBC')
    {
        $c = base64_decode($ciphertext);
        $ivlen = openssl_cipher_iv_length($cipher);
        $iv = substr($c, 0, $ivlen);
        $hmac = substr($c, $ivlen, $sha2len = 32);
        $ciphertext_raw = substr($c, $ivlen + $sha2len);
        $original_plaintext = openssl_decrypt($ciphertext_raw, $cipher, $key, $options = OPENSSL_RAW_DATA, $iv);
        $calcmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary = true);
        if (function_exists('hash_equals')) {
            if (hash_equals($hmac, $calcmac)) {
                return $original_plaintext;
            } else {
                return false;
            }
        } else {
            if ($hmac === $calcmac) {
                return $original_plaintext;
            } else {
                return false;
            }
        }
    }
}


