<?php
// src/Acme/OtherBundle/EventListener/ConfigureMenuListener.php

namespace RMT\TimeScheduling\WorkingHoursBundle\Menu;
use RMT\SiteManagment\MenuBundle\Event\ConfigureMenuEvent;

class ConfigureMenuListener
{
    /**
     * @param RMT\SiteManagment\MenuBundle\Event\ConfigureMenuEvent $event
     */
    public function onMenuConfigure(ConfigureMenuEvent $event)
    {
        $menu = $event->getMenu();
        $menu->addChild('Working hours',array('route' => 'rmt_time_scheduling_working_hours'));
    }
}