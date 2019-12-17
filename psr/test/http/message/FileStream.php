<?php

namespace psr\test\http\message;

class FileStream implements \Psr\Http\Message\StreamInterface
{

    protected $fp;

    protected $file;

    public function __construct($file)
    {
        $this->file = $file;
        # 为移植性考虑，强烈建议在用 fopen() 打开文件时总是使用 'b' 标记。
        $this->fp = fopen($file, 'rb+');
    }

    public function __toString()
    {
        return fread($this->fp, $this->getSize());
    }

    public function close()
    {
        fclose($this->fp);
    }

    public function detach()
    {
        $toFile = tempnam(sys_get_temp_dir(), 't_');
        if (copy($this->file, $toFile)) {
            return fopen($toFile, 'rb+');
        } else {
            return null;
        }
    }

    public function getSize()
    {
        return fstat($this->fp)['size'];
    }

    public function tell()
    {
        return ftell($this->fp);
    }

    public function eof()
    {
        return feof($this->fp);
    }

    public function isSeekable()
    {
        return true;
    }

    public function seek($offset, $whence = SEEK_SET)
    {
        # fseek($this->fp, -2, $whence, SEEK_END);
        fseek($this->fp, $offset, $whence);
    }

    public function rewind()
    {
        return rewind($this->fp);
    }

    public function isWritable()
    {
        return true;
    }

    public function write($string)
    {
        return fwrite($this->fp, $string);
    }

    public function isReadable()
    {
        return true;
    }

    public function read($length)
    {
        return fread($this->fp, $length);
    }

    public function getContents()
    {
        return fread($this->fp, $this->getSize());
    }

    public function getMetadata($key = null)
    {
        [
            'timeout' => false,
            'blocked' => true,
            'eof' => true,
            'wrapper_type' => 'STDIO',
            'mode' => 'rb+',
            'unread_bytes' => 0,
            'seekable' => true,
            'uri' => 'D:\workspace\study\psr\demo/files/hello.txt'
        ];
        $mata = stream_get_meta_data($this->fp);
        if ($key) {
            return $mata[$key] ?? null;
        }
        return $mata;
    }

}