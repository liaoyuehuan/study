<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/11/9 0009
 * Time: 22:09
 */

namespace Uinttest;


use PHPUnit\Framework\Error\Error;
use PHPUnit\Framework\TestCase;

class ExceptionTest extends TestCase
{
    public function testException()
    {
        $this->expectException(\InvalidArgumentException::class);
    }


    /**
     * @expectedException \Exception
     */
    public function testException2()
    {
        throw new \InvalidArgumentException('hello bug');
    }

    /**
     * @expectedException Error
     */
    public function testError()
    {
        include 'not_existing_file.php';
    }

}