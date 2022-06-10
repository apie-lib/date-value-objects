<?php
namespace Apie\DateValueObjects;

use Apie\DateValueObjects\Concerns\CanCreateInstanceFromDateTimeObject;
use Apie\DateValueObjects\Concerns\CanHaveDayIntervals;
use Apie\DateValueObjects\Concerns\CanHaveMonthIntervals;
use Apie\DateValueObjects\Concerns\CanHaveYearIntervals;
use Apie\DateValueObjects\Concerns\IsDateValueObject;
use Apie\DateValueObjects\Interfaces\WorksWithDays;
use Apie\DateValueObjects\Interfaces\WorksWithMonths;
use Apie\DateValueObjects\Interfaces\WorksWithYears;

/**
 * Represents a date only.
 *
 * For example "2022-12-25" is 25 december 2022.
 *
 * One notice is that months and day lower than 0 need to be prefixed with '0' just as
 * what an <input type="date"> would send.'
 *
 * For example: '2012-28-01" for 28 january 2012 and not '2012-28-1'
 */
final class LocalDate implements WorksWithDays, WorksWithMonths, WorksWithYears
{
    use CanCreateInstanceFromDateTimeObject;
    use CanHaveDayIntervals;
    use CanHaveMonthIntervals;
    use CanHaveYearIntervals;
    use IsDateValueObject;

    public static function getDateFormat(): string
    {
        return 'Y-m-d';
    }

    protected function isStrictFormat(): bool
    {
        return true;
    }
}
