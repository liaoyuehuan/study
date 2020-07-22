<?php
register_shutdown_function(function (){
    var_dump(error_get_last());
});

$files = [
    [
        'word_file' => __DIR__ . '/../files/test-guarantee.doc',
        'des_file' => __DIR__ . '/../files/test-guarantee .pdf'
    ],
    [
        'word_file' => __DIR__ . '/../files/test-guarantee2.doc',
        'des_file' => __DIR__ . '/../files/test-guarantee2 .pdf'
    ],
    [
        'word_file' => __DIR__ . '/../files/test-3.docx',
        'des_file' => __DIR__ . '/../files/test-3.pdf'
    ],
    [
        'word_file' => __DIR__ . '/../files/test-3.tmp',
        'des_file' => __DIR__ . '/../files/test-3-tmp.pdf'
    ],
];


function wordToPdf($wordFile, $desFile)
{
    static $comWord = null;
    $start = floor(microtime(true) * 1000);
    echo '1、initialise com' . PHP_EOL;
    if ($comWord === null) {
        $comWord = new COM('word.Application');
    }
    if (empty($comWord)) {
        die('Could not initialise Object');
    }
    $end = floor(microtime(true) * 1000);
    echo ($end - $start) . 'ms' . PHP_EOL;

    echo '2、open file' . PHP_EOL;
    $comWord->Visible = false;
    $comWord->Documents->open($wordFile);

    $end = floor(microtime(true) * 1000);
    echo ($end - $start) . 'ms' . PHP_EOL;

    echo '3、output pdf' . PHP_EOL;
    $comWord->ActiveDocument->ExportAsFixedFormat($desFile, 17, false, 0, 0, 0, 0, 7, true, true, 2, true, true, false);
    $end = floor(microtime(true) * 1000);
    echo ($end - $start) . 'ms' . PHP_EOL;
    $comWord->ActiveDocument->Close(false);
    echo '4、quit' . PHP_EOL;
//    $comWord->Quit(false);
//    $comWord->Close();
//    unset($comWord);
    $end = floor(microtime(true) * 1000);
    echo ($end - $start) . 'ms' . PHP_EOL;
    echo 'success' . PHP_EOL;
}

try {
    foreach ($files as $file) {
        wordToPdf($file['word_file'], $file['des_file']);
        echo '########################' . PHP_EOL . PHP_EOL;
    }
}catch (Exception $e) {
    echo "################ excption ################".PHP_EOL;
    echo  $e->getTraceAsString();
}

