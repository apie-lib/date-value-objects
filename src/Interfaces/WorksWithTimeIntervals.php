<?php
namespace Apie\DateValueObjects\Interfaces;

use Apie\Core\ValueObjects\ValueObjectInterface;
use Apie\DateValueObjects\Concerns\CanHaveTimeIntervals;
use DateTimeImmutable;
use DateTimeInterface;

/**
 * @see CanHaveTimeIntervals
 */
interface WorksWithTimeIntervals extends ValueObjectInterface
{
    public static function createFromDateTimeObject(DateTimeInterface $dateTime): self;
    public function toDate(): DateTimeImmutable;
    public function withTime(
        ?int $hour = null,
        ?int $minute = null,
        ?int $second = null,
        ?int $micro = null
    ): self;
    public function nextHour(): self;
    public function previousHour(): self;
    public function nextMinute(): self;
    public function previousMinute(): self;
    public function nextSecond(): self;
    public function previousSecond(): self;
}
