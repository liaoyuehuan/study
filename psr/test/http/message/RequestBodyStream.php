<?php

namespace psr\test\http\message;

use Psr\Http\Message\StreamInterface;

class RequestBodyStream implements StreamInterface
{

    private $offset = 0;

    private $buffer = '';

    private $isClose = true;

    public function __construct($buffer = '')
    {
        $this->buffer = $buffer;
    }

    public function __toString()
    {
        return $this->buffer;
    }

    public function close()
    {
        $this->isClose = true;
    }

    public function detach()
    {
        $this->isClose = true;
        return $this->buffer;
    }

    public function getSize()
    {
        return strlen($this->buffer);
    }

    public function tell()
    {
        return $this->offset;
    }

    public function eof()
    {
        return strlen($this->buffer) === $this->offset;
    }

    public function isSeekable()
    {
        return true;
    }

    public function seek($offset, $whence = SEEK_SET)
    {
        $tmpOffset = null;
        if ($whence == SEEK_SET) {
            $tmpOffset = $offset;
        } else if ($whence == SEEK_CUR) {
            $tmpOffset += $offset;
        } else if ($whence == SEEK_END) {
            $tmpOffset = strlen($this->buffer) + $whence;
        } else {
            throw new \InvalidArgumentException('invalid whence');
        }
        $this->offset = $this->getOffset($tmpOffset);
    }

    public function rewind()
    {
        $this->offset = 0;
        return true;
    }

    public function isWritable()
    {
        return true;
    }

    public function write($string)
    {
        $this->buffer .= $string;
        $this->offset = strlen($this->buffer);
        return strlen($string);
    }

    public function isReadable()
    {
        return true;
    }

    public function read($length)
    {
        $buf = substr($this->buffer, $this->offset, $length);
        $this->offset = $this->getOffset($length + $this->offset);
        return $buf;
    }

    public function getContents()
    {
        $buf = substr($this->buffer, $this->offset);
        $this->offset = strlen($this->buffer);
        return $buf;
    }

    public function getMetadata($key = null)
    {
        return [];
    }

    private function getOffset($offset)
    {
        if ($offset < 0) {
            $offset = 0;
        } else if ($offset > strlen($this->buffer)) {
            $offset = strlen($this->buffer);
        }
        return $offset;
    }

}