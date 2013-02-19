<?php

namespace RMT\TimeScheduling\ReservationsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use RMT\TimeScheduling\Model\Reservation;
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
    public function reserveAction($service_provider_id, $reservation_hour) {
        $user = $this->getUser();
        $reservation = new Reservation();
        $reservation->setClient($user);
        // @todo add service provider user validation
        $reservation->setServiceProviderUserId($service_provider_id);
        $reservation->setStartTime(strtotime("$reservation_hour:00"));
        $reservation->setEndTime(strtotime("$reservation_hour:00 + 1 Hour"));
        $reservation->save();

        $referer = $this->getRequest()->headers->get('referer');  
        return new RedirectResponse($referer);
    }
}
