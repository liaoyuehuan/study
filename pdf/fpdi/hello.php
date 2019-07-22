<?php
require_once __DIR__ . '/lib/chiness-fpdf/chinese.php';
require_once __DIR__ . '/../../vendor/autoload.php';

use setasign\Fpdi\Fpdi;

$sourceFile = __DIR__ . '/files/compress.pdf';
$pdf = new Fpdi('P', 'mm', 'A4');

$pdf->AddPage();
$pdf->setSourceFile($sourceFile);
$tplIndex = $pdf->importPage(1);
// now write some text above the imported page
$pdf->useTemplate($tplIndex);
$pdf->SetFont('helvetica');
$pdf->SetTextColor(255, 0, 0);
$pdf->SetXY(50, 50);
$pdf->Write(0, 'This is just a simple text');

# 导入pdf文档
$count = $pdf->setSourceFile(__DIR__ . '/files/combine.pdf');
for ($i = 1; $i <= $count; $i++) {
    $pdf->AddPage();
    $tplIndex = $pdf->importPage($i);
    $pdf->useTemplate($tplIndex);
}

# 增加文字描述
// now write some text above the imported page
$pdf->SetTextColor(255, 0, 0);
$pdf->SetXY(50, 50);
$pdf->Write(0, 'This is just a simple text');

# 设置画线的颜色
$pdf->SetDrawColor(255, 0, 0);
# 设置线的大小
$pdf->SetLineWidth(0.1);
# 新增一条线
$pdf->Line(10, 30, 200, 30);

# 插入图片
$pdf->Image(__DIR__ . '/files/ewm.png', '5', '5', '20', '20');

# 支持中文地址：https://github.com/DCgithub21/cd_FPDF
$pdf->AddGBFont('simhei', '黑体');
$pdf->SetFont('simhei', '', 13);
$pdf->Text(30, 30, iconv("utf-8", "gbk", "我是中文"));

# 解决使用中文后，英文字符占两个字符位置问题
$func = function ($x, $y, $txt, $family = 'simhei', $style = '', $size = 0) use ($pdf)
{
    $pdf->SetXY($x, $y - 2);
    $pdf->SetAutoPageBreak(false);
    $len = mb_strlen($txt);
    $isChinese = function ($char) {
        return preg_match('/[\x{4e00}-\x{9fa5}]/u', $char) ? true : false;
    };
    $isChinesePunctuation = function ($char) {
        return preg_match('/[\x{3002}|\x{ff1f}|\x{ff01}|\x{ff0c}|\x{3001}|\x{ff1b}|\x{ff1a}|\x{201c}|\x{201d}|\x{2018}|\x{2019}|\x{ff08}|\x{ff09}|\x{300a}|\x{300b}|\x{3008}|\x{3009}|\x{3010}|\x{3011}|\x{300e}|\x{300f}|\x{300c}|\x{300d}|\x{fe43}|\x{fe44}|\x{3014}|\x{3015}|\x{2026}|\x{2014}|\x{ff5e}|\x{fe4f}|\x{ffe5}]/u', $char) ? true : false;
    };
    for ($i = 0; $i < $len; $i++) {
        $char = mb_substr($txt, $i, 1);
        if ($isChinese($char) || $isChinesePunctuation($char)) {
            $pdf->SetFont($family, $style, $size);
        } else {
            $pdf->SetFont('Helvetica', $style, $size);
        }
        $pdf->Write(2, $this->toChinese($char));
    }
};

$buf = $pdf->Output('S', __DIR__ . '/files/combine.pdf');
echo $buf;
//file_put_contents(__DIR__ . '/files/combine.pdf', $buf);

