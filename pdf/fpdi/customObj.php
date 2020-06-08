<?php
//require_once __DIR__ . '/lib/fpdf/fpdf.php';
require_once __DIR__ . '/lib/chiness-fpdf/chinese.php';
require_once __DIR__ . '/../../vendor/autoload.php';

use setasign\Fpdi\Fpdi;

$sourceFile = __DIR__ . '/files/example_052.pdf';
$pdf = new Fpdi('P','mm','A4');
$pdf->AddPage();
$pdf->setSourceFile($sourceFile);
$tplIndex = $pdf->importPage(1);
// now write some text above the imported page
$pdf->useTemplate($tplIndex);
$pdf->setCustomData('hello');
$buf = $pdf->Output('S');
echo $buf;

preg_match('/hello/',$buf,$match);
var_dump($match);
