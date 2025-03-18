<?php
namespace Apie\DateValueObjects;

use Apie\Core\Exceptions\InvalidTypeException;
use Apie\Core\ValueObjects\Exceptions\InvalidStringForValueObjectException;
use Apie\Core\ValueObjects\Utils;
use Apie\DateValueObjects\Concerns\CanHaveDayIntervals;
use Apie\DateValueObjects\Concerns\CanHaveMonthIntervals;
use Apie\DateValueObjects\Concerns\CanHaveTimeIntervals;
use Apie\DateValueObjects\Concerns\CanHaveYearIntervals;
use Apie\DateValueObjects\Interfaces\WorksWithDays;
use Apie\DateValueObjects\Interfaces\WorksWithMonths;
use Apie\DateValueObjects\Interfaces\WorksWithTimeIntervals;
use Apie\DateValueObjects\Interfaces\WorksWithYears;
use DateTime;
use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;
use ReflectionClass;

/**
 * Contains a Unix timestamp.
 *
 * Example '1654579007'
 */
final class UnixTimestamp implements WorksWithDays, WorksWithMonths, WorksWithYears, WorksWithTimeIntervals
{
    use CanHaveDayIntervals;
    use CanHaveMonthIntervals;
    use CanHaveTimeIntervals;
    use CanHaveYearIntervals;

    private DateTimeImmutable $date;

    private int $day;

    public function __construct(string|int $timestamp)
    {
        $this->date = new DateTimeImmutable("@$timestamp", new DateTimeZone('GMT'));
        $this->day = (int) $this->date->format('d');
    }

    public function toDate(): DateTimeImmutable
    {
        return $this->date;
    }

    public static function fromNative(mixed $input): self
    {
        if ($input instanceof DateTimeInterface) {
            return new self($input->getTimestamp());
        }
        try {
            return new self(Utils::toInt($input));
        } catch (InvalidTypeException $invalidType) {
            throw new InvalidStringForValueObjectException(
                Utils::toString($input),
                new ReflectionClass(__CLASS__),
                $invalidType
            );
        }
    }

    public function toNative(): string
    {
        return (string) $this->date->getTimestamp();
    }

    public static function createFromDateTimeObject(DateTimeInterface $dateTime): self
    {
        return new self($dateTime->getTimestamp());
    }

    public static function createFromCurrentTime(): self
    {
        return self::createFromDateTimeObject(new DateTime());
    }

    public static function getDateFormat(): string
    {
        return 'U';
    }

    public function jsonSerialize(): string
    {
        return $this->toNative();
    }

    public function __toString(): string
    {
        return $this->toNative();
    }
}
