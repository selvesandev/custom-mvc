<?php

namespace Application\System;

use Application\System\Exception\InvalidRequestException;
use Application\System\Exception\NotFoundException;

class Route
{
    private function callController($controllerMethod)
    {

        $controllerMethod = explode('@', $controllerMethod);
        if (count($controllerMethod) < 2) throw new InvalidRequestException('Must pass a controller and a method name separated by @');


        $controllerName = $controllerMethod[0];
        $methodName = $controllerMethod[1];

        $controllerNameSpace = '\Application\App\Controllers\\';

        $controller = $controllerNameSpace . $controllerName;

        if (!class_exists($controller)) throw new NotFoundException('Controller Not Found ' . $controller);

        $controllerObj = new $controller;

        if (!method_exists($controllerObj, $methodName)) throw new NotFoundException('Method not found ' . $methodName);
        $controllerObj->$methodName();

    }

    public function get(string $requestUri, string $controllerMethod)
    {

        if (!Request::method('get')) return false;

        if (empty($requestUri)) throw new InvalidRequestException('Request Uri cannot be empty');
        $uri = Server::uri();

        $requestUri = trim(trim($requestUri, '/'));

        if ($uri === $requestUri) {
            $this->callController($controllerMethod);
        }
    }

    public function post(string $requestUri, string $controllerMethod)
    {
        if (!Request::method('post')) return false;

        $uri = Server::uri();

        $requestUri = trim(trim($requestUri, '/'));

        if ($uri === $requestUri) {
            $this->callController($controllerMethod);
        }
    }
}