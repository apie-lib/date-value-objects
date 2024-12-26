<?php
namespace Apie\Tests\DateValueObjects\Concerns;

use Apie\DateValueObjects\Interfaces\WorksWithTimeIntervals;
use Apie\Tests\DateValueObjects\Helpers\DynamicTestSuite;

trait TestsTime
{
    abstract protected function createValueObject(mixed $input): WorksWithTimeIntervals;

    abstract protected function changeTimeMethodsProvider(): iterable;

    abstract protected function timeMethodsProvider(): iterable;

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_can_change_timestamp()
    {
        $testCase = function (
            string $testCase,
            string $expected,
            string $native,
            mixed $input
        ) {
            $testItem = $this->createValueObject($input);
            $this->assertEquals(
                $expected,
                $testItem->withTime(5, 6, 7, 8)->toNative(),
                'withTime() works for input (' . $testCase . ')'
            );
            $this->assertEquals($native, $testItem->toNative());
        };
        $testSuite = new DynamicTestSuite($testCase, $this->changeTimeMethodsProvider());
        $testSuite->runTestCases();
    }

    public function testTimeMethods()
    {
        $testCase = function (
            string $testCase,
            string $previousSecond,
            string $nextSecond,
            string $previousMinute,
            string $nextMinute,
            string $previousHour,
            string $nextHour,
            string $native,
            mixed $input
        ) {
            $testItem = $this->createValueObject($input);
            $this->assertEquals(
                $nextHour,
                $testItem->nextHour()->toNative(),
                'nextHour() works for input (' . $testCase . ')'
            );
            $this->assertEquals(
                $previousHour,
                $testItem->previousHour()->toNative(),
                'previousHour() works for input (' . $testCase . ')'
            );
            $this->assertEquals(
                $nextMinute,
                $testItem->nextMinute()->toNative(),
                'nextMinute() works for input (' . $testCase . ')'
            );
            $this->assertEquals(
                $previousMinute,
                $testItem->previousMinute()->toNative(),
                'previousMinute() works for input (' . $testCase . ')'
            );
            $this->assertEquals(
                $nextSecond,
                $testItem->nextSecond()->toNative(),
                'nextSecond() works for input (' . $testCase . ')'
            );
            $this->assertEquals(
                $previousSecond,
                $testItem->previousSecond()->toNative(),
                'previousSecond() works for input (' . $testCase . ')'
            );
            $this->assertEquals(
                $native,
                $testItem->toNative(),
                'toNative() works for input (' . $testCase . ')'
            );
        };
        $testSuite = new DynamicTestSuite($testCase, $this->timeMethodsProvider());
        $testSuite->runTestCases();
    }
}
