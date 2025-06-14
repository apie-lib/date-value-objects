<?php
namespace Apie\DateValueObjects\Ranges;

use Apie\Core\Attributes\Description;
use Apie\Core\Attributes\FakeMethod;
use Apie\Core\Exceptions\RangeMismatchException;
use Apie\Core\ValueObjects\CompositeValueObject;
use Apie\Core\ValueObjects\Interfaces\ValueObjectInterface;
use Apie\DateValueObjects\DateWithTimezone;
use Apie\Serializer\Exceptions\ValidationException;
use DateTime;
use Faker\Generator;

#[FakeMethod("createRandom")]
#[Description("Represent a range between two Dates. The start date is always lower than the end date")]
final class DateTimeRange implements ValueObjectInterface
{
    use CompositeValueObject;

    private DateWithTimezone $start;
    private DateWithTimezone $end;

    public function __construct(DateWithTimezone $start, DateWithTimezone $end)
    {
        $this->start = $start;
        $this->end = $end;
        $this->validateState();
    }

    public static function createRandom(Generator $faker): self
    {
        $time1 = $faker->unixTime();
        $time2 = $faker->unixTime();
        if ($time1 > $time2) {
            list($time2, $time1) = [$time1, $time2];
        }
        $firstDate = new DateTime('@' . $time1);
        $secondDate = new DateTime('@' . $time1);

        return new self(
            DateWithTimezone::createFromDateTimeObject($firstDate),
            DateWithTimezone::createFromDateTimeObject($secondDate),
        );
    }

    private function validateState(): void
    {
        if ($this->start->toDate() > $this->end->toDate()) {
            throw ValidationException::createFromArray(
                [
                    'start' => new RangeMismatchException($this->start->toDate(), $this->end->toDate())
                ]
            );
        }
    }
}
