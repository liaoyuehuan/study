<?php
require_once __DIR__ . '/../../vendor/autoload.php';

class TestMultipartUpload
{

    private $accessKeyId = 'LTAIvOPOcZB8C2a0';

    private $accessKeySeret = '1d4wXAmaPU9KSoDJZQCcAgI88TW83Q';

    private $endPoint = 'oss-cn-shenzhen.aliyuncs.com';

    private $testBucket = 'liaoyuehuan-test';

    /**
     * @return \OSS\OssClient
     */
    function newOssClient()
    {
        return new \OSS\OssClient($this->accessKeyId, $this->accessKeySeret, $this->endPoint);
    }

    function testInitiateMultipartUpload()
    {
        $client = $this->newOssClient();
        $uploadId = $client->initiateMultipartUpload($this->testBucket, 'test/big-file.zip');
        var_dump($uploadId);
    }

    function testMulUpload()
    {
        $client = $this->newOssClient();
        $uploadId = $client->initiateMultipartUpload($this->testBucket, 'test/big-file.zip');
        $filename = 'D:\360安全浏览器下载\itextpdf-5.1.2.jar.zip';
        $partSize = 1024 * 200 * 1;
        $fileSize = filesize($filename);
        $listPart = [];
        for ($i = 0, $partNumber = 1; $i < $fileSize; $i += $partSize, $partNumber++) {
            $end = $i + $partSize;
            if ($end > $fileSize) {
                $end = $fileSize;
            }
            $eTag = $client->uploadPart($this->testBucket, 'test/big-file.zip', $uploadId, [
                \OSS\OssClient::OSS_FILE_UPLOAD => $filename,
                \OSS\OssClient::OSS_PART_NUM => $partNumber,
                \OSS\OssClient::OSS_SEEK_TO => $i,
                \OSS\OssClient::OSS_LENGTH => $end - $i,
                \OSS\OssClient::OSS_CHECK_MD5 => true,
            ]);
            echo $eTag . PHP_EOL;
            $listPart[] = [
                'PartNumber' => $partNumber,
                'ETag' => $eTag
            ];
        }
        $res = $client->completeMultipartUpload($this->testBucket, 'test/big-file.zip', $uploadId, $listPart);
        var_dump($res);
    }

}

$obj = new TestMultipartUpload();
$obj->testMulUpload();