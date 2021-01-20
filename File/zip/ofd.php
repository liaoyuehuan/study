<?php
$file = __DIR__ . '/temp/DownLoadTemp.ofd';
$zip = new ZipArchive();
$zip->open($file);
$count = $zip->count();
for ($i = 0; $i < $count; $i++) {
    $filename = $zip->getNameIndex($i);
    echo "{$filename}" . PHP_EOL;
}

var_dump($zip->getFromName('Doc_0/Attachs/结构化数据文件.xml'));
