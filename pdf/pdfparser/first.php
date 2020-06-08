<?php
require_once __DIR__ . '/../../vendor/autoload.php';

$file = 'C:\Users\hj\Desktop\萨达撒多.pdf';
$file2 = 'D:/example_053.pdf';

$parse = new \Smalot\PdfParser\Parser();
$pdf = $parse->parseFile($file2);
$text = $pdf->getText();
echo $text;
