<?php
require_once __DIR__ . '/../vendor/autoload.php';

class TestHello
{
    public function hello()
    {
        return 'a' . 'b';
    }
}
$ok = function (){
    return 'a' . 'b';
};
$reflectionMethod = new ReflectionMethod('TestHello', 'hello');
$serializer = new \SuperClosure\Serializer();
//
$a   = $serializer->serialize($ok);
var_dump($a);

var_dump(new TestHello());

