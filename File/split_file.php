<?php

$file = 'D:\360安全浏览器下载\DNGS_GHOST_WIN10_X64_V2019_10.zip';
$chunkSize = 1024 * 1024 * 100;
$fileBaseName = 'D:/360安全浏览器下载/win10-ios/win10X64-';
function splitFile($file, $chunkSize, $fileBaseName, $ext = 'buf')
{

    $fp = fopen($file, 'r');
    $index = 0;
    while ($buf = fread($fp, $chunkSize)) {
        $index++;
        $indexNo = str_pad($index, 3, '0', STR_PAD_LEFT);
        $len = file_put_contents("{$fileBaseName}{$indexNo}.{$ext}", $buf);
        echo sprintf("{$index} -- {$len} success\r\n");
        unset($buf);
    }
}

function combineFile($dir, $outfile, $ext = 'buf')
{
    $patten = "{$dir}/*.buf";
    $bufFiles = glob($patten);
    file_put_contents($outfile,'');
    foreach ($bufFiles as $bufFile) {
        $buf = file_get_contents($bufFile);
        $len = file_put_contents($outfile,$buf,FILE_APPEND);
        echo sprintf("{$len} success\r\n");
        unset($buf);
    }
}

$outfile = 'F:\game\win系统\win10-x64.zip';
$dir = 'F:/game/win系统/win10-ios/';
//splitFile($file, $chunkSize, $fileBaseName);
combineFile($dir,$outfile);




