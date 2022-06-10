<?php
namespace Apie\Tests\DateValueObjects\Concerns;

use Apie\DateValueObjects\Interfaces\WorksWithDays;
use Apie\Tests\DateValueObjects\Helpers\DynamicTestSuite;

trait TestsDay
{
    abstract protected function createValueObject(mixed $input): WorksWithDays;

    abstract protected function dayMethodsProvider(): iterable;

    public function testDayMethods()
    {
        $testCase = function (string $testCase, string $tomorrow, string $yesterday, string $modified, string $native, mixed $input) {
            $testItem = $this->createValueObject($input);
            $this->assertEquals(
                $tomorrow,
                $testItem->tomorrow()->toNative(),
                'tomorrow() works for input (' . $testCase . ')'
            );
            $this->assertEquals(
                $yesterday,
                $testItem->yesterday()->toNative(),
                'yesterday() works for input (' . $testCase . ')'
            );
            $this->assertEquals(
                $modified,
                $testItem->withDay(27)->toNative(),
                'withDay() works for input (' . $testCase . ')'
            );
            $this->assertEquals(
                $native,
                $testItem->toNative(),
                'toNative() works for input (' . $testCase . ')'
            );
        };
        $testSuite = new DynamicTestSuite($testCase, $this->dayMethodsProvider());
        $testSuite->runTestCases();
    }
}
