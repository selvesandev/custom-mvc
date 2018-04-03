<?php

namespace Application\System;

use Application\System\Exception\InvalidRequestException;
use Application\System\Exception\NotFoundException;

class Route
{

    private $_route_found = false;

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
        return true;
    }

    private function parseMiddleware(array $middlewares)
    {
        $middlewarePath = '\Application\App\Middleware\\';
        foreach ($middlewares as $middleware) {
            $middlewareClass = $middlewarePath . $middleware;
            if (!class_exists($middlewareClass)) throw new NotFoundException('Middleware not found');

            $middlewareObj = new $middlewareClass();
            $middlewareObj->run();
        }

    }


    /**
     * @param string $requestUri
     * @param string $controllerMethod
     * @return bool
     * @throws InvalidRequestException
     */
    public function get(string $requestUri, string $controllerMethod, array $middleware = [])
    {
        if (!Request::method('get')) return false;

        if (empty($requestUri)) throw new InvalidRequestException('Request Uri cannot be empty');
        $uri = Server::uri();

        $requestUri = trim(trim($requestUri, '/'));

        if ($uri === $requestUri) {

            if (!empty($middleware) && is_array($middleware)) $this->parseMiddleware($middleware);

            $this->_route_found = true;
            $this->callController($controllerMethod);
        }
    }

    /**
     * @param string $requestUri
     * @param string $controllerMethod
     * @return bool
     */
    public function post(string $requestUri, string $controllerMethod, array $middleware = [])
    {
        if (!Request::method('post')) return false;

        $uri = Server::uri();

        $requestUri = trim(trim($requestUri, '/'));

        if ($uri === $requestUri) {
            $this->_route_found = true;
            $this->callController($controllerMethod);
        }
    }

    public function routeExists()
    {
        return $this->_route_found;
    }
}