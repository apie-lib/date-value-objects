<?php
namespace Apie\DateValueObjects\Interfaces;

use Apie\Core\ValueObjects\Interfaces\TimeRelatedValueObjectInterface;

/**
 * @see CanHaveYearIntervals
 */
interface WorksWithYears extends TimeRelatedValueObjectInterface
{
    public function withYear(int $year): self;
    public function nextYear(): self;
    public function previousYear(): self;
}
