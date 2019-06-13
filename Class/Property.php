<?php
/**
 * Created by PhpStorm.
 * User: hj
 * Date: 2019-6-10
 * Time: 17:54
 */

class TestProperty
{
    private $config = [
        'hah' => 'xixi',
        1 => '1111',
        2 => '222'
    ];

    public function __get($name)
    {
        return $this->config[$name];
    }

}

$go = 1;
$arr[1] = '2';
$obj = new TestProperty();
var_dump($obj->hah);
var_dump($obj->$go);
var_dump($obj->{$arr[1]});
var_dump("test : {$obj->{$arr[1]}}");
