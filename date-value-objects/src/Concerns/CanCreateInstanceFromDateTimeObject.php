<?php
namespace Apie\DateValueObjects\Concerns;

use DateTime;
use DateTimeImmutable;
use DateTimeInterface;
use ReflectionClass;

/**
 * Adds method to date value objects to convert a PHP Datetime object in the value object.
 */
trait CanCreateInstanceFromDateTimeObject
{
    /**
     * @see IsDateValueObject
     */
    abstract public static function getDateFormat(): string;

    public static function createFromDateTimeObject(DateTimeInterface $dateTime): self
    {
        $refl = new ReflectionClass(__CLASS__);
        $instance = $refl->newInstanceWithoutConstructor();
        $instance->date = DateTimeImmutable::createFromInterface($dateTime);
        $instance->internal = $instance->date->format(self::getDateFormat());
        return $instance;
    }

    public static function createFromCurrentTime(): self
    {
        return self::createFromDateTimeObject(new DateTime());
    }
}
