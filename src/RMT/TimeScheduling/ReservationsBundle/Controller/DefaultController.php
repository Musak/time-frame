<?php

namespace RMT\TimeScheduling\ReservationsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use RMT\TimeScheduling\Model\Reservation;
use RMT\TimeScheduling\ReservationsBundle\Form\Type\ReservationType;

class DefaultController extends Controller
{
    public function indexAction()
    {
    	$request = $this->getRequest();
    	$reservation = new Reservation();
    	$form = $this->createForm(new ReservationType(), $reservation);
    	
    	if($request->getMethod() == 'POST')
    	{
    		$form->bindRequest($request);
            if ($form->isValid()) {
            	$reservation->save();
            }
    	}
        return $this->render('RMTTimeSchedulingReservationsBundle:Default:index.html.twig', array('form' => $form->createView()));
    }
}
