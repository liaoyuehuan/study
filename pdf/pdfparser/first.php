<?php
require_once __DIR__ . '/../../vendor/autoload.php';

$parse = new \Smalot\PdfParser\Parser();
$pdf = $parse->parseFile('C:\Users\hj\Desktop\萨达撒多.pdf');
$text = $pdf->getText();
echo $text;

var_dump($pdf->get());