<?php


if (!function_exists('rootPath')) {
    function rootPath(string $path = ''): string
    {
        if (!empty($path)) {
            $path = trim($path, '/');
            $path = '/' . $path;
        }
        return dirname(dirname(dirname(__FILE__))) . $path;
    }
}


if (!function_exists('view')) {
    function view(string $name, array $data = [])
    {
        if (empty($name)) throw new \Application\System\Exception\InvalidRequestException("View name cannot be empty");

        $view = $name . '.php';
        extract($data);
        unset($data);
        if (!file_exists(rootPath('Views/' . $view))) throw new \Application\System\Exception\NotFoundException404('View not found ' . $view);
        require_once rootPath('Views/' . $view);
        return true;
    }
}


if (!function_exists('url')) {
    function url(string $attachment = ''): string
    {
        $host = \Application\System\Config::get('env.host');
        if (!empty($attachment)) {
            $attachment = trim($attachment, '/');
            $host .= '/' . $attachment;
        }
        return $host;
    }
}