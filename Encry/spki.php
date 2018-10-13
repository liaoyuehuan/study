<?php

$cert = file_get_contents('ssl/server.crt');
$certInfo = openssl_x509_parse($cert, true);
var_dump($certInfo);

var_dump(date_create_from_format('ymdHise', $certInfo['validFrom'])->format('Y-m-d H:i:s'));

$data = 'hello world';
$privateKey = file_get_contents('ssl/rsa_private_key.pem');
$publicKey = file_get_contents('ssl/rsa_public_key.pem');
$sign = openssl_digest($data, 'sha256');
var_dump($sign);
openssl_private_encrypt($sign, $priData, openssl_get_privatekey($privateKey, '123456'));
var_dump(strlen($priData));
openssl_public_decrypt($priData, $pubData, $publicKey);
var_dump(($pubData));

function asn1der_ia5string($str)
{
    $len = strlen($str) - 2;
    if ($len < 0 && $len > 127) {
        return false;
    }

    $pos = 0;
    /* check tag and len */
    if (22 != (ord($str[$pos++]) & 0x1f) &&
        ord($str[$pos++]) != $len) {
        /* not a valid DER encoding of an IA5STRING */
        return false;
    }

    return substr($str, 2, $len);
}