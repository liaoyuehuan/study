<?php
try {
    $pdfLib = new PDFLib();
    $filename = __DIR__.'/files/content.pdf';
    $optList = '';
    if ($pdfLib->begin_document($filename, $optList) == 0) {
        die($pdfLib->get_errmsg());
    }
    $pdfLib->set_info('Creator', 'php');
    $pdfLib->set_info('Author', 'iaoyuehuan');
    $pdfLib->set_info('Title', 'Combine');

    $pdfLib->begin_page_ext(595, 842, '');
    $document = $pdfLib->open_pdi_document(__DIR__ . '/files/conent.pdf','');
    $page = $pdfLib->open_pdi_page($document,1,'');
    $pdfLib->fit_pdi_page($page,595,842,'');
    $pdfLib->end_page_ext('');
    $pdfLib->end_document('');
    if ($filename) {
        echo 'success'.PHP_EOL;
    } else {
        var_dump($pdfLib->get_buffer());
    }
} catch (PDFLibException $e) {
    var_dump($e);
}