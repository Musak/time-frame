<?php

namespace RMT\TimeScheduling\WorkingHoursBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

use RMT\TimeScheduling\Model\DayInterval;
use RMT\TimeScheduling\Model\DayIntervalQuery;
use RMT\TimeScheduling\WorkingHoursBundle\Form\Type\DayIntervalType;

// @todo add security filters for user on actions
class DefaultController extends Controller
{
    public function indexAction()
    {
        $user = $this->getUser();
    	$day_intervals = DayIntervalQuery::create()->filterByUser($user)->find();

        return $this->render('RMTTimeSchedulingWorkingHoursBundle:Default:index.html.twig',
            array('day_intervals' => $day_intervals));
    }

    public function successAction($id)
    {
    	$day_interval = DayIntervalQuery::create()->findPK($id);

    	return $this->render('RMTTimeSchedulingWorkingHoursBundle:Default:success.html.twig',
    	    array('day_interval' => $day_interval));
    }

    public function editAction($id)
    {
        $user = $this->getUser();
        $day_interval = DayIntervalQuery::create()
            ->filterByUser($user)
            ->filterById($id)
            ->findOneOrCreate();
        $form = $this->createForm(new DayIntervalType(), $day_interval);
        $request = $this->getRequest();

        if ('POST' === $request->getMethod()) {
            $form->bindRequest($request);

            if ($form->isValid()) {
                $day_interval->setUser($user);
                $day_interval->save();

                return $this->redirect($this->generateUrl(
                    'rmt_time_scheduling_working_hours_success',
                    array('id' => $day_interval->getId())));
            }
        }
        return $this->render('RMTTimeSchedulingWorkingHoursBundle:Default:edit.html.twig',
            array('form' => $form->createView()));
    }

    // @todo access control
    public function deleteAction($id)
    {
        DayIntervalQuery::create()->filterById($id)->delete();
        $referer = $this->getRequest()->headers->get('referer');
        return new RedirectResponse($referer);
    }

}
