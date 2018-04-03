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

        $name = str_replace('.php', '', $name);

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

/**
 *
 */
if (!function_exists('redirect')) {
    function redirect()
    {
        $redirect = new \Application\System\Redirect();
        return $redirect;
    }
}

/**
 *
 */
if (!function_exists('validationErrors')) {
    function validationErrors(string $className = '')
    {
        $errors = \Application\System\Session::get('validation_errors');
        if (empty($errors)) return '';

        $output = '';
        foreach ($errors as $key => $error) {
            $output .= "<div class='" . $className . ' ' . $key . "'>";
            $output .= ucfirst($error);
            $output .= "</div>";
        }

        \Application\System\Session::delete('validation_errors');

        return $output;
    }
}

if (!function_exists('message')) {
    function message()
    {
        $successMessage = \Application\System\Session::get('success');
        $failMessage = \Application\System\Session::get('fail');
        $output = '';
        if (!empty($successMessage)) {
            $output = "<div class='alert alert-success'>";
            $output .= $successMessage;
            $output .= "</div>";
            \Application\System\Session::delete('success');
        } else if (!empty($failMessage)) {
            $output = "<div class='alert alert-danger'>";
            $output .= $failMessage;
            $output .= "</div>";
            \Application\System\Session::delete('fail');
        }
        return $output;
    }
}
