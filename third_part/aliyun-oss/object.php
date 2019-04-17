<?php
require_once __DIR__.'/../../vendor/autoload.php';

class TestObject {
    private $accessKeyId = 'LTAIvOPOcZB8C2a0';

    private $accessKeySeret = '1d4wXAmaPU9KSoDJZQCcAgI88TW83Q';

    private $endPoint = 'oss-cn-shenzhen.aliyuncs.com';

    private $testBucket = 'liaoyuehuan-test';

    /**
     * @return \OSS\OssClient
     */
    function newOssClient(){
        return new \OSS\OssClient($this->accessKeyId,$this->accessKeySeret,$this->endPoint);
    }

    function testPutObject(){
        $ossClient = $this->newOssClient();
        $res = $ossClient->putObject($this->testBucket,'test/hello.txt','hello oss');
        var_dump($res);
    }

    function testCopyObject(){
        $ossClient = $this->newOssClient();
        $res = $ossClient->copyObject($this->testBucket,'test/hello.txt',$this->testBucket,'test/hello-copy.txt');
        var_dump($res);
    }

    function testGetObject(){
        $ossClient = $this->newOssClient();
        $options = [
            \OSS\OssClient::OSS_FILE_DOWNLOAD => __DIR__.'/files/test-download.txt' //设置时，内容会保存在指定文件中
        ];
        $res = $ossClient->getObject($this->testBucket,'test/hello.txt',$options);
        var_dump($res);
    }
}
$obj = new TestObject();
$obj->testPutObject();