<?php
$fInfo = new finfo();
echo '1|'.$fInfo->file(__DIR__ . '/fileinfo_files/test.pdf') . PHP_EOL; //PDF document, version 1.4

$fInfo = new finfo(FILEINFO_MIME_TYPE);
echo '2|'.$fInfo->file(__DIR__ . '/fileinfo_files/test.pdf') . PHP_EOL; //application/pdf
$fInfo->set_flags(FILEINFO_MIME_TYPE  | FILEINFO_MIME_ENCODING);
echo '3|'.$fInfo->buffer(file_get_contents(__DIR__ . '/fileinfo_files/test.pdf') ) . PHP_EOL;

#$fInfo = new finfo(FILEINFO_EXTENSION );
#echo $fInfo->file(__DIR__.'/fileinfo_files/test.pdf').PHP_EOL; // PHP 7.2.0 起有效。

echo '4|'.mime_content_type(__DIR__ . '/fileinfo_files/test.pdf') . PHP_EOL;; //application/pdf
echo '5|'.mime_content_type(__DIR__ . '/fileinfo_files/test.png') . PHP_EOL;; //image/png
echo '6|'.mime_content_type(__DIR__ . '/fileinfo_files/test.txt') . PHP_EOL;; //text/plain
echo '7|'.$fInfo->file(__DIR__ . '/fileinfo_files/test.txt',FILEINFO_SYMLINK) . PHP_EOL;; //t
echo '8|'.$fInfo->file(__DIR__ . '/fileinfo_files/test.txt',FILEINFO_MIME_ENCODING) . PHP_EOL;; //utf-8
echo '9|'.$fInfo->file(__DIR__ . '/fileinfo_files/test.txt',FILEINFO_CONTINUE) . PHP_EOL;; //
echo '10|'.$fInfo->file(__DIR__ . '/fileinfo_files/test.pdf',FILEINFO_PRESERVE_ATIME) . PHP_EOL; //t