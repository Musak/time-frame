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
        $request = $this->getRequest();

        if ('POST' === $request->getMethod()) {
            $form->bindRequest($request);

            if ($form->isValid()) {
                $day_interval->save();

                // return $this->redirect($this->generateUrl('book_success'));
            }
        }
        return $this->render('RMTTimeSchedulingWorkingHoursBundle:Default:index.html.twig',
            array('form' => $form->createView()));
    }
}
