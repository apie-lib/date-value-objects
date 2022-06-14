<?php
namespace Apie\DateValueObjects\Interfaces;

use Apie\Core\ValueObjects\Interfaces\TimeRelatedValueObjectInterface;
use Apie\DateValueObjects\Concerns\CanHaveDayIntervals;

/**
 * @see CanHaveDayIntervals
 */
interface WorksWithDays extends TimeRelatedValueObjectInterface
{
    public function withDay(int $day): self;
    public function tomorrow(): self;
    public function yesterday(): self;
}
