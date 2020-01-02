<?php
/**
 * Created by PhpStorm.
 * User: hj
 * Date: 2019-11-14
 * Time: 10:07
 */

namespace Uinttest;


use PHPUnit\Framework\TestCase;

class IncompleteTest extends TestCase
{
    public function testIncomplete()
    {
        $this->assertTrue(true);
        $this->markTestIncomplete("incomplete");
    }

    /**
     * @requires PHP 7.3.5
     * @requires extension swoole
     * @requires OS linux
     * @requires function fopen
     *
     */
    public function testSkip(){
        $this->assertTrue(true);
    }
}