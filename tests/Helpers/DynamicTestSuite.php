<?php
namespace Apie\Tests\DateValueObjects\Helpers;

use PHPUnit\Framework\TestCase;
use Throwable;

class DynamicTestSuite
{
    /** @var callable  */
    private $testCase;

    private iterable $inputs;

    public function __construct(callable $testCase, iterable $inputs)
    {
        $this->testCase = $testCase;
        $this->inputs = $inputs;
    }

    public function runTestCases(): void
    {
        $failures = [];

        foreach ($this->inputs as $testCase => $input) {
            try {
                $input['testCase'] = (string) $testCase;
                ($this->testCase)(...$input);
            } catch (Throwable $error) {
                $failures[] = $input;
            }
        }

        foreach ($failures as $failure) {
            ($this->testCase)(...$failure);
        }
        TestCase::assertEmpty($failures);
    }
}
