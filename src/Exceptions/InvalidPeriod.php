<?php

namespace Uasoft\Badaso\Module\Post\Exceptions;

use DateTimeInterface;
use Exception;
use Uasoft\Badaso\Module\Post\Exceptions\InvalidPeriod as ExceptionsInvalidPeriod;

class InvalidPeriod extends Exception
{
    public static function startDateCannotBeAfterEndDate(DateTimeInterface $startDate, DateTimeInterface $endDate)
    {
        return new self("Start date `{$startDate->format('Y-m-d')}` cannot be after end date `{$endDate->format('Y-m-d')}`.");

    }
}
