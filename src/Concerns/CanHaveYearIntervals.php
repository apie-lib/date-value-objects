<?php
namespace Apie\DateValueObjects\Concerns;

use DateInterval;
use DateTimeImmutable;
use DateTimeInterface;

trait CanHaveYearIntervals
{
    /**
     * @see CanCreateInstanceFromDateTimeObject
     */
    abstract public static function createFromDateTimeObject(DateTimeInterface $dateTime): self;

    /**
     * @see IsDateValueObject
     */
    abstract public function toDate(): DateTimeImmutable;

    public function withYear(int $year): self
    {
        $date = $this->toDate();
        return self::createFromDateTimeObject(
            $date->setDate($year, (int) $date->format('m'), (int) $date->format('d'))
        );
    }

    public function nextYear(): self
    {
        $date = $this->toDate();
        return self::createFromDateTimeObject($date->add(new DateInterval('P1Y')));
    }

    public function previousYear(): self
    {
        $date = $this->toDate();
        return self::createFromDateTimeObject($date->sub(new DateInterval('P1Y')));
    }
}
