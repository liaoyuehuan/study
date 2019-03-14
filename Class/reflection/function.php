<?php

namespace Xl;
$a = 1;
$b = 'hi';
$closureUseParams = function () use ($a, &$b) {
    return $a;
};

class MyClass
{

    public function hello()
    {
        echo 'hello'.PHP_EOL;
    }
}

$myClass = new MyClass();
