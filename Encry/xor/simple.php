<?php
$secret = '123456';
$sha256 = hash('sha256', $secret);

$m = 'hello';
$c = $m ^ $sha256;
echo "密文：" . base64_encode($c) . PHP_EOL;
$p = $c ^ $sha256;
echo "明文：" . explode('|', $p)[0] . PHP_EOL;