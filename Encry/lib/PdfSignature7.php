<?php
/**
 * Created by PhpStorm.
 * User: hj
 * Date: 2018/8/17
 * Time: 17:46
 */

namespace xl;

use ASN1\Type\TaggedType;
use ASN1\Type\UnspecifiedType;
use Sop\CryptoTypes\AlgorithmIdentifier\AlgorithmIdentifier;
use Sop\CryptoTypes\AlgorithmIdentifier\AlgorithmIdentifierFactory;
use Sop\CryptoTypes\AlgorithmIdentifier\Feature\HashAlgorithmIdentifier;

class PdfSignature
{
    /**
     * @var string
     */
    private $pdfFile;

    /*
     * []string
     */
    private $pkcs7DetachedDerList;

    /**
     * @var int[]
     */
    private $signTime;

    /**
     * @var string
     */
    private $pdfContent;

    /**
     * @var array
     */
    private $byteRanges;

    /**
     * @var int[]
     */
    private $tsaTimestamps = [];

    /**
     * PdfSign constructor.
     * @param $pdfFile
     * @throws \Exception
     */
    public function __construct($pdfFile)
    {
        if (strpos($pdfFile, 'http') !== 0 && false === is_file($pdfFile)) {
            throw new \Exception('pdf file not found');
        }
        $this->pdfFile = $pdfFile;
        $this->pdfContent = file_get_contents($this->pdfFile);
        $this->loadByteRanges();
        $this->loadPkcs7DetachedDerList();
        $this->loadSingTime();
    }

    private function loadByteRanges()
    {
        $this->byteRanges = $this->getByteRangesFromPdfContent($this->pdfContent);
    }


    /**
     * @throws \Exception
     */
    private function loadPkcs7DetachedDerList()
    {
        $byteRanges = $this->byteRanges;
        foreach ($byteRanges as $byteRange) {
            $start = $byteRange[1];
            $end = $byteRange[2];
            $signature = substr($this->pdfContent, $start + 1, $end - $start - 2); // because we need to exclude < and > from start and end
            $signature = rtrim($signature, '0');
            if (strlen($signature) % 2 === 1) {
                $signature .= '0';
            }
            $this->pkcs7DetachedDerList[] = hex2bin($signature);
        }
        file_put_contents(__DIR__.'/aa.pkcs7',$this->pkcs7DetachedDerList[0]);exit();
    }

    /**
     * @throws \Exception
     */
    private function loadSingTime()
    {
        $byteRanges = $this->byteRanges;
        $pattern = '/(?<=(\M\\(D:)).*?(?=(\)))/';
        foreach ($byteRanges as $byteRange) {
            preg_match($pattern, substr($this->pdfContent, (int)$byteRange[2], (int)$byteRange[3]), $rs);
            if ($rs) {
                $time = substr($rs[0], 0, strpos($rs[0], '+'));
                $this->signTime[] = strtotime($time);
            }
        }
    }

    /**
     * @param $index
     * @return int
     */
    public function atSignTime($index)
    {
        return $this->signTime[$index];
    }


    /**
     * @param string $pdfContent
     * @return array[]  byteRange[ 0 start end len]
     * @throws \Exception
     */
    public function getByteRangesFromPdfContent($pdfContent)
    {
        $regexp = '/\/ByteRange ?\[ ?(\d+) (\d+) (\d+) (\d+)/'; // subexpressions are used to extract b and c
        $result = [];
        $return = preg_match_all($regexp, $pdfContent, $result);

        if ($return == false) {
            throw new \Exception('sign data not found');
        }
        if (isset($result[2]) && isset($result[3]) && isset($result[2][0]) && isset($result[3][0])) {
            $count = count($result[2]);
            $byteRangeList = [];
            for ($i = 0; $i < $count; $i++) {
                $start = $result[2][$i];
                $end = $result[3][$i];
                $afterLen = $result[4][$i];
                $byteRangeList[] = [$result[1][$i], $start, $end, $afterLen];
            }
            return $byteRangeList;
        } else {
            throw new \Exception('pkcs7 data not found');
        }
    }

