<?php
require_once __DIR__ . '/LibReOffice.php';

$obj = \Xl\LibReOffice::newLibReOffice("asdfsdfsfsfsdf");
$obj->setPdfToWord();
var_dump($obj->buildCmd()) . PHP_EOL;
var_dump($obj->getOutputFile());

