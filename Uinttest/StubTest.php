<?php
/**
 * Created by PhpStorm.
 * User: hj
 * Date: 2019-11-14
 * Time: 14:34
 */

namespace Uinttest;


use PHPUnit\Framework\TestCase;
use Uinttest\StubClass\Observer;
use Uinttest\StubClass\SomeThing;
use Uinttest\StubClass\Subject;

class StubTest extends TestCase
{
    public function testStub()
    {
        /**
         * @var SomeThing $stub
         */
        $stub = $this->createMock(SomeThing::class);
        $stub->method('doSomething')->willReturn('ok');
        $this->assertEquals('ok', $stub->doSomething());
    }

    public function testStubWithArgs()
    {


        $stub = $this->createMock(SomeThing::class);
        $stub->method('doSomething')->will($this->returnArgument(0));
        /**
         * @var SomeThing $stub
         */
        $this->assertEquals("ok1", $stub->doSomething("ok1"));
        $this->assertEquals("ok2", $stub->doSomething("ok2"));

    }

    public function testMockBuilder()
    {
        $stub = $this->getMockBuilder(SomeThing::class)
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->getMock();

        $stub->method("doSomething")
            ->willReturn("ha");

        /**
         * @var SomeThing $stub
         */
        $this->assertEquals("ha", $stub->doSomething());

    }

    public function testReturnSelf()
    {
        $stub = $this->createMock(SomeThing::class);
        $stub->method('doSomething')->will($this->returnSelf());
        /**
         * @var SomeThing $stub
         */
        $this->assertSame($stub, $stub->doSomething());
    }

    public function testReturnCallback()
    {
        $stub = $this->createMock(SomeThing::class);
        $stub->method('doSomething')->will($this->returnCallback(function ($value) {
            return strlen($value);
        }));
        /**
         * @var SomeThing $stub
         */
        $this->assertEquals(strlen("hi"), $stub->doSomething('hi'));
    }

    public function testOnConsecutiveCalls()
    {
        $stub = $this->createMock(SomeThing::class);
        $stub->method('doSomething')->will(
            $this->onConsecutiveCalls(1, 2, 3, 4, 5)
        );
        /**
         * @var SomeThing $stub
         */
        $this->assertEquals(1, $stub->doSomething());
        $this->assertEquals(2, $stub->doSomething());
        $this->assertEquals(3, $stub->doSomething());
    }

//    public function testThrowException()
//    {
//        $stub = $this->createMock(SomeThing::class);
//        $stub->method('doSomething')->will(
//            $this->throwException(new \Exception('test throw exception'))
//        );
//        /**
//         * @var SomeThing $stub
//         */
//        $stub->doSomething();
//    }


    public function testObserver()
    {
        $stub = $this->getMockBuilder(Observer::class)->getMock();
        $stub->expects($this->once())
            ->method('update')
            ->with($this->equalTo('xl'));

        $subject = new Subject();
        /**
         * @var $stub Observer
         */
        $subject->attach($stub);
        $subject->doSomething('xl');
    }


    public function testObserverReport()
    {
        $stub = $this->getMockBuilder(Observer::class)->getMock();
        $stub->expects($this->once())
            ->method('report')
            ->with(
                $this->greaterThan(0),
                $this->stringContains('err'),
                $this->stringContains('extra')
            );
        $subject = new Subject();
        /**
         * @var $stub Observer
         */
        $subject->attach($stub);
        $subject->doReport();

    }


}