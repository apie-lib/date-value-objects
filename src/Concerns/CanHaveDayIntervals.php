<?php
namespace Apie\DateValueObjects\Concerns;

use DateInterval;
use DateTimeImmutable;
use DateTimeInterface;

/**
 * Adds method to add day related methods to date value objects.
 */
trait CanHaveDayIntervals
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
     * @see IsDateValueObject
     */
    private int $day;

    /**
     * Creates a new date value object, but with a different day.
     */
    public function withDay(int $day): self
    {
        $date = $this->toDate();
        $object = self::createFromDateTimeObject(
            $date->setDate((int) $date->format('Y'), (int) $date->format('m'), $day)
        );
        $object->day = $day;
        return $object;
    }

    /**
     * Creates a new date value object with the next day.
     */
    public function tomorrow(): self
    {
        $date = $this->toDate();
        return self::createFromDateTimeObject($date->add(new DateInterval('P1D')));
    }

    /**
     * Creates a new date value object with the previous day.
     */
    public function yesterday(): self
    {
        $date = $this->toDate();
        return self::createFromDateTimeObject($date->sub(new DateInterval('P1D')));
    }
}
