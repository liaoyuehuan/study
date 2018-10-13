<?php

ini_set('display_errors','On');
error_reporting(E_ALL);

$td = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_CBC, '');

function hexToStr($hex)
{
    $str = '';
    $len = strlen($hex);
    for ($i = 0; $i < $len; $i += 2) {
        $str .= chr($hex{$i} . $hex{$i + 1});
    }
    return $str;
}


class Aes {

    public static $key = '1234567890123456';

    private static $iv = '0102030405060708';

    private static $encoding = 'UTF-8';

    public static  function encrypt($input,$key){
        $input = self::encode($input);
//        MCRYPT_MODE_CBC; cipher block chaining
//        MCRYPT_MODE_CFB; cipher feedback
//        MCRYPT_MODE_ECB; electronic Codeook book
//        MCRYPT_MODE_NOFB;
//        MCRYPT_MODE_OFB; output feedback
//        MCRYPT_MODE_STREAM;

        //128、192、256

        $size = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128,MCRYPT_MODE_CBC);
        //pkcs5_pad
        $pad = $size - (strlen($input) % $size);
        $input = $input.str_repeat(chr($pad),$pad);

        $td= mcrypt_module_open(MCRYPT_RIJNDAEL_128,'',MCRYPT_MODE_CBC,'');
        $iv = self::$iv;

        mcrypt_generic_init($td,$key,$iv);
        $data = mcrypt_generic($td,$input);
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);
        $data = base64_encode($data);
        return $data;
    }

    public static function decrypt($input,$key){
        $decrypted = mcrypt_decrypt(
            MCRYPT_RIJNDAEL_128,
            $key,
            base64_decode($input),
            MCRYPT_MODE_CBC,
            self::$iv
        );
        $sec_s = mb_strlen($decrypted);
        $padding = ord($decrypted[$sec_s - 1]);
        $decrypted = mb_substr($decrypted,0,$sec_s -$padding);
        $decrypted = self::encode($decrypted);
        return $decrypted;
    }

    private function encode($input){
        $encoding = mb_detect_encoding($input,["ASCII",'UTF-8',"GB2312","GBK",'BIG5']);
        $input = mb_convert_encoding($input,self::$encoding,$encoding);
        return $input
;    }
}



$value = '为啥';
var_dump(mb_strlen($value));
var_dump($value);
$encryptDate = Aes::encrypt($value,AES::$key);
var_dump($encryptDate);
$decryptData = AES::decrypt($encryptDate,Aes::$key);
var_dump(mb_strlen($decryptData));
var_dump($decryptData);



