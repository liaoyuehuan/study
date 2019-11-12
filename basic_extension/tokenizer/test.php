<?php
$res = token_get_all(file_get_contents(__DIR__ . '/token_file.php'));
foreach ($res as $token) {
    if (is_array($token)) {
        $tokenName = token_name($token[0]);
        echo "token_name :{$tokenName} str : {$token[1]}" . PHP_EOL;
    } else {
        echo "str : {$token}" . PHP_EOL;
    }

}