<?php
namespace Apie\DateValueObjects\Concerns;

use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;

trait CanHaveTimezone
{
    /**
     * @see CanCreateInstanceFromDateTimeObject
     */
    abstract public static function createFromDateTimeObject(DateTimeInterface $dateTime): self;

    /**
     * @see IsDateValueObject
     */
    abstract public function toDate(): DateTimeImmutable;

    public function withTimezone(
        DateTimeZone $timezone
    ): self {
        $date = $this->toDate();
        return self::createFromDateTimeObject(
            $date->setTimezone($timezone)
        );
    }
}
