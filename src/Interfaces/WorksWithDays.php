<?php
namespace Apie\DateValueObjects\Interfaces;

use Apie\Core\ValueObjects\ValueObjectInterface;
use Apie\DateValueObjects\Concerns\CanHaveDayIntervals;
use DateTimeImmutable;
use DateTimeInterface;

/**
 * @see CanHaveDayIntervals
 */
interface WorksWithDays extends ValueObjectInterface
{
    public static function createFromDateTimeObject(DateTimeInterface $dateTime): self;
    public function toDate(): DateTimeImmutable;
    public function withDay(int $day): self;
    public function tomorrow(): self;
    public function yesterday(): self;
}
