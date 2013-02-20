<?php

namespace RMT\TimeScheduling;

use Symfony\Component\Validator\ExecutionContext;
use RMT\TimeScheduling\Model\Reservation;
use RMT\TimeScheduling\Model\ReservationQuery;

class ReservationValidator
{
    public static function isValidTime(Reservation $reservation, ExecutionContext $context)
    {
        $reserved = ReservationQuery::create()
          ->filterByServiceProvider($reservation->getServiceProvider())
          ->filterByDay($reservation->getDay())
          ->filterByStartTime($reservation->getStartTime())
          ->exists();
        if($reserved)
        {
            $context->addViolation('This time is already reserved!', array(), null);
        }
    }
}