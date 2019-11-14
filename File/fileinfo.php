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
echo '11|'.$fInfo->file(__DIR__ . '/fileinfo_files/test.pdf',FILEINFO_EXTENSION) . PHP_EOL; //t

echo json_encode([
    'TranType' => '9908',
    'BusiType' => '0001',
    'Version' => '20140728',
    'MerId' => '739211907190001',
//    'MerOrderNo' => '',
//    'TranDate' => date('Ymd', $orderNoticeSeparateService['trade_time']),
//    'TranTime' => date('His', $orderNoticeSeparateService['trade_time']),
//    'OriOrderNo' => '',
//    'OriTranDate' => '',
//    'OrderAmt' => bcmul($order['real_pay'], 100)
]);