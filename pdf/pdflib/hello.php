<?php
try {
    $p = PDF_new();
    $filename = __DIR__ . '/files/hello.pdf';
    $filename = '';
    $optionList = '';
    if (PDF_begin_document($p, $filename, $optionList) == 0) {
        die("Error: " . PDF_get_errmsg($p));
    }

    PDF_set_info($p, 'Creator', 'php');
    PDF_set_info($p, 'Author', 'liaoyuehuan');
    PDF_set_info($p, 'Title', 'hello PDF');

    PDF_begin_page_ext($p, 595, 842, '');
    $font = PDF_load_font($p, "Helvetica-Bold", "winansi", "");
    PDF_setfont($p, $font, 24);
    PDF_set_text_pos($p, 100, 600);
    PDF_show($p, 'hi pdf girl');
    PDF_continue_text($p, 'continue');
    PDF_end_page_ext($p, '');

    PDF_end_document($p, '');
    if ($filename) {
        echo 'success';
    } else {
        $buf = PDF_get_buffer($p); // $filename empty
//        var_dump($buf);
        $last = 0;
        for ($i = 1; $i < strlen($buf); $i++) {
            if ($buf{$i} === 'w') {
                echo $i . ' : ' . ($i - $last) . ' : ' . $buf{$i} . PHP_EOL;
                $last = $i;
            }
        }
    }
    PDF_delete($p);
} catch (PDFLibException $e) {
    var_dump($e);
} catch (Exception $e) {
    var_dump($e);
}