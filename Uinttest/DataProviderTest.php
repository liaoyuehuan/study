<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/11/9 0009
 * Time: 9:19
 */

namespace Uinttest;


use PHPUnit\Framework\TestCase;

class DataProviderTest extends TestCase
{
    /**
     * @dataProvider mulProvider
     * @param $a
     * @param $b
     * @param $expected
     */
    public function testMul($a, $b, $expected)
    {
        $this->assertEquals($expected, $a * $b);
    }

    public function mulProvider()
    {
        return [
            [1, 2, 2],
            [2, 3, 6],
            [5, 6, 31]
        ];
    }

    public function testFirst()
    {
        $this->assertTrue(true);
        return 'first';
    }

    public function testSecond()
    {
        $this->assertTrue(true);
        return 'second';
    }

    public function provider()
    {
        return [['provider1'], ['provider2']];
    }

    /**
     * @dataProvider provider
     * @depends      testFirst
     * @depends      testSecond
     */
    public function testThird($provider, $first, $second)
    {
        $this->assertEquals(['provider1', 'first', 'second'], [$provider, $first, $second]);
    }
}