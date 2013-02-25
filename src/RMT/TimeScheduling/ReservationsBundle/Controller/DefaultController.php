<?php

namespace RMT\TimeScheduling\ReservationsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use RMT\TimeScheduling\Model\Reservation; 
use RMT\TimeScheduling\Model\DayQuery;
use RMT\TimeScheduling\Model\ReservationQuery;
use RMT\TimeScheduling\ReservationsBundle\Form\Type\ReservationType;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $user        = $this->getUser();
    	$request     = $this->getRequest();
    	$reservation = new Reservation();

    	$form = $this->createForm(new ReservationType(), $reservation);
    	
    	if($request->getMethod() == 'POST')
    	{
    		$form->bindRequest($request);
            if ($form->isValid()) {
                $reservation->setClient($user);
            	$reservation->save();
            }
    	}
        return $this->render('RMTTimeSchedulingReservationsBundle:Default:index.html.twig', array('form' => $form->createView()));
    }

    public function reserveAction($service_provider_id, $reservation_hour, $day_name) {
        $user = $this->getUser();
        $reservation = new Reservation();
        $form = $this->createForm(new ReservationType(), $reservation, array('csrf_protection' => false));
        $form->bind(array(
          'service_provider' => $service_provider_id,
          'start_time' => array('hour' => (int)$reservation_hour, 'minute' => '0'),
          'end_time'   => array('hour'=> 1+ (int)$reservation_hour,'minute'=>'0'),//, strtotime("$reservation_hour:00:00 + 1 Hour")),
          'day'        => DayQuery::create()->filterByValue($day_name)->findOne()->getId()
            ));
        if ($form->isValid())
        {
            $reservation->setClient($user);
            $reservation->save();
        }
        $referer = $this->getRequest()->headers->get('referer');  
        return new RedirectResponse($referer);
    }

    public function cancelAction($reservation_id)
    {
        ReservationQuery::create()
            ->findPK($reservation_id)
            ->delete();
        $referer = $this->getRequest()->headers->get('referer');  
        return new RedirectResponse($referer);
    }

}
