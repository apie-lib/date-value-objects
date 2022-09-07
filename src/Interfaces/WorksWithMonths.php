<?php
namespace Apie\DateValueObjects\Interfaces;

use Apie\Core\ValueObjects\Interfaces\TimeRelatedValueObjectInterface;
use Apie\DateValueObjects\Concerns\CanHaveMonthIntervals;

/**
 * @see CanHaveMonthIntervals
 */
interface WorksWithMonths extends TimeRelatedValueObjectInterface
{
    public function withMonth(int $month): self;
    public function nextMonth(): self;
    public function previousMonth(): self;
}
