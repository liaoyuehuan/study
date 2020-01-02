<?php
/**
 * aes cipher methods
 * string(11) "aes-128-cbc"
 * [96]=>
 * string(21) "aes-128-cbc-hmac-sha1"
 * [97]=>
 * string(23) "aes-128-cbc-hmac-sha256"
 * [98]=>
 * string(11) "aes-128-ccm"
 * [99]=>
 * string(11) "aes-128-cfb"
 * [100]=>
 * string(12) "aes-128-cfb1"
 * [101]=>
 * string(12) "aes-128-cfb8"
 * [102]=>
 * string(11) "aes-128-ctr"
 * [103]=>
 * string(11) "aes-128-ecb"
 * [104]=>
 * string(11) "aes-128-gcm"
 * [105]=>
 * string(11) "aes-128-ocb"
 * [106]=>
 * string(11) "aes-128-ofb"
 * [107]=>
 * string(11) "aes-128-xts"
 * [108]=>
 * string(11) "aes-192-cbc"
 * [109]=>
 * string(11) "aes-192-ccm"
 * [110]=>
 * string(11) "aes-192-cfb"
 * [111]=>
 * string(12) "aes-192-cfb1"
 * [112]=>
 * string(12) "aes-192-cfb8"
 * [113]=>
 * string(11) "aes-192-ctr"
 * [114]=>
 * string(11) "aes-192-ecb"
 * [115]=>
 * string(11) "aes-192-gcm"
 * [116]=>
 * string(11) "aes-192-ocb"
 * [117]=>
 * string(11) "aes-192-ofb"
 * [118]=>
 * string(11) "aes-256-cbc"
 * [119]=>
 * string(21) "aes-256-cbc-hmac-sha1"
 * [120]=>
 * string(23) "aes-256-cbc-hmac-sha256"
 * [121]=>
 * string(11) "aes-256-ccm"
 * [122]=>
 * string(11) "aes-256-cfb"
 * [123]=>
 * string(12) "aes-256-cfb1"
 * [124]=>
 * string(12) "aes-256-cfb8"
 * [125]=>
 * string(11) "aes-256-ctr"
 * [126]=>
 * string(11) "aes-256-ecb"
 * [127]=>
 * string(11) "aes-256-gcm"
 * [128]=>
 * string(11) "aes-256-ocb"
 * [129]=>
 * string(11) "aes-256-ofb"
 * [130]=>
 * string(11) "aes-256-xts"
 */

/**
 * 用到的openssl方法
 * #openssl_cipher_iv_length($method)   --获取密码的iv长度
 * #openssl_random_pseudo_bytes($length, &$crypto_strong = null)    --生成一个伪随机字符串
 * openssl_encrypt($data, $method, $key, $options = 0, $iv = "", &$tag = NULL, $aad = "", $tag_length = 16)
 * openssl_decrypt($data, $method, $key, $options = 0, $iv = "", &$tag = NULL, $aad = "", $tag_length = 16)
 */

$cipher_methods = openssl_get_cipher_methods(false);
//var_dump($cipher_methods);

//aes-128-cbc php7
class Aes
{
    private $key;

    private $cipherMethod;

    private $iv;

    public function __construct(string $key, string $cipherMethod = 'aes-128-cbc', $iv = '')
    {
        $this->key = $key;
        $this->cipherMethod = $cipherMethod;
        if (empty($iv)) {
            $this->iv = $this->getIv($cipherMethod);
        } else {
            $this->iv = $iv;
        }
    }

    public function getIv(string $cipherMethod)
    {
        $ivLen = openssl_cipher_iv_length($cipherMethod);
        $iv = openssl_random_pseudo_bytes($ivLen);
        return $iv;
    }

    public function encrypt(string $plaintText)
    {
        $cipherText = openssl_encrypt($plaintText, $this->cipherMethod, $this->key, 0, $this->iv);
        return $cipherText;
    }

    public function decrypt(string $cipherText)
    {
        return openssl_decrypt($cipherText, $this->cipherMethod, $this->key, 0, $this->iv);
    }
}

function certDerToPem($der){
    $certB64 =base64_encode($der);
    $encoded = chunk_split($certB64, 64, "\n");
    $x509CertData =  "-----BEGIN CERTIFICATE-----\n$encoded-----END CERTIFICATE-----\n";
    return $x509CertData;
}

function testParseX509()
{
    $cert = certDerToPem(base64_decode(file_get_contents(__DIR__ . '/ssl/sm2.cert')));
    $res = openssl_x509_parse($cert);
    var_dump($res);
}

testParseX509();
exit();

$key = 'ubnsdf';
$aesObj = new Aes($key, 'aes-128-cbc', '0102030405060708');
$plaintText = '我是你的大哥啊';
$usStartTime = floor(microtime(true) * 1000000);
$cipherText = $aesObj->encrypt($plaintText);
$plaintText = $aesObj->decrypt($cipherText);
$usEndTime = floor(microtime(true) * 1000000);
$spendUsTime = $usEndTime - $usStartTime;
echo 'cipher 纳秒:' . $spendUsTime . PHP_EOL; //平均花费25纳秒，数据量越大花费时间越多
echo 'cipher text:' . $cipherText . PHP_EOL;
echo 'plaint text:' . $plaintText . PHP_EOL;;

/**
 * openssl sign
 */
$tempdoc = __DIR__ . '/pdf/base.pdf';
openssl_sign(file_get_contents($tempdoc), $rs, openssl_pkey_get_private(file_get_contents(__DIR__ . '/ssl/rsa_private_key.pem'), '123456'));
var_dump(strlen($rs));
var_dump(openssl_verify(file_get_contents($tempdoc), $rs, openssl_get_publickey(file_get_contents(__DIR__ . '/ssl/server.cert'))));
exit();


/**
 * openssl pkcs7 encry
 */
$ourfile = __DIR__ . '/pdf/out_base.pdf';
openssl_pkcs7_encrypt($tempdoc, $ourfile);
