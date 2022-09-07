<?php
namespace Apie\Tests\DateValueObjects\Ranges;

use Apie\Core\Exceptions\InvalidTypeException;
use Apie\Core\Exceptions\RangeMismatchException;
use Apie\DateValueObjects\DateWithTimezone;
use Apie\DateValueObjects\Ranges\DateTimeRange;
use Apie\Fixtures\TestHelpers\TestWithFaker;
use Apie\Fixtures\TestHelpers\TestWithOpenapiSchema;
use cebe\openapi\spec\Reference;
use PHPUnit\Framework\TestCase;

class DateTimeRangeTest extends TestCase
{
    use TestWithFaker;
    use TestWithOpenapiSchema;

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
        yield [
            ['start' => '2005-08-15T15:52:01+00:00', 'end' => '2005-08-16T15:52:01+00:00'],
            ['start' => '2005-08-15T15:52:01+00:00', 'end' => '2005-08-16T15:52:01+00:00']
        ];
        yield [
            ['start' => '2005-08-15T15:52:01+00:00', 'end' => '2005-08-15T15:52:01+00:00'],
            ['start' => '2005-08-15T15:52:01+00:00', 'end' => '2005-08-15T15:52:01+00:00']
        ];
        yield [
            ['start' => '2005-08-15T15:52:01+00:00', 'end' => '2005-08-15T16:52:01+01:00'],
            ['start' => '2005-08-15T15:52:01+00:00', 'end' => '2005-08-15T16:52:01+01:00']
        ];
    }

    /**
     * @test

     */
    public function it_refuses_start_after_end()
    {
        $this->expectException(RangeMismatchException::class);
        new DateTimeRange(
            DateWithTimezone::fromNative('2005-08-15T15:52:01+00:00'),
            DateWithTimezone::fromNative('2005-08-13T15:52:01+00:00')
        );
    }

    /**
     * @test
     * @dataProvider invalidProvider
     */
    public function it_refuses_start_after_end_with_fromNative(string $expectedException, array $input)
    {
        $this->expectException($expectedException);
        DateTimeRange::fromNative($input);
    }

    public function invalidProvider()
    {
        yield [
            RangeMismatchException::class,
            ['start' => '2005-08-15T15:52:01+00:00', 'end' => '1984-08-16T15:52:01+00:00'],

        ];
        yield [
            RangeMismatchException::class,
            ['start' => '2005-08-15T15:52:01+00:00', 'end' => '2005-08-15T15:52:01+01:00']
        ];
        yield [
            InvalidTypeException::class,
            ['start' => '2005-08-15T15:52:01+00:00']
        ];
        yield [
            InvalidTypeException::class,
            ['end' => '2005-08-15T15:52:01+00:00']
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
