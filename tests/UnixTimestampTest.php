<?php
namespace Apie\Tests\DateValueObjects;

use Apie\Core\ValueObjects\Exceptions\InvalidStringForValueObjectException;
use Apie\DateValueObjects\UnixTimestamp;
use Apie\Tests\DateValueObjects\Concerns\TestsDay;
use Apie\Tests\DateValueObjects\Concerns\TestsMonth;
use Apie\Tests\DateValueObjects\Concerns\TestsTime;
use Apie\Tests\DateValueObjects\Concerns\TestsYear;
use DateTime;
use PHPUnit\Framework\TestCase;

class UnixTimestampTest extends TestCase
{
    use TestsDay;
    use TestsMonth;
    use TestsYear;
    use TestsTime;

    protected function createValueObject(mixed $input): UnixTimestamp
    {
        return UnixTimestamp::fromNative($input);
    }

    private function toTimestamp(string $input): int
    {
        return DateTime::createFromFormat(DateTime::ATOM, $input)->getTimestamp();
    }

    protected function dayMethodsProvider(): iterable
    {
        yield [
            'tomorrow' => $this->toTimestamp('2005-08-16T15:52:01+00:00'),
            'yesterday' => $this->toTimestamp('2005-08-14T15:52:01+00:00'),
            'modified' => $this->toTimestamp('2005-08-27T15:52:01+00:00'),
            'native' => $this->toTimestamp('2005-08-15T15:52:01+00:00'),
            'input' => $this->toTimestamp('2005-08-15T15:52:01+00:00'),
        ];
    }

    protected function monthMethodsProvider(): iterable
    {
        yield [
            'nextMonth' => $this->toTimestamp('2005-09-15T15:52:01+00:00'),
            'previousMonth' => $this->toTimestamp('2005-07-15T15:52:01+00:00'),
            'modified' => $this->toTimestamp('2005-12-15T15:52:01+00:00'),
            'native' => $this->toTimestamp('2005-08-15T15:52:01+00:00'),
            'input' => $this->toTimestamp('2005-08-15T15:52:01+00:00'),
        ];
    }

    protected function yearMethodsProvider(): iterable
    {
        yield [
            'nextYear' => $this->toTimestamp('2006-08-15T15:52:01+00:00'),
            'previousYear' => $this->toTimestamp('2004-08-15T15:52:01+00:00'),
            'modified' => $this->toTimestamp('2011-08-15T15:52:01+00:00'),
            'native' => $this->toTimestamp('2005-08-15T15:52:01+00:00'),
            'input' => $this->toTimestamp('2005-08-15T15:52:01+00:00'),
        ];
    }

    protected function previousMonthProvider(): iterable
    {
        yield [
            'input' => $this->toTimestamp('2005-08-15T15:52:01+00:00'),
            'month1' => $this->toTimestamp('2005-07-15T15:52:01+00:00'),
            'month2' => $this->toTimestamp('2005-06-15T15:52:01+00:00'),
            'month3' => $this->toTimestamp('2005-05-15T15:52:01+00:00'),
        ];
    }

    protected function nextMonthProvider(): iterable
    {
        yield [
            'input' => $this->toTimestamp('2005-08-15T15:52:01+00:00'),
            'month1' => $this->toTimestamp('2005-09-15T15:52:01+00:00'),
            'month2' => $this->toTimestamp('2005-10-15T15:52:01+00:00'),
            'month3' => $this->toTimestamp('2005-11-15T15:52:01+00:00'),
        ];
    }

    protected function timeMethodsProvider(): iterable
    {
        yield [
            'nextSecond' => $this->toTimestamp('2005-08-15T15:52:02+00:00'),
            'previousSecond' => $this->toTimestamp('2005-08-15T15:52:00+00:00'),
            'nextMinute' => $this->toTimestamp('2005-08-15T15:53:01+00:00'),
            'previousMinute' => $this->toTimestamp('2005-08-15T15:51:01+00:00'),
            'nextHour' => $this->toTimestamp('2005-08-15T16:52:01+00:00'),
            'previousHour' => $this->toTimestamp('2005-08-15T14:52:01+00:00'),
            'native' => $this->toTimestamp('2005-08-15T15:52:01+00:00'),
            'input' => $this->toTimestamp('2005-08-15T15:52:01+00:00'),
        ];
    }

    protected function changeTimeMethodsProvider(): iterable
    {
        yield [
            'expected' => $this->toTimestamp('2005-08-15T05:06:07+00:00'),
            'native' => $this->toTimestamp('2005-08-15T15:52:01+00:00'),
            'input' => $this->toTimestamp('2005-08-15T15:52:01+00:00'),
        ];
    }

    #[\PHPUnit\Framework\Attributes\DataProvider('invalidInput')]
    #[\PHPUnit\Framework\Attributes\Test]
    public function it_validates_invalid_input(string $input)
    {
        $this->expectException(InvalidStringForValueObjectException::class);
        UnixTimestamp::fromNative($input);
    }

    public static function invalidInput()
    {
        yield 'not a timestamp' => ['this is not a date'];
        yield 'date without 0 prefix' => ['1984-1-1'];
        yield 'date with invalid date' => ['1984-01-32'];
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_can_create_UnixTimestamp_from_current_time()
    {
        $testItem = UnixTimestamp::createFromCurrentTime();
        $this->assertMatchesRegularExpression('/^[1-9][0-9]+$/', $testItem->toNative());
    }
}
