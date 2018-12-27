<?php
require_once __DIR__ . '/LibReOffice.php';

$obj = \Xl\LibReOffice::newLibReOffice("asdfsdfsfsfsdf");
var_dump($obj->buildCmd()) . PHP_EOL;

