<?php
// src/Acme/OtherBundle/EventListener/ConfigureMenuListener.php

namespace RMT\TimeScheduling\WeeklyGridBundle\Menu;
use RMT\SiteManagment\MenuBundle\Event\ConfigureMenuEvent;

class ConfigureMenuListener
{
    /**
     * @param RMT\SiteManagment\MenuBundle\Event\ConfigureMenuEvent $event
     */
    public function onMenuConfigure(ConfigureMenuEvent $event)
    {
        $menu = $event->getMenu();
        $menu->addChild('Weekly grid',array('route' => 'rmt_time_scheduling_weekly_grid_homepage'));
    }
}