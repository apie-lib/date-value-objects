<?php
namespace Apie\DateValueObjects\Interfaces;

use Apie\Core\ValueObjects\ValueObjectInterface;
use Apie\DateValueObjects\Concerns\CanHaveYearIntervals;
use DateTimeImmutable;
use DateTimeInterface;

/**
 * @see CanHaveYearIntervals
 */
interface WorksWithYears extends ValueObjectInterface
{
    public static function createFromDateTimeObject(DateTimeInterface $dateTime): self;
    public function toDate(): DateTimeImmutable;
    public function withYear(int $year): self;
    public function nextYear(): self;
    public function previousYear(): self;
}