    /**
     * @return int
     */
    public function getX509Count()
    {
        return count($this->pkcs7DetachedDerList);
    }

    /**
     * @return array
     */
    public function getAllX509DetachedDer()
    {
        return array_map(function ($pkcs7DetachedDer) {
            return $this->getX509DerByPkcs7DetachedDer($pkcs7DetachedDer);
        }, $this->pkcs7DetachedDerList);
    }

    /**
     * @return array
     */
    public function getAllX509DetachedPem()
    {
        return array_map(function ($pkcs7DetachedDer) {
            return $this->getX509PemByPkcs7DetachedDer($pkcs7DetachedDer);
        }, $this->pkcs7DetachedDerList);
    }


    /**
     * @param int $index
     * @return string
     * @throws \Exception
     */
    public function atX509Der($index)
    {
        if (false === isset($this->pkcs7DetachedDerList[$index])) {
            throw  new \Exception('out of index for x509 data ');
        }
        $pkcs7DetachedDer = $this->pkcs7DetachedDerList[$index];
        return $this->getX509DerByPkcs7DetachedDer($pkcs7DetachedDer);
    }

    /**
     * @param int $index
     * @return string
     * @throws \Exception
     */
    public function atX509Pem($index)
    {
        if (false === isset($this->pkcs7DetachedDerList[$index])) {
            throw  new \Exception('out of index for x509 data ');
        }
        $pkcs7DetachedDer = $this->pkcs7DetachedDerList[$index];
        return $this->getX509PemByPkcs7DetachedDer($pkcs7DetachedDer);
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function getLastX509Der()
    {
        return $this->atX509Der($this->getX509Count() - 1);
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function getLastX509Pem()
    {
        return $this->atX509Pem($this->getX509Count() - 1);
    }

    /**
     * @param int $index
     * @return mixed
     * @throws \Exception
     */
    public function atPkcs7DetachedDer($index)
    {
        if (false === isset($this->pkcs7DetachedDerList[$index])) {
            throw  new \Exception('out of index for x509 data ');
        }
        return $this->pkcs7DetachedDerList[$index];
    }

    /**
     * @param int $index
     * @return string
     * @throws \Exception
     */
    public function atPkcs7DetachedPem($index)
    {
        if (false === isset($this->pkcs7DetachedDerList[$index])) {
            throw  new \Exception('out of index for x509 data ');
        }
        return $this->pkcs7DerToPem($this->pkcs7DetachedDerList[$index]);
    }


    /**
     * @param string $pkcs7DetachedDer
     * @return string
     */
    public function getX509PemByPkcs7DetachedDer($pkcs7DetachedDer)
    {
        return $this->x509DerToPem($this->getX509DerByPkcs7DetachedDer($pkcs7DetachedDer));
    }

    /**
     * @param string $pkcs7DetachedDer
     * @return string
     */
    public function getX509DerByPkcs7DetachedDer($pkcs7DetachedDer)
    {
        $certIdentifier = hex2bin('a082');
        $pos = strpos($pkcs7DetachedDer, $certIdentifier, 52);
        $len = hexdec(bin2hex(substr($pkcs7DetachedDer, $pos + 2, 2)));
        return substr($pkcs7DetachedDer, $pos + 4, $len);
    }

    /**
     * @param $pkcs7DetachedDer
     * @return null|string
     */
    public function getTsaPkcs7DetachedDer($pkcs7DetachedDer)
    {
        $sequence = UnspecifiedType::fromDER($pkcs7DetachedDer)->asSequence()->at(1)->asTagged()
            ->asExplicit()->asSequence()->at(4)->asSet()->at(0)->asSequence();
        $lastUnspecifiedType = $sequence->at($sequence->count() - 1);
        if ($lastUnspecifiedType->asElement() instanceof TaggedType) {
            return $lastUnspecifiedType->asElement()->toDER();
        } else {
            return null;
        }
    }

    /**
     * @param $tsaPkcs7DetachedDer string
     * @return string
     */
    public function getTrueTsaPkcs7DetachedDer($tsaPkcs7DetachedDer){
        return UnspecifiedType::fromDER($tsaPkcs7DetachedDer)
            ->asTagged()->asExplicit()->asSequence()
            ->at(1)->asSet()
            ->at(0)->asSequence()->toDER();
    }

    /**
     * @param $index int
     * @return null|string
     * @throws \Exception
     */
    public function atTsaPkcs7DetachedDer($index)
    {
        if (false === isset($this->pkcs7DetachedDerList[$index])) {
            throw  new \Exception('out of index for tsa x509 data ');
        }
        $pkcs7DetachedDer = $this->pkcs7DetachedDerList[$index];
        return $this->getTsaPkcs7DetachedDer($pkcs7DetachedDer);
    }

    /**
     * @param string $pkcs7DetachedDer
     * @return string
     */
    public function getTsaX509DerByPkcs7DetachedDer($pkcs7DetachedDer)
    {
        $tsaPkcs7DetachedDer = $this->getTsaPkcs7DetachedDer($pkcs7DetachedDer);
        return $this->getX509DerByPkcs7DetachedDer($tsaPkcs7DetachedDer);
    }

    public function getTsaX509PemByPkcs7DetachedDer($pkcs7DetachedDer)
    {
        $tsaX509Der = $this->getTsaX509DerByPkcs7DetachedDer($pkcs7DetachedDer);
        return $this->x509DerToPem($tsaX509Der);
    }

    public function atTsaX509Der($index)
    {
        if (false === isset($this->pkcs7DetachedDerList[$index])) {
            throw  new \Exception('out of index for tsa x509 data ');
        }
        $pkcs7DetachedDer = $this->pkcs7DetachedDerList[$index];
        return $this->getTsaX509PemByPkcs7DetachedDer($pkcs7DetachedDer);
    }

    /**
     * @param $index int
     * @return string
     * @throws \Exception
     */
    public function atTsaX509Pem($index)
    {
        if (false === isset($this->pkcs7DetachedDerList[$index])) {
            throw  new \Exception('out of index for x509 data ');
        }
        $pkcs7DetachedDer = $this->pkcs7DetachedDerList[$index];
        return $this->getTsaX509PemByPkcs7DetachedDer($pkcs7DetachedDer);
    }

    /**
     * @param string $pem
     * @return bool|string
     */
    public function x509PemToDer($pem)
    {
        $start = strlen('-----BEGIN CERTIFICATE-----' . PHP_EOL);
        $end = strpos($pem, '-----END CERTIFICATE-----');
        $base64Der = preg_replace("/(\n)|(\r)/", '', substr($pem, $start - 1, $end - $start));
        $der = base64_decode($base64Der);
        return $der;
    }

    /**
     * @param $index int
     * @return string
     * @throws \Exception
     */
    public function atTsaPublicKey($index)
    {
        $publicKey = openssl_pkey_get_public($this->atTsaX509Pem($index));
        $publicKeyDetail = openssl_pkey_get_details(openssl_get_publickey($publicKey));
        return $publicKeyDetail['key'];
    }

    /**
     * @param $tsaPkcs7DetachedDer string
     * @return string
     */
    public function getTsaSignatureFromTsaPkcs7DetachedDer($tsaPkcs7DetachedDer){
        return $this->getSignatureFromPkcs7DerDetachedDer($tsaPkcs7DetachedDer);
    }

    /**
     * @param $tsaPkcs7DetachedDer
     * @return string
     */
    public function getTSTInfoDerFromTsaPkcs7DetachedDer($tsaPkcs7DetachedDer)
    {
        $TSTInfoDer = UnspecifiedType::fromDER($tsaPkcs7DetachedDer)->asTagged()->asExplicit()->asSequence()
            ->at(1)->asSet()
            ->at(0)->asSequence()
            ->at(1)->asTagged()->asExplicit()->asSequence()
            ->at(2)->asSequence()
            ->at(1)->asTagged()->asExplicit()->asOctetString()->string();
        return $TSTInfoDer;
    }

    /**
     * @param $index int
     * @return string
     * @throws \Exception
     */
    public function atTSTInfoDerFromTsaPkcs7DetachedDer($index){
        $tsaPkcs7DetachedDer = $this->atTsaPkcs7DetachedDer($index);
        return $this->getTSTInfoDerFromTsaPkcs7DetachedDer($tsaPkcs7DetachedDer);
    }

    /**
     * @param $tSTInfoDer string
     * @return AlgorithmIdentifier
     */
    public function getAlgorithmFromTSTInfoDer($tSTInfoDer){
        $oid = UnspecifiedType::fromDER($tSTInfoDer)->asSequence()->at(2)->asSequence()->at(0)->asSequence()->at(0)->asObjectIdentifier()->oid();
        $className = (new AlgorithmIdentifierFactory())->getClass($oid);
        /** @var $algorithmIdentifier AlgorithmIdentifier/**/
        $algorithmIdentifier = new $className;
        return $algorithmIdentifier;
    }

    /**
     * @param $tSTInfoDer
     * @return string
     */
    public function getMessageImprintDigestFromTSTInfoDer($tSTInfoDer){
        $messageImprintDigest = UnspecifiedType::fromDER($tSTInfoDer)->asSequence()->at(2)->asSequence()->at(1)->asOctetString()->string();
        return $messageImprintDigest;
    }

    /**
     * @param $index int
     * @param $timestamp int
     */
    public function setTsaTimestamp($index,$timestamp){
        $this->tsaTimestamps[$index] = $timestamp;
    }

    /**
     * @param $tSTInfoDer
     * @return \DateTimeImmutable
     */
    public function getTimestampFromTSTInfoDer($tSTInfoDer){
        $dateTime = UnspecifiedType::fromDER($tSTInfoDer)->asSequence()->at(4)->asGeneralizedTime()->dateTime();
        return $dateTime;
    }


    /**
     * @param string $der
     * @return string
     */
    public function x509DerToPem($der)
    {
        $encoded = chunk_split(base64_encode($der), 64, "\n");
        return "-----BEGIN CERTIFICATE-----\n$encoded-----END CERTIFICATE-----\n";
    }

    /**
     * @param string $der
     * @return string
     */
    public function pkcs7DerToPem($der)
    {
        $encoded = chunk_split(base64_encode($der), 64, PHP_EOL);
        return "-----BEGIN PKCS7-----\n$encoded-----END PKCS7-----\n";
    }

    /**
     * 支持命令行的情况下使用
     * @param string $pkcs7Detached
     * @return string
     */
    public function getX509Base64ByExec($pkcs7Detached)
    {
        $data = base64_encode($pkcs7Detached);
        ob_start();
        system("echo {$data} | base64 -d | openssl pkcs7 -inform der -outform der  -print_certs | openssl x509 -outform der | base64");
        return ob_get_clean();
    }

    /**
     * @param $index
     * @return bool|string
     * @throws \Exception
     */
    public function atPlaintext($index)
    {
        $byteRanges = $this->getByteRangesFromPdfContent($this->pdfContent);
        if (false === isset($byteRanges[$index])) {
            throw new \Exception('out of index for plain text');
        }
        $byteRange = $byteRanges[$index];
        $plaintText = substr($this->pdfContent, 0, $byteRange[1]);
        $plaintText = $plaintText . substr($this->pdfContent, $byteRange[2], $byteRange[3]);
        return $plaintText;
    }

    /**
     * @return bool|string
     * @throws \Exception
     */
    public function getLastPlantText()
    {
        return $this->atPlainText($this->getX509Count() - 1);
    }

    /**
     * @param $index
     * @return bool|string
     * @throws \Exception
     */
    public function atSignature($index)
    {
        $pkcs7DerDetached = $this->atPkcs7DetachedDer($index);
        return $this->getSignatureFromPkcs7DerDetachedDer($pkcs7DerDetached);
    }

    /**
     * @param $pkcs7DerDetachedDer
     * @return string
     */
    public function getSignatureFromPkcs7DerDetachedDer($pkcs7DerDetachedDer){
        $seq = UnspecifiedType::fromDER(
            $pkcs7DerDetachedDer
        )->asSequence()
            ->at(1)->asTagged()
            ->asExplicit()->asSequence()
            ->at(4)->asSet()->at(0)->asSequence();
        $a = $seq->count();
        $a == 7 && $a = 6;
        return $seq->at($a - 1)->asOctetString()->string();
    }

    /**
     * @return bool|string
     * @throws \Exception
     */
    public function getLastSignature()
    {
        return $this->atSignature($this->getX509Count() - 1);
    }

    /**
     * @param $index
     * @return string
     * @throws \Exception
     */
    public function atPublicKey($index)
    {
        $publicKey = openssl_pkey_get_public($this->atX509Pem($index));
        $publicKeyDetail = openssl_pkey_get_details(openssl_get_publickey($publicKey));
        return $publicKeyDetail['key'];
    }

    /**
     * @param $index
     * @return bool
     * @throws \Exception
     */
    public function atIsFileModified($index)
    {
        $publicKey = $this->atPublicKey($index);
        $plaintext = $this->atPlaintext($index);
        $signature = $this->atSignature($index);
        $authenticateAttribute = $this->atAuthenticateAttribute($index);
        $algorithmName = $this->atAlgorithm($index)->name();
        if ($authenticateAttribute) {
            $messageDigest = $this->getMessageDigestFromAuthenticateAttribute($authenticateAttribute);
            if (openssl_digest($plaintext, $algorithmName) === bin2hex($messageDigest)) {
                $plaintext = $authenticateAttribute;
            } else {
                return true;
            }
        }
        $success = openssl_verify($plaintext, $signature, $publicKey, $algorithmName);
        return $success == 1 ? false : true;
    }

    /**
     * @param $index int
     * @return bool
     * @throws \Exception
     */
    public function atVerifyTsa($index){
        $signature = $this->atSignature($index);
        $tsaPublicKey = $this->atTsaPublicKey($index);
        $tsaPkcs7DetachedDer = $this->atTsaPkcs7DetachedDer($index);
        $trueTsaPkcs7DetachedDer = $this->getTrueTsaPkcs7DetachedDer($tsaPkcs7DetachedDer);
        $TSTInfoDer = $this->getTSTInfoDerFromTsaPkcs7DetachedDer($tsaPkcs7DetachedDer);
        $messageImprintDigest = $this->getMessageImprintDigestFromTSTInfoDer($TSTInfoDer);
        $tsaAlgorithm = $this->getAlgorithmFromTSTInfoDer($TSTInfoDer);
        $timeStampPlainTextDigest = hex2bin(openssl_digest($signature,$tsaAlgorithm->name()));
        $tsaSignature = $this->getSignatureFromPkcs7DerDetachedDer($trueTsaPkcs7DetachedDer);
        if ($messageImprintDigest === $timeStampPlainTextDigest) {
            $authenticateAttribute = $this->getAuthenticateAttributeFromPkcs7DetachedDer($trueTsaPkcs7DetachedDer);
            $algorithm = $this->getAlgorithmFromPkcs7DetachedDer($trueTsaPkcs7DetachedDer);
            $success = openssl_verify($authenticateAttribute, $tsaSignature, $tsaPublicKey, $algorithm->name());
            if ($success == 1){
                $this->tsaTimestamps[$index] = $this->getTimestampFromTSTInfoDer($TSTInfoDer)->getTimestamp();
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * @param $index
     * @return null|string
     * @throws \Exception
     */
    public function atAuthenticateAttribute($index)
    {
        $pkcs7DerDetachedDer = $this->atPkcs7DetachedDer($index);
        return $this->getAuthenticateAttributeFromPkcs7DetachedDer($pkcs7DerDetachedDer);
    }

    /**
     * @param $pkcs7DerDetachedDer string
     * @return null|string
     */
    public function getAuthenticateAttributeFromPkcs7DetachedDer($pkcs7DerDetachedDer){
        $seq = UnspecifiedType::fromDER(
            $pkcs7DerDetachedDer
        )->asSequence()
            ->at(1)->asTagged()
            ->asExplicit()->asSequence()
            ->at(4)->asSet()->at(0)->asSequence();
        if ($seq->count() >= 6) {
            return hex2bin('31') . substr($seq->at(3)->asElement()->toDER(), 1);
        } else {
            return null;
        }
    }

    public function getMessageDigestFromAuthenticateAttribute($authenticateAttribute)
    {
        $set = UnspecifiedType::fromDER($authenticateAttribute)->asSet();
        return $set->at(2)->asSequence()->at(1)->asSet()->at(0)->asOctetString()->string();
    }

    /**
     * @param $index
     * @throws \Exception
     * @return AlgorithmIdentifier
     */
    public function atAlgorithm($index)
    {
        return $this->getAlgorithmFromPkcs7DetachedDer($this->atPkcs7DetachedDer($index));
    }

    /**
     * @param $der
     * @return AlgorithmIdentifier
     */
    public function getAlgorithmFromPkcs7DetachedDer($der){
        $IdentifierFactory = new AlgorithmIdentifierFactory();
        $class = $IdentifierFactory->getClass(UnspecifiedType::fromDER(
            $der
        )->asSequence()
            ->at(1)->asTagged()
            ->asExplicit()->asSequence()
            ->at(4)->asSet()->at(0)->asSequence()->at(2)->asSequence()->at(0)->asObjectIdentifier()->oid()
        );
        return new $class;
    }

    /**
     * @param $index
     * @return array
     * @throws \Exception
     */
    public function atCertInfo($index)
    {
        $result = openssl_x509_parse($this->atX509Pem($index));
        if ($result) {
            return [
                'sign_date' => date('Y-m-d H:i:s', $this->signTime[$index]),
                'cn' => $result['subject']['CN'],
                'issuer_o' => $result['issuer']['O'],
                'serial_number' => $result['serialNumber'],
                'valid_from' => $result['validFrom'],
                'valid_to' => $result['validTo'],
                'is_file_modified' => $this->atIsFileModified($index),
            ];
        }
        throw new \Exception('cert parse error');
    }

    /**
     * @param $index int
     * @return array
     * @throws \Exception
     */
    public function getTimestampInfo($index)
    {
        if ($this->atTsaPkcs7DetachedDer($index)) {
            return [
                'is_use_timestamp' => true,
                'is_valid_timestamp' => isset($this->tsaTimestamps[$index]),
                'timestamp' => date('Y-m-d H:i:s', $this->tsaTimestamps[$index])
            ];
        } else {
            return [
                'is_use_timestamp' => false,
                'timestamp' => '',
                'is_valid_timestamp' => false,
            ];
        }
    }

    /**
     * @return bool
     */
    public function hasAddContentAfterSign()
    {
        $lastIndex = count($this->byteRanges) - 1;
        $lastByteRange = $this->byteRanges[$lastIndex];
        $signContentLen = $lastByteRange[2] + $lastByteRange[3];
        if (strlen($this->pdfContent) > $signContentLen) {
            return true;
        } else {
            return false;
        }
    }
}