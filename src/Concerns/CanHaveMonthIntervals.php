<?php
namespace Apie\DateValueObjects\Concerns;

use DateTimeImmutable;
use DateTimeInterface;

/**
 * Adds method to add month related methods to date value objects.
 */
trait CanHaveMonthIntervals
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
     * Creates a new date value object, but with a different month value.
     * If the day does not exist in this month, it will switch to the last day in that month.
     */
    public function withMonth(int $month): self
    {
        $date = $this->toDate();
        $object = self::createFromDateTimeObject(
            $date->setDate((int) $date->format('Y'), $month, $this->day)
        );
        $object->day = $this->day;
        return $object;
    }

    /**
     * Creates a new date value object, but with the next month.
     * If the day does not exist in this month, it will switch to the last day in that month.
     */
    public function nextMonth(): self
    {
        $currentDate = $this->toDate();
        $currentMonth = (int) $currentDate->format('m');
        $nextDate = $currentDate->setDate((int) $currentDate->format('Y'), $currentMonth + 1, $this->day);
        $nextMonth = (int) $nextDate->format('m');
        $expectedMonth = $currentMonth === 12 ? 1 : ($currentMonth + 1);
        // this means the current month has more days than the next month
        if ($nextMonth !==$expectedMonth) {
            $nextDate = $currentDate->setDate((int) $currentDate->format('Y'), $currentMonth + 2, 0);
        }

        $object = self::createFromDateTimeObject($nextDate);
        $object->day = $this->day;
        return $object;
    }

    /**
     * Creates a new date value object, but with the previous month.
     * If the day does not exist in this month, it will switch to the last day in that month.
     */
    public function previousMonth(): self
    {
        $currentDate = $this->toDate();
        $currentMonth = (int) $currentDate->format('m');
        $previousDate = $currentDate->setDate((int) $currentDate->format('Y'), $currentMonth - 1, $this->day);
        $previousMonth = (int) $previousDate->format('m');
        $expectedMonth = $currentMonth === 1 ? 12 : ($currentMonth - 1);
        // this means the current month has more days than the previous month
        if ($previousMonth !== $expectedMonth) {
            $previousDate = $currentDate->setDate((int) $currentDate->format('Y'), $currentMonth, 0);
        }

        $object = self::createFromDateTimeObject($previousDate);
        $object->day = $this->day;
        return $object;
    }
}
