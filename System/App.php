<?php

namespace Application\System;
class App
{
    public function run()
    {
        $this->errorConfig();
        $this->parseRoute();
    }

    private function parseRoute()
    {
        $route = new Route();
        require_once rootPath('routes/routes.php');
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