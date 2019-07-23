<?php
$hash1 = hash_file('sha256', 'http://cz-files.oss-cn-shenzhen.aliyuncs.com/pdf_tempa1ffaa8d0ee73e3b0cc3c03d941a9f8d.pdf');
$hash2 = openssl_digest(file_get_contents('http://cz-files.oss-cn-shenzhen.aliyuncs.com/pdf_tempa1ffaa8d0ee73e3b0cc3c03d941a9f8d.pdf'), 'sha256');
echo ($hash1 === $hash2) . PHP_EOL; // true

#### hash_init 与  hash ####
$hashCtx = hash_init('sha256');
hash_update($hashCtx, 'hello ');
hash_update($hashCtx, 'world');
$hash1 = hash_final($hashCtx);
$hash2 = hash('sha256', 'hello world');
echo ($hash1 === $hash2) . PHP_EOL; // true