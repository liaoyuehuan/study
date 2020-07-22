<?php
$zip = new ZipArchive();
$zip->open(__DIR__ . '/temp/test.zip', ZipArchive::OVERWRITE);

# 设置压缩文件的comment，一般设置readme或介绍啥的
# $zip->setArchiveComment("this is a comment");

# 添加文件
$zip->addFromString("attach/aaa.pdf", file_get_contents(__DIR__ . '/resource/123.pdf'));
$zip->addFromString("aaa.pdf", file_get_contents(__DIR__ . '/resource/123.pdf'));
# 设置文件的压缩格式
$zip->setCompressionName("aaa.pdf",ZipArchive::CM_DEFAULT);

$zip->close();

echo "syccess";
