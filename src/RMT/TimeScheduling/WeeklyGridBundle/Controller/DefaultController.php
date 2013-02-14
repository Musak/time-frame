<?php

namespace RMT\TimeScheduling\WeeklyGridBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use RMT\TimeScheduling\Model\DayIntervalQuery;

class DefaultController extends Controller
{
    public function indexAction()
    {

    	$user = $this->getUser();
        $day_intervals = DayIntervalQuery::create()
            ->filterByUser($user)
            ->find();
        

        foreach($day_intervals as $day_interval){

    	$days[$day_interval->getDay()->getValue()] = array(
				'start_hour' => $day_interval->getStartHour()->format('H'),
				'end_hour' => $day_interval->getEndHour()->format('H')
			);
        }
        return $this->render('RMTTimeSchedulingWeeklyGridBundle:Default:index.html.twig',array('days'=>$days));
    }
}
