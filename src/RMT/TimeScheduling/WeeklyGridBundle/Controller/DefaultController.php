<?php

namespace RMT\TimeScheduling\WeeklyGridBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use RMT\TimeScheduling\Model\DayIntervalQuery;

class DefaultController extends Controller
{
    public function indexAction($user_id)
    {
    	$user = $this->getUser();
        $day_intervals = DayIntervalQuery::create()
            ->filterByUserId($user_id)
            ->find();
        
        $my_grid = $user->getId() == $user_id;

        $days = array();
        foreach($day_intervals as $day_interval){

        	$days[$day_interval->getDay()->getValue()] = array(
    				'start_hour' => $day_interval->getStartHour()->format('H'),
    				'end_hour' => $day_interval->getEndHour()->format('H')
    			);
        }

        return $this->render('RMTTimeSchedulingWeeklyGridBundle:Default:index.html.twig',array(
          'days'                => $days,
          'my_grid'             => $my_grid,
          'service_provider_id' => $user_id
        ));
    }
}
