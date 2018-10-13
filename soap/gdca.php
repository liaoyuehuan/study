<?php


define('WSDL_URL', 'http://bswg2.95105813.cn:8080/AGW/services/AGWService?wsdl');

ini_set('display_errors', 'On');
error_reporting(E_ALL);

function testGetCertUniqueID()
{
    $client = new SoapClient(WSDL_URL, [
        'style' => SOAP_DOCUMENT,
        'trace' => true,
        'soap_version' => SOAP_1_2,
        'keep_alive' => true,
        'cache_wsdl ' => WSDL_CACHE_NONE,
        'use' => SOAP_LITERAL,
    ]);
    try {
        libxml_disable_entity_loader(false);
        $certBase64 = base64_encode(file_get_contents(__DIR__ . '/server.csr'));
        $return = $client->WS_GetCertUniqueID( ['req' => ['cert' => $certBase64]]);
//        $return = $client->__soapCall('WS_GetCertUniqueID',
//            [
//                ['req' => ['cert' => $certBase64]]
//            ]
//        );
        var_dump($return);
    } catch (SoapFault $e) {

        var_dump($client->__getLastRequestHeaders());
        var_dump($client->__getLastResponseHeaders());
//        throw $e;
    }
}

function testFunc()
{
    $client = new SoapClient(WSDL_URL);
    var_dump($client->__getFunctions());
}

function testTypes()
{
    $client = new SoapClient(WSDL_URL);
    var_dump(array_filter($client->__getTypes(), function ($value) {
        if (strstr(strtolower($value), 'unique')) {
            return true;
        } else {
            return false;
        }
    }));
}

testGetCertUniqueID();