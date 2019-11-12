<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/11/9 0009
 * Time: 23:02
 */

namespace Uinttest;


use PHPUnit\Framework\TestCase;

class OutputTest extends TestCase
{
    public function testExpectOutput()
    {
        $this->expectOutputString('hello');
        echo 'hello';
    }
}