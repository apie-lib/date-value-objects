<?php
namespace Apie\Tests\DateValueObjects;

use Apie\Core\ValueObjects\Exceptions\InvalidStringForValueObjectException;
use Apie\DateValueObjects\DateWithTimezone;
use Apie\Tests\DateValueObjects\Concerns\TestsDay;
use Apie\Tests\DateValueObjects\Concerns\TestsMonth;
use Apie\Tests\DateValueObjects\Concerns\TestsTime;
use Apie\Tests\DateValueObjects\Concerns\TestsYear;
use PHPUnit\Framework\TestCase;

class DateWithTimezoneTest extends TestCase
{
    use TestsDay;
    use TestsMonth;
    use TestsYear;
    use TestsTime;

    protected function createValueObject(mixed $input): DateWithTimezone
    {
        return DateWithTimezone::fromNative($input);
    }

    protected function dayMethodsProvider(): iterable
    {
        yield [
            'tomorrow' => '2005-08-16T15:52:01+00:00',
            'yesterday' => '2005-08-14T15:52:01+00:00',
            'modified' => '2005-08-27T15:52:01+00:00',
            'native' => '2005-08-15T15:52:01+00:00',
            'input' => '2005-08-15T15:52:01+00:00',
        ];
    }

    protected function monthMethodsProvider(): iterable
    {
        yield [
            'nextMonth' => '2005-09-15T15:52:01+00:00',
            'previousMonth' => '2005-07-15T15:52:01+00:00',
            'modified' => '2005-12-15T15:52:01+00:00',
            'native' => '2005-08-15T15:52:01+00:00',
            'input' => '2005-08-15T15:52:01+00:00',
        ];
    }

    protected function yearMethodsProvider(): iterable
    {
        yield [
            'nextYear' => '2006-08-15T15:52:01+00:00',
            'previousYear' => '2004-08-15T15:52:01+00:00',
            'modified' => '2011-08-15T15:52:01+00:00',
            'native' => '2005-08-15T15:52:01+00:00',
            'input' => '2005-08-15T15:52:01+00:00',
        ];
    }

    protected function previousMonthProvider(): iterable
    {
        yield [
            'input' => '2005-08-15T15:52:01+00:00',
            'month1' => '2005-07-15T15:52:01+00:00',
            'month2' => '2005-06-15T15:52:01+00:00',
            'month3' => '2005-05-15T15:52:01+00:00',
        ];
    }

    protected function nextMonthProvider(): iterable
    {
        yield [
            'input' => '2005-08-15T15:52:01+00:00',
            'month1' => '2005-09-15T15:52:01+00:00',
            'month2' => '2005-10-15T15:52:01+00:00',
            'month3' => '2005-11-15T15:52:01+00:00',
        ];
    }

    protected function timeMethodsProvider(): iterable
    {
        yield [
            'nextSecond' => '2005-08-15T15:52:02+00:00',
            'previousSecond' => '2005-08-15T15:52:00+00:00',
            'nextMinute' => '2005-08-15T15:53:01+00:00',
            'previousMinute' => '2005-08-15T15:51:01+00:00',
            'nextHour' => '2005-08-15T16:52:01+00:00',
            'previousHour' => '2005-08-15T14:52:01+00:00',
            'native' => '2005-08-15T15:52:01+00:00',
            'input' => '2005-08-15T15:52:01+00:00',
        ];
    }

    protected function changeTimeMethodsProvider(): iterable
    {
        yield [
            'expected' => '2005-08-15T05:06:07+00:00',
            'native' => '2005-08-15T15:52:01+00:00',
            'input' => '2005-08-15T15:52:01+00:00',
        ];
    }

    #[\PHPUnit\Framework\Attributes\DataProvider('invalidInput')]
    #[\PHPUnit\Framework\Attributes\Test]
    public function it_validates_invalid_input(string $input)
    {
        $this->expectException(InvalidStringForValueObjectException::class);
        DateWithTimezone::fromNative($input);
    }

    public static function invalidInput()
    {
        yield 'not a date' => ['this is not a date'];
        yield 'missing prefix 0 on month' => ['2005-8-15T15:52:01+00:00'];
        yield 'invalid date/month combination' => ['1984-01-32T15:52:01+00:00'];
    }
}
