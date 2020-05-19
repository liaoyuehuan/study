<?php

namespace xl;

use Mdanter\Ecc\EccFactory;
use Mdanter\Ecc\Primitives\GeneratorPoint;
use Mdanter\Ecc\Serializer\PrivateKey\DerPrivateKeySerializer;
use Mdanter\Ecc\Serializer\PrivateKey\PemPrivateKeySerializer;
use Mdanter\Ecc\Serializer\PublicKey\DerPublicKeySerializer;
use Mdanter\Ecc\Serializer\PublicKey\PemPublicKeySerializer;
use Mdanter\Ecc\Util\NumberSize;

include __DIR__ . '/../../vendor/autoload.php';

class TestECDH
{
    public function test()
    {
        $adapter = EccFactory::getAdapter();
        $generator = EccFactory::getNistCurves()->generator256();
        $useDerandomizedSignatures = true;

        $derPub = new DerPublicKeySerializer();
        $pemPub = new PemPublicKeySerializer($derPub);
        $pemPrivate = new PemPrivateKeySerializer(new DerPrivateKeySerializer($adapter, $derPub));
        $bobPub = $pemPub->parse(file_get_contents(__DIR__ . '/pem/a_public_key.pem'));

        $alicePrivate = $pemPrivate->parse(file_get_contents(__DIR__ . '/pem/ecc_ca_private_key.pem'));
        $exchange = $alicePrivate->createExchange($bobPub);

        $shared = $exchange->calculateSharedKey();
        echo "Shared secret: " . ((gmp_strval($shared, 10))) . PHP_EOL;
        $kdf = function (GeneratorPoint $G, \GMP $sharedSecret) {
            $adapter = $G->getAdapter();
            $binary = $adapter->intToFixedSizeString(
                $sharedSecret,
                NumberSize::bnNumBytes($adapter, $G->getOrder())
            );
            # $binary 这个值下面命令生成的值相同：
            # openssl pkeyutl -derive -inkey ecc_ca_private_key.pem -peerkey  ecc_ca_site_public_key.pem
            $hash = hash('sha256', $binary, true);
            return $hash;
        };
        $key = $kdf($generator, $shared);
        echo "Encryption key base64 : " . base64_encode($key) . PHP_EOL;
    }
}

(new TestECDH())->test();