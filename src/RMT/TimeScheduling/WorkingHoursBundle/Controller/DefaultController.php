<?php

namespace RMT\TimeScheduling\WorkingHoursBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('RMTTimeSchedulingWorkingHoursBundle:Default:index.html.twig', array('name' => $name));
    }
}
