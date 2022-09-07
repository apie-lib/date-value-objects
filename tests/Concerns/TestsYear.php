<?php
namespace Apie\Tests\DateValueObjects\Concerns;

use Apie\DateValueObjects\Interfaces\WorksWithYears;
use Apie\Tests\DateValueObjects\Helpers\DynamicTestSuite;

trait TestsYear
{
    abstract protected function createValueObject(mixed $input): WorksWithYears;

    abstract protected function yearMethodsProvider(): iterable;

    public function testYearMethods()
    {
        $testCase = function (string $testCase, string $nextYear, string $previousYear, string $modified, string $native, mixed $input) {
            $testItem = $this->createValueObject($input);
            $this->assertEquals(
                $nextYear,
                $testItem->nextYear()->toNative(),
                'tomorrow() works for input (' . $testCase . ')'
            );
            $this->assertEquals(
                $previousYear,
                $testItem->previousYear()->toNative(),
                'yesterday() works for input (' . $testCase . ')'
            );
            $this->assertEquals(
                $modified,
                $testItem->withYear(2011)->toNative(),
                'withDay() works for input (' . $testCase . ')'
            );
            $this->assertEquals(
                $native,
                $testItem->toNative(),
                'toNative() works for input (' . $testCase . ')'
            );
        };
        $testSuite = new DynamicTestSuite($testCase, $this->yearMethodsProvider());
        $testSuite->runTestCases();
    }
}
