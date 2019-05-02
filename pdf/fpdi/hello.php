<?php
require_once __DIR__ . '/lib/fpdf/fpdf.php';
require_once __DIR__ . '/../../vendor/autoload.php';

use setasign\Fpdi\Fpdi;

$sourceFile = __DIR__ . '/files/example_052.pdf';
$pdf = new Fpdi('P','mm','A4');

$pdf->AddPage();
$pdf->setSourceFile($sourceFile);
$tplIndex = $pdf->importPage(1);
// now write some text above the imported page
$pdf->useTemplate($tplIndex);
$pdf->SetFont('helvetica.php');
$pdf->SetTextColor(255, 0, 0);
$pdf->SetXY(50, 50);
$pdf->Write(0, 'This is just a simple text');

# 导入pdf文档
$count = $pdf->setSourceFile(__DIR__ . '/files/pdf_tempa1ffaa8d0ee73e3b0cc3c03d941a9f8d.pdf');
for ($i = 1; $i <= $count; $i++) {
    $pdf->AddPage();
    $tplIndex = $pdf->importPage($i);
    $pdf->useTemplate($tplIndex);
}

# 增加文字描述
// now write some text above the imported page
$pdf->SetFont('Helvetica');
$pdf->SetTextColor(255, 0, 0);
$pdf->SetXY(50, 50);
$pdf->Write(0, 'This is just a simple text');

# 设置画线的颜色
$pdf->SetDrawColor(255, 0, 0);
# 设置线的大小
$pdf->SetLineWidth(0.1);
# 新增一条线
$pdf->Line(10, 30,200,30);

# 插入图片
$pdf->Image(__DIR__.'/files/ewm.png','5','5','20','20');

# 支持中文地址：https://github.com/DCgithub21/cd_FPDF
$pdf->Text(30,30,'我是中文');



$buf = $pdf->Output('F', __DIR__ . '/files/combine.pdf');
//file_put_contents(__DIR__ . '/files/combine.pdf', $buf);

