<?php

class TestXDebug
{
    # 第一个参数：default = 2,。0 => 自己吧 1 => 当前类，2 => 父类
    public function basicMethod()
    {
        echo "xdebug_call_class : " . xdebug_call_class(1) . PHP_EOL;

        echo "xdebug_call_function : " . xdebug_call_function(1) . PHP_EOL;

        echo "xdebug_call_file :" . xdebug_call_file(1) . PHP_EOL;

        echo "xdebug_call_line : " . xdebug_call_line(1) . PHP_EOL;
    }

    public function parentMethod(){
        $this->basicMethod();
    }
}

$obj = new TestXDebug();
$obj->parentMethod();
