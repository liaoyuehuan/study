<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/11/12 0012
 * Time: 23:03
 */

namespace Uinttest;


use PHPUnit\Framework\TestCase;

class RiskTest extends TestCase
{
    public function testEmptyAssert()
    {

    }

    public function testOutput()
    {
        echo 'aa';
        $this->assertTrue(true);
    }

    /**
     * @small
     */
    public function testOverTime()
    {
        sleep(2);
        $this->assertTrue(true);
    }
}