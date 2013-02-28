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
        if(is_null($user_id)) {
            $user_id = $user->getId();
        }
        
        $service_provider_user = UserQuery::create()->findPK($user_id);
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
        
        $my_reservations = ReservationQuery::create()
            ->filterByServiceProvider($service_provider_user)
            ->filterByClient($user)
            ->find();
        $my_reserved=array();
        foreach ($my_reservations as $my_reservation) {
            $my_reserved[$my_reservation->getStartTime()->format('G')][$my_reservation->getDay()->getValue()] = $my_reservation->getId(); 
        }
        
        $reserved = array();    
        $reservations = ReservationQuery::create()
            ->filterByServiceProvider($service_provider_user)
            ->find();
        
        foreach ($reservations as $reservation) {
            $reserved[$reservation->getStartTime()->format('G')][] = $reservation->getDay()->getValue();
        }
        
        return $this->render('RMTTimeSchedulingWeeklyGridBundle:Default:index.html.twig',array(
          'days'                => $days,
          'my_grid'             => $my_grid,
          'reserved'            => $reserved,
          'service_provider_id' => $user_id,
          'my_reserved'         => $my_reserved
        ));
    }
}
