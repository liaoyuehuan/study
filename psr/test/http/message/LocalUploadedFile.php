<?php
/**
 * Created by PhpStorm.
 * User: hj
 * Date: 2019-12-21
 * Time: 11:05
 */

namespace psr\test\http\message;

use Psr\Http\Message\UploadedFileInterface;

class LocalUploadedFile implements UploadedFileInterface
{

    private $clientFilename;

    private $clientMediaType;

    private $temName;

    private $error;

    private $size;

    private $isMoved = false;

    public function __construct(array $fileInfo)
    {
        $this->clientFilename = $fileInfo['name'];
        $this->clientMediaType = $fileInfo['type'];
        $this->temName = $fileInfo['tmp_name'];
        $this->error = $fileInfo['error'];
        $this->size = $fileInfo['size'];
    }

    /**
     * 注意：如果已嗲用了 moveTo 函数，则需要抛出异常
     * @throws \RuntimeException in cases when no stream is available.
     * @throws \RuntimeException in cases when no stream can be created.
     * @return \Psr\Http\Message\StreamInterface|FileStream
     */
    public function getStream()
    {
        if ($this->isMoved) {
            throw new \RuntimeException('in cases when no stream is available');
        }
        if (empty($this->temName)) {
            throw new \RuntimeException('in cases when no stream can be created');
        }
        return new FileStream($this->temName);
    }

    /**
     * 注意：
     * 1、当时sapi的$_FILE时，需要使用is_uploaded_file()、move_uploaded_file()来确保安全性、和上传状态
     * @throws \InvalidArgumentException if the $targetPath specified is invalid.
     * @throws \RuntimeException on any error during the move operation.
     * @throws \RuntimeException on the second or subsequent call to the method.
     * @param string $targetPath
     */
    public function moveTo($targetPath)
    {
        if ($this->isMoved) {
            throw new \InvalidArgumentException('the second call to the method');
        }
        if (false === is_uploaded_file($this->temName)) {
            throw new \InvalidArgumentException('is not a uploaded file');
        }
        if (false === move_uploaded_file($this->temName, $targetPath)) {
            throw new \InvalidArgumentException("error during the move operation");
        }
        $this->isMoved = true;
    }

    public function getSize()
    {
        return $this->size;
    }

    /**
     *
     * 注意：成功请返回 UPLOAD_ERR_OK
     * @return int One of PHP's UPLOAD_ERR_XXX constants.
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * 注意：
     * 1、不要相信这个客户端传过来的值
     * @return null|string
     */
    public function getClientFilename()
    {
        return $this->clientFilename;
    }

    /**
     * 注意：
     * 1、不要相信这个客户端传过来的值
     * @return null|string
     */
    public function getClientMediaType()
    {
        return $this->clientMediaType;
    }

}