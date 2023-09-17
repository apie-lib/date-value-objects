<?php
namespace Apie\Tests\DateValueObjects;

use Apie\Core\ValueObjects\Exceptions\InvalidStringForValueObjectException;
use Apie\DateValueObjects\LocalDate;
use Apie\Tests\DateValueObjects\Concerns\TestsDay;
use Apie\Tests\DateValueObjects\Concerns\TestsMonth;
use Apie\Tests\DateValueObjects\Concerns\TestsYear;
use PHPUnit\Framework\TestCase;

class LocalDateTest extends TestCase
{
    use TestsDay;
    use TestsMonth;
    use TestsYear;

    protected function createValueObject(mixed $input): LocalDate
    {
        return LocalDate::fromNative($input);
    }

    protected function dayMethodsProvider(): iterable
    {
        yield [
            'tomorrow' => '2022-01-02',
            'yesterday' => '2021-12-31',
            'modified' => '2022-01-27',
            'native' => '2022-01-01',
            'input' => '2022-01-01',
        ];
    }

    protected function monthMethodsProvider(): iterable
    {
        yield [
            'nextMonth' => '2022-02-01',
            'previousMonth' => '2021-12-01',
            'modified' => '2022-12-01',
            'native' => '2022-01-01',
            'input' => '2022-01-01',
        ];
    }

    protected function previousMonthProvider(): iterable
    {
        yield [
            'input' => '2023-04-30',
            'month1' => '2023-03-30',
            'month2' => '2023-02-28',
            'month3' => '2023-01-30',
        ];
    }

    protected function nextMonthProvider(): iterable
    {
        yield [
            'input' => '2022-12-31',
            'month1' => '2023-01-31',
            'month2' => '2023-02-28',
            'month3' => '2023-03-31',
        ];
    }

    protected function yearMethodsProvider(): iterable
    {
        yield [
            'nextYear' => '2023-01-01',
            'previousYear' => '2021-01-01',
            'modified' => '2011-01-01',
            'native' => '2022-01-01',
            'input' => '2022-01-01',
        ];
    }

    /**
     * @test
     * @dataProvider invalidInput
     */
    public function it_validates_invalid_input(string $input)
    {
        $this->expectException(InvalidStringForValueObjectException::class);
        LocalDate::fromNative($input);
    }

    public function invalidInput()
    {
        yield 'not a date' => ['this is not a date'];
        yield 'missing 0 prefix on month and day' => ['1984-1-1'];
        yield 'invalid day/month combination' => ['1984-01-32'];
    }
}
