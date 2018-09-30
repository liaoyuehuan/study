<?php

/**
 * @soap_version SOAP_1_1 | SOAP_1_2
 * @encoding utf-8
 * @trace boolean
 * @classmap array('book' => "xl\\MyBook")
 * @cache_wsdl  WSDL_CACHE_MEMORY | WSDL_CACHE_BOTH |  WSDL_CACHE_DISK | WSDL_CACHE_NONE
 * @user_agent
 * @ssl_method  SOAP_SSL_METHOD_SSLv2 |  SOAP_SSL_METHOD_SSLv2 | SOAP_SSL_METHOD_SSLv3 | SOAP_SSL_METHOD_SSLv23
 * @keep_alive boolean
 */
define('testUrl', 'http://bswg2.95105813.cn:8080/AGW/services/AGWService?wsdl');
define('url', 'http://dbagw.95105813.cn/AGW/services/AGWService?wsdl');
define('tsa_url','http://bswg2.95105813.cn:8280/tsp/services/TSPService?wsdl');

class CertUniqueIDReq extends SOAPable
{
    public $cert;
}

abstract class SOAPable
{
    public function getAsSOAP()
    {

        foreach ($this as $key => &$value) {
            $this->prepareSOAPrecursive($this->$key);
        }
        return $this;
    }

    private function prepareSOAPrecursive(&$element)
    {
        if (is_array($element)) {
            foreach ($element as $key => &$val) {
                $this->prepareSOAPrecursive($val);
            }
            $element = new SoapVar($element, SOAP_ENC_ARRAY);
        } elseif (is_object($element)) {
            if ($element instanceof SOAPable) {
                $element->getAsSOAP();
            }
            $element = new SoapVar($element, SOAP_ENC_OBJECT);
        }
    }
}


function testCaGetCert()
{
    libxml_disable_entity_loader(false);
    ini_set('soap.wsdl_cache_enabled', 0);
    ini_set('soap.wsdl_cache_ttl', 0);
    try {
        $soap = new SoapClient(url, ['trace' => true]);
        $return = $soap->WS_GetCert();
        var_dump($return);
    } catch (SoapFault $e) {
        echo $soap->__getLastRequest() . PHP_EOL;
        echo $soap->__getLastResponse() . PHP_EOL;
        echo $e->getMessage();
    }


}

//fail
function testCaHashData()
{

    $soap = new SoapClient(testUrl);
    $hashReq = [
        'appID' => 'GDCATest',
        'operID' => 'VerifySign',
        'hashAlgo' => 'md5',
        'orgData' => 'hello'
    ];
    $return = $soap->WS_HashData($hashReq);
    var_dump($return);
}

function testGetTime()
{
    $soap = new SoapClient(testUrl);
    $return = $soap->WS_GetTime();
    var_dump($return);
}

function testGenRand()
{
    $soap = new SoapClient(testUrl);
    $return = $soap->WS_GenRand([
        'rand_len' => 2
    ]);
    var_dump($return);

}

function testCheckCert()
{
    $cert = file_get_contents(__DIR__ . '/ssl/cert.der');
    libxml_disable_entity_loader(false);
    $cert = base64_encode($cert);
    $soap = new SoapClient(testUrl, [
        'trace' => true
    ]);
    try {
        $return = $soap->WS_CheckCert([
            'appID' => 'GDCATest',
            'operID' => 'VerifySign',
            'cert' => $cert
        ]);
        var_dump($return);
    } catch (SoapFault $e) {
        var_dump($soap->__getLastResponseHeaders());
        echo $e->getMessage() . PHP_EOL;
        echo $e->getTraceAsString() . PHP_EOL;
    }
}


function testGetCertUniqueID()
{
    $cert = file_get_contents(__DIR__ . '/ssl/cert.der');
    libxml_disable_entity_loader(false);
    $cert = base64_encode($cert);
    $soap = new SoapClient(testUrl, [
        'trace' => true,
        'classmap' => [
            'CertUniqueIDReq' => 'CertUniqueIDReq'
        ]
    ]);
    try {

        $return = $soap->WS_GetCertUniqueID([
            'req' => [
                'cert' => $cert
            ]
        ]);
        var_dump($return);
    } catch (SoapFault $e) {
        var_dump($soap->__getLastRequestHeaders());
        var_dump($soap->__getLastResponseHeaders());
        echo $e->getMessage() . PHP_EOL;
        echo $e->getTraceAsString() . PHP_EOL;
    }
}


function testSealTimeStamp()
{
    $client = new SoapClient(tsa_url, [
        'trace' => true,
        'soap_version' => SOAP_1_2
    ]);
    try {
        $return = $client->SealTimeStamp([
            'req' => [
                'algType' => 'rsa',
                'orgData' => 'hello world'
            ]
        ]);
        var_dump($return);
    } catch (SoapFault $e) {
        var_dump($client->__getLastResponseHeaders());
        throw $e;
    }
}

testSealTimeStamp();


