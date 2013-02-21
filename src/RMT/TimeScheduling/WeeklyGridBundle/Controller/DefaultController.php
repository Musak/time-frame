<?php

namespace RMT\TimeScheduling\WeeklyGridBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use RMT\TimeScheduling\Model\DayIntervalQuery;
use RMT\TimeScheduling\Model\ReservationQuery;
use FOS\UserBundle\Propel\UserQuery;

class DefaultController extends Controller
{
    public function indexAction($user_id)
    {
    	$user = $this->getUser();
        $service_provider_user = UserQuery::create()
            ->findPK($user_id);
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
        $reserved = ReservationQuery::create()
            ->filterByServiceProvider($service_provider_user)
            ->find()
            ->toKeyValue('StartTime','EndTime');

        return $this->render('RMTTimeSchedulingWeeklyGridBundle:Default:index.html.twig',array(
          'days'                => $days,
          'my_grid'             => $my_grid,
          'reserved'            => $reserved,
          'service_provider_id' => $user_id

        ));
    }
}
