<?php

namespace RMT\TimeScheduling;

use Symfony\Component\Validator\ExecutionContext;
use RMT\TimeScheduling\Model\DayInterval;

class DayIntervalValidator
{
    public static function isValidInterval(DayInterval $day_interval, ExecutionContext $context)
    {
        if($day_interval->getStartHour() >= $day_interval->getEndHour())
        {
       	    $context->addViolationAtSubPath('start_hour', 'The start must be earlier than the end hour.', array(), null);
        }
    }
}