<?php
namespace Apie\DateValueObjects\Interfaces;

use Apie\Core\ValueObjects\ValueObjectInterface;
use Apie\DateValueObjects\Concerns\CanHaveMonthIntervals;
use DateTimeImmutable;
use DateTimeInterface;

/**
 * @see CanHaveMonthIntervals
 */
interface WorksWithMonths extends ValueObjectInterface
{
    public static function createFromDateTimeObject(DateTimeInterface $dateTime): self;
    public function toDate(): DateTimeImmutable;
    public function withMonth(int $month): self;
    public function nextMonth(): self;
    public function previousMonth(): self;
}
