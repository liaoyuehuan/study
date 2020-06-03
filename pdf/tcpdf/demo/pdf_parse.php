<?php
require_once __DIR__ . '/../tcpdf_parser.php';

$parse = new TCPDF_PARSER(file_get_contents(__DIR__.'/test.pdf'));
var_dump($parse->getParsedData());
