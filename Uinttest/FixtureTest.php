<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/11/12 0012
 * Time: 22:12
 */

namespace Uinttest;


use PHPUnit\Framework\TestCase;
use Throwable;

class FixtureTest extends TestCase
{

//    protected $backupGlobals = ['name'];

    protected $backupGlobalsBlacklist = ['go'];

    protected $backupStaticAttributes = [
        FixtureTest::class => ['name']
    ];

    private static $name = 'liao';

    private $stack = [];

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
    }

    public static function setUpBeforeClass()
    {
    }

    public static function tearDownAfterClass()
    {

    }

    public function setUp()
    {
        $this->stack = ['ok'];
    }

    public function tearDown()
    {

    }

    public function onNotSuccessfulTest(Throwable $t)
    {

    }

    public function testStack()
    {
        $stack = $this->stack;
        $this->assertNotEmpty($stack);
        return $stack;
    }

    /**
     * @depends testStack
     * @param array $stack
     * @return array
     */
    public function testPop(array $stack)
    {
        array_pop($stack);
        $this->assertEmpty($stack);
        return $stack;
    }

    /**
     * @depends testPop
     * @param array $stack
     */
    public function testPush(array $stack)
    {
        array_push($stack, 'xi');
        $this->assertNotEmpty($stack);
    }

}