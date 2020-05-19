<?php
/**
 * Created by PhpStorm.
 * User: hj
 * Date: 2018/8/6
 * Time: 17:40
 */
//
//$pkcs7File = __DIR__ . '/signature_pkcs7.pem';
//$content = file_get_contents($pkcs7File);
//$success = openssl_pkcs7_read($content, $certs);
//var_dump(__DIR__ . '/signature_pkcs7.pem', $success, $certs);

namespace xl;

use ASN1\Type\UnspecifiedType;
use Sop\CryptoTypes\AlgorithmIdentifier\AlgorithmIdentifier;
use Sop\CryptoTypes\AlgorithmIdentifier\AlgorithmIdentifierFactory;

require_once __DIR__ . '/lib/PdfSignature7.php';

require_once __DIR__ . '/../vendor/autoload.php';
//require_once __DIR__ . '/asn1/vendor/autoload.php';

function testX509Der()
{
    $pkcs7File = __DIR__ . '/pdf/123.pdf';
    $obj = new PdfSignature($pkcs7File);
    $data = $obj->getLastX509Der();
    $dataBase = base64_encode(($data));
    var_dump($dataBase);

}

function testValid()
{
    $pkcs7File = __DIR__ . '/pdf/123.pdf';
    $obj = new PdfSignature($pkcs7File);
    $count = $obj->getX509Count();
    for ($i = 0; $i < $count; $i++) {
        $success = $obj->atIsFileModified($i);
        if ($success) {
            var_dump($obj->atCertInfo($i));
        } else {
            var_dump($success);
        }
    }
}


function testCheckSign()
{
    $pkcs7File = __DIR__ . '/pdf/12.pdf';
    $obj = new PdfSignature($pkcs7File);
    $index = 1;
    $publicKey = $obj->atPublicKey($index);
    $privateKey = file_get_contents('ssl/rsa_private_key.pem');
    $data = $obj->atSignature($index);
    $plainText = $obj->atPlaintext($index);
    $sign = openssl_digest($plainText, 'sha256WithRSAEncryption');

    /*openssl_private_encrypt($sign, $encrypt, openssl_pkey_get_private($privateKey, '123456'));
    echo "encrypt len:\t" . (strlen($encrypt)).PHP_EOL;*/
    echo "data Len:\t" . (strlen($data)) . PHP_EOL;
    openssl_public_decrypt($data, $decrypt, $publicKey);
    echo "sign:\t\t" . ($sign) . PHP_EOL;
    echo "decrypt :\t" . bin2hex($decrypt) . PHP_EOL;;
}

function testSha256()
{
    $pkcs7File = __DIR__ . '/pdf/12_add_conent.pdf';
    $obj = new PdfSignature($pkcs7File);
    $index = 1;
    $signature = $obj->atSignature($index);
    $plainText = $obj->atPlaintext($index);
    $publicKey = $obj->atPublicKey($index);
    $privateKey = file_get_contents('ssl/rsa_private_key.pem');
    file_put_contents(__DIR__ . '/12.sig', $signature);
    file_put_contents(__DIR__ . '/12_public_key.pem', $publicKey);
    file_put_contents(__DIR__ . '/12.p7c', $obj->atPkcs7DetachedDer($index));
    file_put_contents(__DIR__ . '/12_plain.pdf', $plainText);
    var_dump(bin2hex($signature));
    $sign2 = hex2bin('31') . (substr(UnspecifiedType::fromDER(
            $obj->atPkcs7DetachedDer($index)
        )->asSequence()
            ->at(1)->asTagged()
            ->asExplicit()->asSequence()
            ->at(4)->asSet()->at(0)->asSequence()
            ->at(3)->asElement()->toDER(), 1));
    var_dump((bin2hex($messageDigest = UnspecifiedType::fromDER($sign2)->asSet()->at(2)->asSequence()->at(1)->asSet()->at(0)->asOctetString()->string())));
    var_dump(openssl_digest($sign2, 'sha256'));
    $IdentifierFactory = new AlgorithmIdentifierFactory();
    var_dump(
        (
        $class = $IdentifierFactory->getClass(UnspecifiedType::fromDER(
            $obj->atPkcs7DetachedDer($index)
        )->asSequence()
            ->at(1)->asTagged()
            ->asExplicit()->asSequence()
            ->at(4)->asSet()->at(0)->asSequence()->at(2)->asSequence()->at(0)->asObjectIdentifier()->oid()
        )
        ));
    var_dump((new $class)->name());
    var_dump($a = openssl_digest($plainText, 'sha256'));
    var_dump($a = openssl_digest($plainText, 'sha1'));
    $success = openssl_public_decrypt($signature, $decrypt, $publicKey);
    var_dump(bin2hex($decrypt));
    $success = openssl_public_decrypt($signature, $decrypt2, $publicKey);
    var_dump(substr(bin2hex($decrypt2), -64));
}

