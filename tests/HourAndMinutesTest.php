<?php
namespace Apie\Tests\DateValueObjects;

use Apie\Core\ValueObjects\Exceptions\InvalidStringForValueObjectException;
use Apie\DateValueObjects\HourAndMinutes;
use Apie\Tests\DateValueObjects\Concerns\TestsTime;
use PHPUnit\Framework\TestCase;

class HourAndMinutesTest extends TestCase
{
    use TestsTime;

    protected function createValueObject(mixed $input): HourAndMinutes
    {
        return HourAndMinutes::fromNative($input);
    }

    protected function timeMethodsProvider(): iterable
    {
        yield 'simple' => [
            'nextSecond' => '10:30',
            'previousSecond' => '10:29',
            'nextMinute' => '10:31',
            'previousMinute' => '10:29',
            'nextHour' => '11:30',
            'previousHour' => '09:30',
            'native' => '10:30',
            'input' => '10:30',
        ];
        yield 'midnight' => [
            'nextSecond' => '00:00',
            'previousSecond' => '23:59',
            'nextMinute' => '00:01',
            'previousMinute' => '23:59',
            'nextHour' => '01:00',
            'previousHour' => '23:00',
            'native' => '00:00',
            'input' => '00:00',
        ];
    }

    protected function changeTimeMethodsProvider(): iterable
    {
        yield [
            'expected' => '05:06',
            'native' => '09:30',
            'input' => '09:30',
        ];
    }

    #[\PHPUnit\Framework\Attributes\DataProvider('invalidInput')]
    #[\PHPUnit\Framework\Attributes\Test]
    public function it_validates_invalid_input(string $input)
    {
        $this->expectException(InvalidStringForValueObjectException::class);
        HourAndMinutes::fromNative($input);
    }

    public static function invalidInput()
    {
        yield 'not a time' => ['this is not a time'];
        yield 'date, no time' => ['1984-1-1'];
        yield 'date + time' => ['1984-01-32 12:23'];
    }
}
