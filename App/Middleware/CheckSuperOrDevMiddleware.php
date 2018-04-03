<?php

namespace Application\App\Middleware;

use Application\System\Repositories\MiddlewareRepository;
use Application\System\Session;

class CheckSuperOrDevMiddleware implements MiddlewareRepository
{
    public function run()
    {
        //session logged in user
        //logged in user privileges
        //logged in user super or developer

        //>> FALSE >> redirect back


        //delete user privilges
        // developers
        // >> TRUE redirect back

        die('to do developer or super admin check middleware');
        return true;
    }
}