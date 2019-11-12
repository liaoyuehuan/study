<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/11/9 0009
 * Time: 9:06
 */

namespace Uinttest;


use PHPUnit\Framework\TestCase;

class DependsTest extends TestCase
{
    public function testEmpty()
    {
        $data = [];
        $this->assertEmpty($data);
        return $data;
    }

    /**
     * @depends testEmpty
     */
    public function testPush(array $data)
    {
        array_push($data, ['first']);
        $this->assertNotEmpty($data);
        return $data;
    }

    /**
     * @depends testPush
     */
    public function testPop(array $data)
    {
        array_pop($data);
        $this->assertEmpty($data);
    }

    public function testOne()
    {
        $this->assertTrue(true);
        return 'one';
    }

    public function testTwo()
    {
        $this->assertTrue(true);
        return 'two';
    }

    /**
     * @depends  testOne
     * @depends  testTwo
     */
    public function testThree($one, $two)
    {
        $this->assertEquals(['one', 'two'], [$one, $two]);
    }

}