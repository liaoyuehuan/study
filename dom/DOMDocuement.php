<?php

function test1()
{
    $domDocument = new DOMDocument('1.0','UTF-8');
    $html = '<html><body>Test<br></body></html>';
    $domDocument->loadHTML($html);
    echo $domDocument->saveHTML();
}

test1();