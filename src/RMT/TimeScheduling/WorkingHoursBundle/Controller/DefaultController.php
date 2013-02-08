<?php

namespace RMT\TimeScheduling\WorkingHoursBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use RMT\TimeScheduling\Model\DayInterval;
use RMT\TimeScheduling\Model\DayIntervalQuery;
use RMT\TimeScheduling\WorkingHoursBundle\Form\Type\DayIntervalType;
class DefaultController extends Controller
{
    public function indexAction()
    {
    	$day_interval = new DayInterval();
    	$form = $this->createForm(new DayIntervalType(), $day_interval);
        $request = $this->getRequest();

        if ('POST' === $request->getMethod()) {
            $form->bindRequest($request);

            if ($form->isValid()) {
                $day_interval->save();

                return $this->redirect($this->generateUrl('rmt_time_scheduling_working_hours_success', array('id' => $day_interval->getId())));
            }
        }
        return $this->render('RMTTimeSchedulingWorkingHoursBundle:Default:index.html.twig',
            array('form' => $form->createView()));
    }

    public function successAction($id)
    {
    	$day_interval = DayIntervalQuery::create()->findPK($id);

    	return $this->render('RMTTimeSchedulingWorkingHoursBundle:Default:success.html.twig',
    	    array('day_interval' => $day_interval));
    }

    public function listAction()
    {
    	$day_intervals = DayIntervalQuery::create()->find();

    	return $this->render('RMTTimeSchedulingWorkingHoursBundle:Default:list.html.twig',
		    array('day_intervals' => $day_intervals)); 	
    }
}
