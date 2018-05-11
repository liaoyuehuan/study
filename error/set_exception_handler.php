<?php

ini_set('display_errors','On');
ini_set('ignore_repeated_errors','On');
ini_set('error_prepend_string','error prepend');
ini_set('error_append_string','error append'.PHP_EOL);
ini_set('ignore_repeated_source','Off');
ini_set('html_errors','Off');
ini_set('log_errors','Off');
ini_set('error_log','D:/php_error.log');

/*set_exception_handler(function (Throwable $e) {
    echo 'exception : ' . $e->getMessage() . PHP_EOL;
});

set_error_handler(function ($code, $message, $file = '', $line = 0) {
    echo 'error: ' . $code . ' ' . $message . '' . $file . ' line:' . $line . PHP_EOL;
});*/

echo $a;

for ($i = 3; $i < 10; $i++) {
    echo $b;
}
throw new Exception('haha');

