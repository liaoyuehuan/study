<?php
define('DIR', __DIR__);
define('CONS1', 4);
define('CONS2', 3);
$user_ini_file = __DIR__ . '/user.ini';
$arr = parse_ini_file($user_ini_file);
var_dump($arr);
