<?php

namespace Application\System;

class Session
{
    /**
     * @param string $key
     * @param $value
     * @return bool
     */
    public static function set(string $key, $value)
    {
        if (empty($key)) return false;
        return $_SESSION[$key] = $value;
    }


    public static function get(string $key)
    {
        if (!self::exists($key))
            return '';
        return $_SESSION[$key];
    }

    public static function exists(string $key)
    {
        if (empty($key)) return false;
        return isset($_SESSION[$key]);
    }


    public static function delete(string $key)
    {
        if (!self::exists($key))
            return false;
        unset($_SESSION[$key]);
        return true;
    }


    public static function destroy()
    {
        session_destroy();
        return true;
    }
}