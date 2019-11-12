<?php

namespace Uinttest;

use PHPUnit\Framework\TestCase;

class HelloTest extends TestCase
{
    public function testSay()
    {
        $this->assertTrue(true);
    }

    public function testFail()
    {
        $this->assertTrue(false);
    }

    /**
     * @test
     */
    public function say()
    {
        $this->assertTrue(true);
        $this->assertTrue(true);
    }
}