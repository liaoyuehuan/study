<?php

function testObStart()
{
    ob_start();
    echo 'hello world' . PHP_EOL;
    $handlers = ob_list_handlers();
    ob_end_flush();
    var_dump($handlers);

    ob_start('ob_gzhandler');
    echo 'hello world' . PHP_EOL;
    $handlers = ob_list_handlers();
    ob_end_flush();
    var_dump($handlers);

    ob_start(function ($buffer) {
        return "<span>{$buffer}</span>";
    });
    echo 'hello world' . PHP_EOL;
    $handlers = ob_list_handlers();
//var_dump($handlers);
    ob_end_flush();
    var_dump($handlers);
}

function testObImplicitFlush()
{
    echo ob_get_level() . PHP_EOL;
    ob_start();
    ob_implicit_flush(true);
    for ($i = 0; $i < 10; $i++) {
        echo $i . PHP_EOL;
        ob_flush(); // ob_implicit_flush： true 立即输出
        sleep(1);
    }
    ob_end_flush();
}

testObImplicitFlush();



