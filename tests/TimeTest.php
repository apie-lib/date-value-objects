<?php
namespace Apie\Tests\DateValueObjects;

use Apie\Core\ValueObjects\Exceptions\InvalidStringForValueObjectException;
use Apie\DateValueObjects\Time;
use Apie\Tests\DateValueObjects\Concerns\TestsTime;
use PHPUnit\Framework\TestCase;

class TimeTest extends TestCase
{
    use TestsTime;

    protected function createValueObject(mixed $input): Time
    {
        return Time::fromNative($input);
    }

    protected function timeMethodsProvider(): iterable
    {
        yield 'simple' => [
            'nextSecond' => '10:30:01',
            'previousSecond' => '10:29:59',
            'nextMinute' => '10:31:00',
            'previousMinute' => '10:29:00',
            'nextHour' => '11:30:00',
            'previousHour' => '09:30:00',
            'native' => '10:30:00',
            'input' => '10:30:00',
        ];
        yield 'midnight' => [
            'nextSecond' => '00:00:01',
            'previousSecond' => '23:59:59',
            'nextMinute' => '00:01:00',
            'previousMinute' => '23:59:00',
            'nextHour' => '01:00:00',
            'previousHour' => '23:00:00',
            'native' => '00:00:00',
            'input' => '00:00:00',
        ];
    }

    protected function changeTimeMethodsProvider(): iterable
    {
        yield [
            'expected' => '05:06:07',
            'native' => '09:30:29',
            'input' => '09:30:29',
        ];
    }

    #[\PHPUnit\Framework\Attributes\DataProvider('invalidInput')]
    #[\PHPUnit\Framework\Attributes\Test]
    public function it_validates_invalid_input(string $input)
    {
        $this->expectException(InvalidStringForValueObjectException::class);
        Time::fromNative($input);
    }

    public static function invalidInput()
    {
        yield 'not a time' => ['this is not a time'];
        yield 'date, no time' => ['1984-1-1'];
        yield 'incorrect hours' => ['25:12:01'];
        yield 'date + time' => ['1984-01-32 12:23'];
    }
}
