<?php

namespace RMT\TimeScheduling\Model;

use RMT\TimeScheduling\Model\om\BaseDayInterval;

class DayInterval extends BaseDayInterval
{
	public function getOutput()
	{
		return $this->getDay()->getValue() . ' - ' . $this->getStartHour()->format('H:m');
	}
}
