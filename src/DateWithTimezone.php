<?php
namespace Apie\DateValueObjects;

use Apie\DateValueObjects\Concerns\CanCreateInstanceFromDateTimeObject;
use Apie\DateValueObjects\Concerns\CanHaveDayIntervals;
use Apie\DateValueObjects\Concerns\CanHaveMonthIntervals;
use Apie\DateValueObjects\Concerns\CanHaveTimeIntervals;
use Apie\DateValueObjects\Concerns\CanHaveTimezone;
use Apie\DateValueObjects\Concerns\CanHaveYearIntervals;
use Apie\DateValueObjects\Concerns\IsDateValueObject;
use Apie\DateValueObjects\Interfaces\WorksWithDays;
use Apie\DateValueObjects\Interfaces\WorksWithMonths;
use Apie\DateValueObjects\Interfaces\WorksWithTimeIntervals;
use Apie\DateValueObjects\Interfaces\WorksWithYears;
use DateTime;

/**
 * Represents a full date + time + timezone. It outputs the date as a string in ATOM format.
 *
 * Example '2005-08-15T15:52:01+00:00'
 */
final class DateWithTimezone implements WorksWithDays, WorksWithMonths, WorksWithYears, WorksWithTimeIntervals
{
    use CanCreateInstanceFromDateTimeObject;
    use CanHaveDayIntervals;
    use CanHaveMonthIntervals;
    use CanHaveTimeIntervals;
    use CanHaveTimezone;
    use CanHaveYearIntervals;
    use IsDateValueObject;

    public static function getDateFormat(): string
    {
        return DateTime::ATOM;
    }

    protected function isStrictFormat(): bool
    {
        return true;
    }
}
