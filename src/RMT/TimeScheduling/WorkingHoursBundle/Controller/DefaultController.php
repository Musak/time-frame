<?php

namespace RMT\TimeScheduling\WorkingHoursBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use RMT\TimeScheduling\Model\DayInterval;
use RMT\TimeScheduling\WorkingHoursBundle\Form\Type\DayIntervalType;
class DefaultController extends Controller
{
    public function indexAction()
    {
    	$day_interval = new DayInterval();
    	$form = $this->createForm(new DayIntervalType(), $day_interval);
        return $this->render('RMTTimeSchedulingWorkingHoursBundle:Default:index.html.twig',
            array('form' => $form->createView()));
    }
}
