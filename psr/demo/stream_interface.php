<?php
include __DIR__ . '/../../vendor/autoload.php';
$file = __DIR__ . '/files/hello.txt';
$stream = new \psr\test\http\message\FileStream($file);
echo "__toString : {$stream}" . PHP_EOL;
#$stream->close();
echo "detach : {$stream->detach()}" . PHP_EOL;

echo "getSize : {$stream->getSize()}" . PHP_EOL;

echo "tell : {$stream->tell()}" . PHP_EOL;

echo "eof : {$stream->eof()}" . PHP_EOL;

echo "isSeekable : {$stream->isSeekable()}" . PHP_EOL;

$stream->seek(2);

echo "rewind : {$stream->rewind()}" . PHP_EOL;

echo "isWritable : {$stream->isWritable()}" . PHP_EOL;

echo "write : {$stream->write('hello file')}" . PHP_EOL;

echo "isReadable : {$stream->isReadable()}" . PHP_EOL;

echo "read : {$stream->read(5)}" . PHP_EOL;

echo "getContents : {$stream->getContents()}" . PHP_EOL;

echo "getMetaData : {$stream->getMetadata('seekable')}" . PHP_EOL;

