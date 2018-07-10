<?php
$func = function () {
    return 'hello';
};
var_dump(is_object($func));

echo date('Ymd', time()) . PHP_EOL;


/**
 *  bind
 */
class A
{
    private $value = 'xixi';
}

$bindFuc = function ($value) {
    var_dump(spl_object_hash($this));
    $this->value = $value;
};

$getFunc = function () {
    var_dump(spl_object_hash($this));
    return $this->value;
};


$obj = new A();
$obj2 =clone $obj;
$obj3 =clone $obj;
$code = spl_object_hash($obj);
$code2 = spl_object_hash($obj2);
$code3 = spl_object_hash($obj3);
var_dump($code,$code2,$code3);
var_dump('$obj === $obj2'.spl_object_hash($obj) == spl_object_hash($obj2));
var_dump('$obj === $obj3'.spl_object_hash($obj) == spl_object_hash($obj3));;


$bindFucObj = Closure::bind($bindFuc, $obj, 'A');
$bindFucObj('haha');

$getFuncObj = Closure::bind($getFunc, $obj, 'A');

var_dump($getFuncObj());
