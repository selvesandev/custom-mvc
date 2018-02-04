<?php

namespace Application\System;

class Request
{
    public static function method($method = 'post')
    {
        switch ($method) {
            case 'post':
                return ($_SERVER['REQUEST_METHOD'] === 'POST');
            case 'get':
                return ($_SERVER['REQUEST_METHOD'] === "GET");
            default:
                return false;
        }
    }

}