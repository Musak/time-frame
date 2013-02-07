<?php

namespace RMT\UserManagment\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class RMTUserManagmentUserBundle extends Bundle
{
  
    public function getParent() 
    {
        return 'FOSUserBundle';
    }
}
