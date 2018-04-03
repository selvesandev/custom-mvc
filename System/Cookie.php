<?php

namespace Application\System;

class Cookie
{
    /**
     * @param string $key
     * @param $value
     * @param int $interval
     * @return bool
     */
    public static function set(string $key, $value, int $interval = 0)
    {
        if (empty($interval))
            $interval = time() + (60 * 60 * 24 * 7);
        setcookie($key, $value, $interval);
    }


    public static function get(string $key)
    {
        if (!self::exists($key)) return '';
        return $_COOKIE[$key];
    }

    public static function exists(string $key)
    {
        return isset($_COOKIE[$key]);
    }


    public static function delete(string $key)
    {
        if (!self::exists($key)) return false;

        setcookie($key, '', -1, '/');
        return true;
    }

}