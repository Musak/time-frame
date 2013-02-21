<?php

namespace RMT\SiteManagment\MenuBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;
use RMT\SiteManagment\MenuBundle\Event\ConfigureMenuEvent;

class MenuBuilder
{
    private $factory;
    private $event_dispatcher;
    
    public function __construct(FactoryInterface $factory, EventDispatcher $event_dispatcher)
    {
        $this->factory = $factory;
        $this->event_dispatcher = $event_dispatcher;
        
    }
    
    public function createUserMenu()
    {
        $menu = $this->factory->createItem('root');
        $this->event_dispatcher->dispatch(ConfigureMenuEvent::CONFIGURE_USER_MENU, 
                                          new ConfigureMenuEvent($this->factory, $menu));
       # $menu->addChild('test',array('route' => 'user_dashboard'));
        return $menu;
    }
}
