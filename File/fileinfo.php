<?php
$fInfo = new finfo();
echo $fInfo->file(__DIR__.'/fileinfo_files/test.pdf').PHP_EOL; //PDF document, version 1.4

$fInfo = new finfo(FILEINFO_MIME_TYPE);
echo $fInfo->file(__DIR__.'/fileinfo_files/test.pdf').PHP_EOL; //application/pdf

#$fInfo = new finfo(FILEINFO_EXTENSION );
#echo $fInfo->file(__DIR__.'/fileinfo_files/test.pdf').PHP_EOL; // PHP 7.2.0 起有效。

echo mime_content_type(__DIR__.'/fileinfo_files/test.pdf').PHP_EOL;; //application/pdf
echo mime_content_type(__DIR__.'/fileinfo_files/test.png').PHP_EOL;; //image/png
echo mime_content_type(__DIR__.'/fileinfo_files/test.txt').PHP_EOL;; //text/plain

