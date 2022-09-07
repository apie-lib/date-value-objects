<?php
namespace Apie\Tests\DateValueObjects\Concerns;

use Apie\DateValueObjects\Interfaces\WorksWithMonths;
use Apie\Tests\DateValueObjects\Helpers\DynamicTestSuite;

trait TestsMonth
{
    abstract protected function createValueObject(mixed $input): WorksWithMonths;

    abstract protected function monthMethodsProvider(): iterable;

    abstract protected function nextMonthProvider(): iterable;

    abstract protected function previousMonthProvider(): iterable;

    public function testMonthMethods()
    {
        $testCase = function (string $testCase, string $nextMonth, string $previousMonth, string $modified, string $native, mixed $input) {
            $testItem = $this->createValueObject($input);
            $this->assertEquals(
                $nextMonth,
                $testItem->nextMonth()->toNative(),
                'nextMonth() works for input (' . $testCase . ')'
            );
            $this->assertEquals(
                $previousMonth,
                $testItem->previousMonth()->toNative(),
                'previousMonth() works for input (' . $testCase . ')'
            );
            $this->assertEquals(
                $modified,
                $testItem->withMonth(12)->toNative(),
                'withMonth() works for input (' . $testCase . ')'
            );
            $this->assertEquals(
                $native,
                $testItem->toNative(),
                'toNative() works for input (' . $testCase . ')'
            );
        };
        $testSuite = new DynamicTestSuite($testCase, $this->monthMethodsProvider());
        $testSuite->runTestCases();
    }

    /**
     * @test
     */
    public function it_remembers_the_day_when_picking_the_next_month()
    {
        $testCase = function (string $testCase, string $input, string $month1, string $month2, string $month3) {
            $testItem = $this->createValueObject($input);
            $testItem = $testItem->nextMonth();
            $this->assertEquals(
                $month1,
                $testItem->toNative(),
                'month 1 is correct for input (' . $testCase . ')'
            );
            $testItem = $testItem->nextMonth();
            $this->assertEquals(
                $month2,
                $testItem->toNative(),
                'month 2 is correct for input (' . $testCase . ')'
            );
            $testItem = $testItem->nextMonth();
            $this->assertEquals($month3, $testItem->toNative());
            $this->assertEquals(
                $month3,
                $testItem->toNative(),
                'month 3 is correct for input (' . $testCase . ')'
            );
        };
        $testSuite = new DynamicTestSuite($testCase, $this->nextMonthProvider());
        $testSuite->runTestCases();
    }

    
    /**
     * @test
     */
    public function it_remembers_the_day_when_picking_the_previous_month()
    {
        $testCase = function (string $testCase, string $input, string $month1, string $month2, string $month3) {
            $testItem = $this->createValueObject($input);
            $testItem = $testItem->previousMonth();
            $this->assertEquals(
                $month1,
                $testItem->toNative(),
                'month 1 is correct for input (' . $testCase . ')'
            );
            $testItem = $testItem->previousMonth();
            $this->assertEquals(
                $month2,
                $testItem->toNative(),
                'month 2 is correct for input (' . $testCase . ')'
            );
            $testItem = $testItem->previousMonth();
            $this->assertEquals(
                $month3,
                $testItem->toNative(),
                'month 3 is correct for input (' . $testCase . ')'
            );
        };
        $testSuite = new DynamicTestSuite($testCase, $this->previousMonthProvider());
        $testSuite->runTestCases();
    }
}
