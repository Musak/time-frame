<?php

namespace RMT\TimeScheduling\HourReservationsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('RMTTimeSchedulingHourReservationsBundle:Default:index.html.twig', array('name' => $name));
    }
}
