<?php

namespace Application\App\Middleware;

use Application\System\Repositories\MiddlewareRepository;
use Application\System\Session;

class AuthMiddleware implements MiddlewareRepository
{
    public function run()
    {
        $authenticatedUser = Session::get('mvc_auth');
        if (!$authenticatedUser) return redirect()->to('/@admin@login');

        return true;
    }
}