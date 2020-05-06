<?php
echo "com_guid \t\t: " . com_create_guid() . PHP_EOL;
echo "cus_guid \t\t: " . customGuid() . PHP_EOL;
echo "guid_optimize\t: " . guidOptimize() . PHP_EOL;

function customGuid()
{
    $timestamp = dechex(floor(microtime(true) * 1000));
    $timestampRand = dechex(mt_rand(0, 16));
    $str0 = substr($timestamp . $timestampRand, 0, 8);
    $str1 = substr($timestamp . $timestampRand, 8);
    $str2 = str_pad(dechex(mt_rand(0, 65535)), 4, '0' . STR_PAD_LEFT);
    $str3 = str_pad(dechex(mt_rand(0, 65535)), 4, '0', STR_PAD_LEFT);
    $str4 = str_pad(dechex(mt_rand(0, 65535)), 4, '0', STR_PAD_LEFT) .
        str_pad(dechex(mt_rand(0, 65535)), 4, '0', STR_PAD_LEFT) .
        str_pad(dechex(mt_rand(0, 65535)), 4, '0', STR_PAD_LEFT);
    return strtoupper("{{$str0}-{$str1}-{$str2}-{$str3}-{$str4}}");
}

function guidOptimize()
{
    $uniQId = uniqid() . mt_rand(0, 9);
    $str0 = substr($uniQId, 0, 8);
    $str1 = substr($uniQId, 8, 4);
    $str2 = substr($uniQId, 8, 2) . dechex(mt_rand(0, 256));
    $str3 = bin2hex(openssl_random_pseudo_bytes(2));
    $str4 = bin2hex(openssl_random_pseudo_bytes(6));
    return strtoupper("{{$str0}-{$str1}-{$str2}-{$str3}-{$str4}}");
}

function testGuid(callable $guidFunc)
{
    $guidList = [];
    for ($i = 1; $i <= 100000; $i++) {
        $guid = $guidFunc();
        $guidList[$guid] = 1;
    }
    var_dump(count($guidList));
}

echo '############# customGuid  #############' . PHP_EOL;
for ($i = 1; $i <= 5; $i++) {
    $start = floor(microtime(true) * 1000);
    testGuid('customGuid');
    $end = floor(microtime(true) * 1000);
    echo 'spend ' . ($end - $start) . 'ms' . PHP_EOL;
}
echo '############# guidOptimize  #############' . PHP_EOL;
for ($i = 1; $i <= 5; $i++) {
    $start = floor(microtime(true) * 1000);
    testGuid('guidOptimize');
    $end = floor(microtime(true) * 1000);
    echo 'spend ' . ($end - $start) . 'ms' . PHP_EOL;
}

echo '############# com_guid  #############' . PHP_EOL;
for ($i = 1; $i <= 5; $i++) {
    $start = floor(microtime(true) * 1000);
    testGuid('com_create_guid');
    $end = floor(microtime(true) * 1000);
    echo 'spend ' . ($end - $start) . 'ms' . PHP_EOL;
}

echo '############# uniqid  #############' . PHP_EOL;
for ($i = 1; $i <= 5; $i++) {
    $start = floor(microtime(true) * 1000);
    testGuid('uniqid');
    $end = floor(microtime(true) * 1000);
    echo 'spend ' . ($end - $start) . 'ms' . PHP_EOL;
}
