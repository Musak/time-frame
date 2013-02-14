<?php

namespace RMT\UserManagment\DashboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DashboardController extends Controller
{
    public function indexAction()
    {
        return $this->render('RMTUserManagmentDashboardBundle:Dashboard:index.html.twig');
    }
}
