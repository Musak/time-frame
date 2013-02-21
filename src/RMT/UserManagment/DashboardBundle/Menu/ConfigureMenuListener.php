<?php
// src/Acme/OtherBundle/EventListener/ConfigureMenuListener.php

namespace RMT\UserManagment\DashboardBundle\Menu;
use RMT\SiteManagment\MenuBundle\Event\ConfigureMenuEvent;

class ConfigureMenuListener
{
    /**
     * @param RMT\SiteManagment\MenuBundle\Event\ConfigureMenuEvent $event
     */
    public function onMenuConfigure(ConfigureMenuEvent $event)
    {
        $menu = $event->getMenu();
        $menu->addChild('Dashboard',array('route' => 'user_dashboard'));
    }
}