function testModify()
{
    $pkcs7File = __DIR__ . '/pdf/12_add_conent.pdf';
    $obj = new PdfSignature($pkcs7File);
    $count = $obj->getX509Count();
    for ($i = 0; $i < $count; $i++) {
        $modify = $obj->atIsFileModified($i);
        var_dump($modify);
    }
    if ($obj->hasAddContentAfterSign()) {
        echo '文档签名有效，但在其后文件被修改';
    }
}

function testTs()
{
    $pkcs7File = __DIR__ . '/pdf/gdca.pdf';
    $obj = new PdfSignature($pkcs7File);
    $der = $obj->atPkcs7DetachedDer(0);
    $s12 = UnspecifiedType::fromDER($der)->asSequence()->at(1)->asTagged()
        ->asExplicit()->asSequence()->at(4)->asSet()->at(0)->asSequence()->
        at(6)->asTagged()->asExplicit()->asSequence()
        ->at(1)->asSet()->at(0)->asSequence()
        ->at(1)->asTagged()->asExplicit()->asSequence();// 10 5
    $x509Der = ($s12->at(3)->asTagged()->asExplicit()->asSequence()->toDER());
    var_dump($obj->x509DerToPem($x509Der));
    file_put_contents(__DIR__ . '/ssl/gdca.p7c', $der);
    $publicKeyRe = openssl_pkey_get_public($obj->x509DerToPem($x509Der));
    $publicKeyDetail = openssl_pkey_get_details(openssl_get_publickey($publicKeyRe));
    $publicKey = $publicKeyDetail['key'];
    var_dump($publicKey);

    $ss5_12 = ($s12->at(4)->asSet()->at(0)->asSequence()); //6
    $signature = ($ss5_12->at(5)->asOctetString()->string());
    echo 'tsa sig: ' . bin2hex($signature) . PHP_EOL;
    $authenticationAttributeDer = hex2bin('31') . substr($ss5_12->at(3)->asElement()->toDER(), 1);
    $sign = openssl_digest($authenticationAttributeDer, 'sha256');
    echo 'tsa authentication sha256 :' . ($sign) . PHP_EOL;
//    var_dump(openssl_digest($a, 'sha256'));
//    $b = ($s12->at(2)->asBitString()->string());
    $plainText = $obj->atPlaintext(0);
    echo 'plaintText sha256: ' . bin2hex(openssl_digest($plainText, 'sha256')) . PHP_EOL;
    openssl_public_decrypt($signature, $de, $publicKey);
    echo 'tsa pub de : ' . bin2hex($de) . PHP_EOL;
    var_dump(openssl_digest($obj->atSignature(0), 'sha256'));
    /*$timestamp =  strtotime('20180813120933');
    $plainSign = hex2bin(openssl_digest($obj->atPlaintext(0),'sha256'));
    $tsPlainText = $plainSign.($timestamp);
    var_dump($tsPlainText);
    var_dump(openssl_digest($tsPlainText, 'sha256'));*/


}

function testTsa()
{
    $pkcs7File = __DIR__ . '/pdf/gdca.pdf';
    $obj = new PdfSignature($pkcs7File);
    $tsaPkcs7DetachedDer = $obj->atTsaPkcs7DetachedDer(0);
    $sequence = UnspecifiedType::fromDER($tsaPkcs7DetachedDer)->asTagged()->asExplicit()
        ->asSequence()->at(1);
    $TSTInfoDer = $obj->getTSTInfoDerFromTsaPkcs7DetachedDer($tsaPkcs7DetachedDer);
    $oid = UnspecifiedType::fromDER($TSTInfoDer)->asSequence()->at(2)->asSequence()->at(0)->asSequence()->at(0)->asObjectIdentifier()->oid();
    $className = (new AlgorithmIdentifierFactory())->getClass($oid);
    /** @var $algorithmIdentifier AlgorithmIdentifier/**/
    $algorithmIdentifier = new $className;
    echo 'digest : '.($algorithmIdentifier->name()).PHP_EOL;
    $timestampInfoHash = UnspecifiedType::fromDER($TSTInfoDer)->asSequence()->at(2)->asSequence()->at(1)->asOctetString()->string();
    echo 'timestamp info hash : '.(bin2hex($timestampInfoHash));
}

function testTsaVerify(){
    $pkcs7File = __DIR__ . '/pdf/PBAQ20203511Q000E00028.pdf';
    $obj = new PdfSignature($pkcs7File);
    $success = $obj->atVerifyTsa(0);
    var_dump($success);
}

try {
    testTsaVerify();
    exit();
    $signature = $obj->atPkcs7DetachedDer(0);
    //soap
    $soap = new SoapClient('http://218.17.161.11:9091/SZCAJavaCAS/services/szcaCAValidate?wsdl');    //这里填写你要调用的URL
    $ParamData3 = array('certBase64' => $dataBase);  //调用接口用到的参数
    $vv3 = $soap->szcaWSCertificateValidateString($ParamData3);
    var_dump(((($vv3->return))));
} catch (\Exception $e) {
    echo ($e->getMessage()) . PHP_EOL;
    echo ($e->getTraceAsString()) . PHP_EOL;
}

