<?php
$hello = function (){
    echo 'hello'.PHP_EOL;
};

class Ha {
    public $ok = 'ok';

    public function o(){
        echo 'o'.PHP_EOL;
    }
}

echo $se = serialize(new Ha()).PHP_EOL;

$use = unserialize($se);
var_dump($use);