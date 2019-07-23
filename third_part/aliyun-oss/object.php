<?php
require_once __DIR__ . '/../../vendor/autoload.php';

class TestObject
{
    private $accessKeyId = 'LTAIvOPOcZB8C2a0';

    private $accessKeySeret = '1d4wXAmaPU9KSoDJZQCcAgI88TW83Q';

    private $endPoint = 'oss-cn-shenzhen.aliyuncs.com';

    private $testBucket = 'liaoyuehuan-test';

    /**
     * @return \OSS\OssClient
     * @throws \OSS\Core\OssException
     */
    function newOssClient()
    {
        return new \OSS\OssClient($this->accessKeyId, $this->accessKeySeret, $this->endPoint);
    }

    function testPutObject()
    {
        $ossClient = $this->newOssClient();
        $res = $ossClient->putObject($this->testBucket, 'test/hello.txt', 'hello oss');
        var_dump($res);
    }

    function testCopyObject()
    {
        $ossClient = $this->newOssClient();
        $res = $ossClient->copyObject($this->testBucket, 'test/hello.txt', $this->testBucket, 'test/hello-copy.txt');
        var_dump($res);
    }

    function testGetObject()
    {
        $ossClient = $this->newOssClient();
        $options = [
            \OSS\OssClient::OSS_FILE_DOWNLOAD => __DIR__ . '/files/test-download.txt' //设置时，内容会保存在指定文件中
        ];
        $res = $ossClient->getObject($this->testBucket, 'test/hello.txt', $options);
        var_dump($res);
    }

    function testUploadFile()
    {
        $ossClient = $this->newOssClient();
        $res = $ossClient->uploadFile($this->testBucket, 'test/test-upload.txx', 'D:\360安全浏览器下载\itextpdf-5.1.1-javadoc.jar.zip');
        var_dump($res);
    }

    function testEncryption()
    {
        $ossClient = $this->newOssClient();
        $options = [
            \OSS\OssClient::OSS_HEADERS => [
                'x-oss-server-side-encryption' => 'AES256'
            ]
        ];
        $res = $ossClient->putObject($this->testBucket, 'test/test-encryption.txt', 'encrypt data', $options);
        var_dump($res);
    }

    function testUploadUrlResource(){
        $ossClient = $this->newOssClient();
        $url = 'http://218.85.80.181:12300/BaseSystemMgrWeb/ebidfile/getFileBySn/d18b3432-db0a-4157-9fea-dc11e8d20b24.xhtml';
        $resource = fopen($url,'r');
        require_once __DIR__.'/../../net/CurlUtils.php';
        $res = $ossClient->uploadResource($this->testBucket, 'test/test-resource.pdf', $resource);
        fclose($resource);
        var_dump($res);
    }
}

$obj = new TestObject();
$obj->testUploadUrlResource();