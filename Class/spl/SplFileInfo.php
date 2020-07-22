<?php
$fileInfo  = new SplFileInfo(__DIR__.'/../../aa.txt');

## 时间
echo "getATime : {$fileInfo->getATime()}".PHP_EOL;
echo "getCTime : {$fileInfo->getCTime()}".PHP_EOL;
echo "getMTime : {$fileInfo->getMTime()}".PHP_EOL;
# 路径
echo "getBasename : {$fileInfo->getBasename()}".PHP_EOL;
echo "getFilename : {$fileInfo->getFilename()}".PHP_EOL;
echo "getPathname : {$fileInfo->getPathname()}".PHP_EOL;
echo "getRealPath : {$fileInfo->getRealPath()}".PHP_EOL;
echo "getPath : {$fileInfo->getPath()}".PHP_EOL;
echo "getLinkTarget : {$fileInfo->getLinkTarget()}".PHP_EOL;
echo PHP_EOL;

# 权限
echo "getGroup : {$fileInfo->getGroup()}".PHP_EOL;
echo "getOwner : {$fileInfo->getOwner()}".PHP_EOL;
echo "getPerms : {$fileInfo->getPerms()}".PHP_EOL;
echo PHP_EOL;

# 基本信息
echo "extension : {$fileInfo->getExtension()}".PHP_EOL;
echo "getInode : {$fileInfo->getInode()}".PHP_EOL;
echo "getType : {$fileInfo->getType()}".PHP_EOL;
echo "getSize : {$fileInfo->getSize()}".PHP_EOL;
echo PHP_EOL;

# 判断
echo "isDir : {$fileInfo->isDir()}".PHP_EOL;
echo "isExecutable : {$fileInfo->isExecutable()}".PHP_EOL;
echo "isFile : {$fileInfo->isFile()}".PHP_EOL;
echo "isLink : {$fileInfo->isLink()}".PHP_EOL;
echo "isReadable : {$fileInfo->isReadable()}".PHP_EOL;
echo "isWritable : {$fileInfo->isWritable()}".PHP_EOL;

echo PHP_EOL;








