<?php

namespace RMT\TimeScheduling\WeeklyGridBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {


        return $this->render('RMTTimeSchedulingWeeklyGridBundle:Default:index.html.twig');
    }
}
