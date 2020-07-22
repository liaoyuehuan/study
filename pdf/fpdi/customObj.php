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
$xmlHe = bin2hex('<DZBH><DZBHSM3>12345678901234567890</DZBHSM3><DZBHINFO><ORDER_ID>123123123123</ORDER_ID><GUARANTEE_NO>FJ1231231231232</GUARANTEE_NO><TENDERINFO
			APPROVAL_CODE="123123123"
			TENDER_PROJECT_CODE="123123123"
		></TENDERINFO><GUARANTOR
			GUARANTOR_NAME ="123123123"
			GUARANTOR_CREDIT_CODE ="123123123"
		></GUARANTOR><BIDDER
			BIDDER_NAME ="123123123"
			BIDDER_CREDIT_CODE ="123123123"></BIDDER><ORDER_ATTACHMENT
			ORDER_URL ="123123123"
			ORDER_MD5 ="123123123"></ORDER_ATTACHMENT><GUARANTEE_INFO
			SERVICE_BEGIN_TIME ="123123123"
			SERVICE_END_TIME ="123123123"></GUARANTEE_INFO ><BENEFICIARY_INFO
			BENEFICIARY ="123123123"
			BENEFICIARY_CREDIT_CODE ="123123123"></BENEFICIARY_INFO><GUARANTEE_ATTACHMENT
			GUARANTEE_URL ="123123123"
			GUARANTEE_FILE_NAME ="123123123"></GUARANTEE_ATTACHMENT><INVOICE_INFO
			INVOICE_TITLE ="123123123"
			INVOICE_NO ="123123123"></INVOICE_INFO></DZBHINFO></DZBH>');
$pdf->setCustomData("__guarantee_data__[{$xmlHe}]__guarantee_data__");
$buf = $pdf->Output('S');
echo $buf;

preg_match('/hello/',$buf,$match);
var_dump($match);
