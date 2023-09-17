<?php
namespace Apie\Tests\DateValueObjects\Ranges;

use Apie\DateValueObjects\DateWithTimezone;
use Apie\DateValueObjects\Ranges\DateTimeRange;
use Apie\Fixtures\TestHelpers\TestValidationError;
use Apie\Fixtures\TestHelpers\TestWithFaker;
use Apie\Fixtures\TestHelpers\TestWithOpenapiSchema;
use cebe\openapi\spec\Reference;
use PHPUnit\Framework\TestCase;

class DateTimeRangeTest extends TestCase
{
    use TestWithFaker;
    use TestWithOpenapiSchema;
    use TestValidationError;

    /**
     * @test
     * @dataProvider inputProvider
     */
    public function fromNative_allows_valid_arrays(array $expected, array $input)
    {
        $testItem = DateTimeRange::fromNative($input);
        $this->assertEquals($expected, $testItem->toNative());
    }

    /**
     * @test
     * @dataProvider inputProvider
     */
    public function it_allows_all_valid_arrays(array $expected, array $input)
    {
        $testItem = new DateTimeRange(DateWithTimezone::fromNative($input['start']), DateWithTimezone::fromNative($input['end']));
        $this->assertEquals($expected, $testItem->toNative());
    }

    public function inputProvider()
    {
        yield 'day range' => [
            ['start' => '2005-08-15T15:52:01+00:00', 'end' => '2005-08-16T15:52:01+00:00'],
            ['start' => '2005-08-15T15:52:01+00:00', 'end' => '2005-08-16T15:52:01+00:00']
        ];
        yield 'start and date same' => [
            ['start' => '2005-08-15T15:52:01+00:00', 'end' => '2005-08-15T15:52:01+00:00'],
            ['start' => '2005-08-15T15:52:01+00:00', 'end' => '2005-08-15T15:52:01+00:00']
        ];
        yield '1 hour range' => [
            ['start' => '2005-08-15T15:52:01+00:00', 'end' => '2005-08-15T16:52:01+01:00'],
            ['start' => '2005-08-15T15:52:01+00:00', 'end' => '2005-08-15T16:52:01+01:00']
        ];
    }

    /**
     * @test

     */
    public function it_refuses_start_after_end()
    {
        $this->assertValidationError(
            ['start' => '2005-08-15T15:52:01+00:00 is higher than 2005-08-13T15:52:01+00:00'],
            function () {
                new DateTimeRange(
                    DateWithTimezone::fromNative('2005-08-15T15:52:01+00:00'),
                    DateWithTimezone::fromNative('2005-08-13T15:52:01+00:00')
                );
            }
        );
    }

    /**
     * @test
     * @dataProvider invalidProvider
     */
    public function it_refuses_start_after_end_with_fromNative(array $expectedErrorMessages, array $input)
    {
        $this->assertValidationError(
            $expectedErrorMessages,
            function () use ($input) {
                DateTimeRange::fromNative($input);
            }
        );
    }

    public function invalidProvider()
    {
        yield 'start date higher than end date' => [
            ['start' => '2005-08-15T15:52:01+00:00 is higher than 1984-08-16T15:52:01+00:00'],
            ['start' => '2005-08-15T15:52:01+00:00', 'end' => '1984-08-16T15:52:01+00:00'],

        ];
        yield 'start date higher than end date (different timezone)' => [
            ['start' => '2005-08-15T15:52:01+00:00 is higher than 2005-08-15T15:52:01+01:00'],
            ['start' => '2005-08-15T15:52:01+00:00', 'end' => '2005-08-15T15:52:01+01:00']
        ];
        yield 'end is missing' => [
            ['end' => 'Type "(missing value)" is not expected, expected Apie\DateValueObjects\DateWithTimezone'],
            ['start' => '2005-08-15T15:52:01+00:00']
        ];
        yield 'start is missing' => [
            ['start' => 'Type "(missing value)" is not expected, expected Apie\DateValueObjects\DateWithTimezone'],
            ['end' => '2005-08-15T15:52:01+00:00']
        ];
        yield 'invalid start value' => [
            ['start' => 'Value "not a date" is not valid for value object of type: DateWithTimezone'],
            ['start' => 'not a date', 'end' => '2005-08-15T15:52:01+01:00']
        ];
    }

    /**
     * @test
     */
    public function it_works_with_schema_generator()
    {
        $this->runOpenapiSchemaTestForCreation(
            DateTimeRange::class,
            'DateTimeRange-post',
            [
                'type' => 'object',
                'properties' => [
                    'start' => new Reference(['$ref' => '#/components/schemas/DateWithTimezone-post']),
                    'end' => new Reference(['$ref' => '#/components/schemas/DateWithTimezone-post']),
                ],
                'required' => ['start', 'end'],
            ]
        );
    }

    /**
     * @test
     */
    public function it_works_with_apie_faker()
    {
        $this->runFakerTest(DateTimeRange::class);
    }
}
