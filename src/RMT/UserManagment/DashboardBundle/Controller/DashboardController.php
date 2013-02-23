<?php

namespace RMT\UserManagment\DashboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use RMT\TimeScheduling\Model\DayIntervalQuery;

class DashboardController extends Controller
{
    public function indexAction()
    {
        $has_interval = DayIntervalQuery::create()
                            ->filterByUser($this->getUser())
                            ->exists();
        
        return $this->render('RMTUserManagmentDashboardBundle:Dashboard:index.html.twig', 
                            array('has_interval' => $has_interval));
    }
}
