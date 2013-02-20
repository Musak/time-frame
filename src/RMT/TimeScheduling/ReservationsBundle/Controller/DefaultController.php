<?php

namespace RMT\TimeScheduling\ReservationsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use RMT\TimeScheduling\Model\Reservation; 
use RMT\TimeScheduling\Model\DayQuery;
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


    // @todo missing day in save
    public function reserveAction($service_provider_id, $reservation_hour, $day_name) {
        $user = $this->getUser();
        $reservation = new Reservation();
        $form = $this->createForm(new ReservationType(), $reservation, array('csrf_protection' => false));
        $form->bind(array(
          'service_provider' => $service_provider_id,
          'start_time' => strtotime("$reservation_hour:00"),
          'end_time'   => strtotime("$reservation_hour:00 + 1 Hour"),
          'day'        => DayQuery::create()->filterByValue($day_name)->findOne()->getId()
            ));
        if ($form->isValid())
        {
            $reservation->setClient($user);
            $reservation->save();
        }
        else
        {
            print_r(get_class_methods($form));
            var_dump($form->getErrorsAsString());
            exit;
        }

        $referer = $this->getRequest()->headers->get('referer');  
        return new RedirectResponse($referer);
    }
}
