<?php
namespace Apie\DateValueObjects;

use Apie\DateValueObjects\Concerns\CanCreateInstanceFromDateTimeObject;
use Apie\DateValueObjects\Concerns\CanHaveTimeIntervals;
use Apie\DateValueObjects\Concerns\IsDateValueObject;
use Apie\DateValueObjects\Interfaces\WorksWithTimeIntervals;

/**
 * Represents a time only in a 24h format accurate to
 * the second.
 *
 * For example:
 * 01:00, 23:00
 *
 * Hours lower than 10 will be prefixed with 0.
 */
final class HourAndMinutes implements WorksWithTimeIntervals
{
    use CanCreateInstanceFromDateTimeObject;
    use CanHaveTimeIntervals;
    use IsDateValueObject;

    public static function getDateFormat(): string
    {
        return 'H:i';
    }

    protected function isStrictFormat(): bool
    {
        return false;
    }
}
