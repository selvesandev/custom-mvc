<?php

namespace Application\System;

use Application\System\Exception\NotFoundException404;

class App
{
    public function run()
    {
        session_start();
        $this->errorConfig();
        $this->parseRoute();
    }

    private function parseRoute()
    {
        $route = new Route();
        require_once rootPath('routes/routes.php');
        if (!$route->routeExists()) {
            $uri = Server::uri();
            throw new NotFoundException404("Page Nout Found {$uri}");
        }
        unset($route);
    }


    /**
     * Configure error setting according to the environment being used.
     */
    private function errorConfig()
    {
        //environment configure
        $environment = Config::get('env.env');
        switch ($environment) {
            case 'production':
                ini_set('display_errors', 'Off');
                error_reporting(-1);
                break;
            case 'development':
            default:
                ini_set('display_errors', 'On');
                error_reporting(E_ALL);
                break;
                break;
        }
    }
}