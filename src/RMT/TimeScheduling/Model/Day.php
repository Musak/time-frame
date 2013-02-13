<?php

namespace RMT\TimeScheduling\Model;

use RMT\TimeScheduling\Model\om\BaseDay;

class Day extends BaseDay
{
	public function __toString()
	{
		return $this->getValue();
	}
}
