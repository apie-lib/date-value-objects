<?php
namespace Apie\DateValueObjects\Concerns;

use Apie\Core\ValueObjects\Exceptions\InvalidStringForValueObjectException;
use Apie\Core\ValueObjects\IsStringValueObject;
use DateTimeImmutable;
use ReflectionClass;

/**
 * Trait that can be used for value objects to convert a string into a Date value object in a
 * certain format.
 */
trait IsDateValueObject
{
    use IsStringValueObject;

    private DateTimeImmutable $date;

    private int $day;

    /**
     * Parses the string into a proper format and stores it internally as a date object.
     */
    protected function convert(string $input): string
    {
        $input = trim($input);
        $format = self::getDateFormat();
        $date = DateTimeImmutable::createFromFormat($format, $input);
        if (!$date instanceof DateTimeImmutable) {
            throw new InvalidStringForValueObjectException($input, new ReflectionClass(__CLASS__));
        }
        $newInput = $date->format($format);
        if ($this->isStrictFormat() && $newInput !== $input) {
            throw new InvalidStringForValueObjectException($input, new ReflectionClass(__CLASS__));
        }
        // these are stored specifically for switching months and remembering the current day.
        $this->day = (int) $date->format('d');
        $this->date = $date;
        return $newInput;
    }

    public function toDate(): DateTimeImmutable
    {
        return $this->date;
    }

    /**
     * A class using this trait should tell the trait whether an extra check is required to see
     * if the input format is exactly the same as what was given.
     *
     * If this returns false it means we tolerate input as '2012-12-32', while it throws an error
     * if this method returns true.
     *
     * It also means that days and months also require a correct '0'.
     */
    abstract protected function isStrictFormat(): bool;

    /**
     * The string should be in the format of this date string.
     *
     * @see https://www.php.net/manual/en/datetime.format.php#refsect1-datetime.format-parameters
     */
    abstract public static function getDateFormat(): string;
}
