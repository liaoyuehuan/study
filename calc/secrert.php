<?php
$rand = floor(microtime(true) * 1000);
$secret = sha1($rand, false);
echo strlen($secret) . ': ' . $secret . PHP_EOL;

//password_hash default
$secret = password_hash($rand, PASSWORD_DEFAULT);
echo strlen($secret) . ': ' . $secret . PHP_EOL;
echo 'verify: ' . password_verify($rand, $secret) . PHP_EOL;
//password_hash bcrypt
$options = [
    'cost' => 13,
];
$secret = password_hash($rand, PASSWORD_BCRYPT, $options);
echo strlen("$secret") . ': ' . $secret . PHP_EOL;

echo PHP_INT_MAX . ':' .number_format(pow(2, 63) . PHP_EOL,'0','','');




