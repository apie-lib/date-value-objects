<?php
namespace Apie\DateValueObjects\Concerns;

use DateInterval;
use DateTimeImmutable;
use DateTimeInterface;

/**
 * Adds method to add time related methods to date value objects.
 */
trait CanHaveTimeIntervals
{
    /**
     * @see CanCreateInstanceFromDateTimeObject
     */
    abstract public static function createFromDateTimeObject(DateTimeInterface $dateTime): self;

    /**
     * @see IsDateValueObject
     */
    abstract public function toDate(): DateTimeImmutable;

    /**
     * Creates a new date value object, but with a different time.
     */
    public function withTime(
        ?int $hour = null,
        ?int $minute = null,
        ?int $second = null,
        ?int $micro = null
    ): self {
        $date = $this->toDate();
        return self::createFromDateTimeObject(
            $date->setTime(
                $hour ?? $date->format('H'),
                $minute ?? $date->format('i'),
                $second ?? $date->format('s'),
                $micro ?? $date->format('u')
            )
        );
    }

    /**
     * Creates a new date value object, but with a hour later.
     */
    public function nextHour(): self
    {
        $date = $this->toDate();
        return self::createFromDateTimeObject($date->add(new DateInterval('PT1H')));
    }

    /**
     * Creates a new date value object, but with a hour earlier.
     */
    public function previousHour(): self
    {
        $date = $this->toDate();
        return self::createFromDateTimeObject($date->sub(new DateInterval('PT1H')));
    }

    /**
     * Creates a new date value object, but with a minute later.
     */
    public function nextMinute(): self
    {
        $date = $this->toDate();
        return self::createFromDateTimeObject($date->add(new DateInterval('PT1M')));
    }

    /**
     * Creates a new date value object, but with a minute earlier.
     */
    public function previousMinute(): self
    {
        $date = $this->toDate();
        return self::createFromDateTimeObject($date->sub(new DateInterval('PT1M')));
    }

    /**
     * Creates a new date value object, but with a second later.
     */
    public function nextSecond(): self
    {
        $date = $this->toDate();
        return self::createFromDateTimeObject($date->add(new DateInterval('PT1S')));
    }

    /**
     * Creates a new date value object, but with a second earlier.
     */
    public function previousSecond(): self
    {
        $date = $this->toDate();
        return self::createFromDateTimeObject($date->sub(new DateInterval('PT1S')));
    }
}
