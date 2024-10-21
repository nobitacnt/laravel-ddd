<?php
namespace Modules\Shared\Domain\ValueObjects;

use Modules\Shared\Domain\Exceptions\IncompleteDateRangeException;
use Modules\Shared\Domain\Exceptions\InvalidDateRangeException;

final readonly class DateRange
{
    public function __construct(private Date $fromDate, private Date $toDate)
    {
        if ($fromDate->isAfter($toDate)) {
            throw new InvalidDateRangeException();
        }
    }

    public static function fromString(?string $fromDate, ?string $toDate): ?self
    {
        if ($fromDate === null xor $toDate === null) {
            throw new IncompleteDateRangeException("Both fromDate and toDate must be provided together.");
        }

        if(!$fromDate && !$toDate) {
            return null;
        }

        return new static(Date::fromString($fromDate), Date::fromString($toDate));
    }

    public function getFromDate(): Date
    {
        return $this->fromDate;
    }

    public function getToDate(): Date
    {
        return $this->toDate;
    }

    public function toArray(string $format = 'Y-m-d H:i:s'): array
    {
        return [
            $this->fromDate->format($format),
            $this->toDate->format($format)
        ];
    }
}
