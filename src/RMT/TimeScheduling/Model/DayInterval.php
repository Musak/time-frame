<?php

namespace RMT\TimeScheduling\Model;

use RMT\TimeScheduling\Model\om\BaseDayInterval;

class DayInterval extends BaseDayInterval
{
	public function getOutput()
	{
		return $this->getDay()->getValue() . ' - ' . $this->getStartHour()->format('H:i');
	}

	public function getStartHourDisplay()
	{
		return $this->getStartHour()->format('H:i');
	}

	public function getEndHourDisplay()
	{
		return $this->getEndHour()->format('H:i');
	}
}
