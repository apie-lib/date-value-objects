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
 * 01:00:23, 23:00:23
 *
 * Hours, minutes and seconds lower than 10 will be prefixed with 0.
 */
final class Time implements WorksWithTimeIntervals
{
    use CanCreateInstanceFromDateTimeObject;
    use CanHaveTimeIntervals;
    use IsDateValueObject;

    public static function getDateFormat(): string
    {
        return 'H:i:s';
    }

    protected function isStrictFormat(): bool
    {
        return true;
    }
}
