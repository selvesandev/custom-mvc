<?php

namespace Application\System;

class Server
{
    public static function ip()
    {

    }

    public static function method()
    {

    }

    public static function uri()
    {
        $uri = $_SERVER['REQUEST_URI'];
        $uri = preg_replace('/[?].*/', '', $uri);
        return trim($uri, '/');
    }

    public static function url()
    {
    }
}