<?php
namespace xl;

use Mdanter\Ecc\EccFactory;
use Mdanter\Ecc\Serializer\PrivateKey\DerPrivateKeySerializer;
use Mdanter\Ecc\Serializer\PrivateKey\PemPrivateKeySerializer;
use Mdanter\Ecc\Serializer\PublicKey\DerPublicKeySerializer;
use Mdanter\Ecc\Serializer\PublicKey\PemPublicKeySerializer;
use Mdanter\Ecc\SM2\Cipher;

require_once __DIR__ . '/../../vendor/autoload.php';


class TestSm2
{
    public function testEncrypt(){
        $sm2 = new Cipher();
        $adapter = EccFactory::getAdapter();
        $derPub = new DerPublicKeySerializer();
        $pemPub = new PemPublicKeySerializer($derPub);
        $bobPub = $pemPub->parse(file_get_contents(__DIR__ . '/sm_pem/pubkey.pem'));
        $sm2->Init_enc($bobPub);
        $data = $sm2->Encrypt('hello',strlen('hello'));
        var_dump($data);
    }
}

(new TestSm2())->testEncrypt();