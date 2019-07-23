<?php
require_once __DIR__ . '/lib/fpdf/fpdf.php';
require_once __DIR__ . '/../../vendor/autoload.php';

use setasign\Fpdi\Fpdi;

$sourceFile = __DIR__ . '/files/example_052.pdf';
$pdf = new Fpdi('P','mm','A4');
$pdf->AddPage();
$pdf->SetFont('helvetica');
$pdf->Write(0,'first');
$buf = $pdf->Output('S');
echo $buf;
