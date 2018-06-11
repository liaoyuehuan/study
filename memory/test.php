<?php

ini_set('display_errors', 'On');
ini_set('html_errors', false);
ini_set('error_append_string', '');
ini_set('error_prepend_string', '');
error_reporting(E_ALL);
$a = '1';
xdebug_debug_zval('a');
$b = $a;
xdebug_debug_zval('a');
xdebug_debug_zval('b');
$c = &$a;
xdebug_debug_zval('a');
xdebug_debug_zval('c');
unset($c);
xdebug_debug_zval('a');
xdebug_debug_zval('c');

$c = &$a;
xdebug_debug_zval('a');
xdebug_debug_zval('c');

$a = null;
xdebug_debug_zval('a');
echo memory_get_usage().PHP_EOL;
echo memory_get_usage().PHP_EOL;
