<?php

namespace Application\System;

class Redirect
{
    public function back()
    {
        $requestHeader = getallheaders();
        if (isset($requestHeader['Referer']))
            header('Location: ' . $requestHeader['Referer']);
        return $this;
    }

    public function to(string $redirectPath)
    {
        $rootPath = url($redirectPath);
        header("Location: " . $rootPath);
        return true;
    }

}