<?php

namespace Application\System\Traits;

use Application\System\Config;
use Application\System\Cookie;
use Application\System\Session;

trait Authentication
{
    /**
     * @param array $loginCriteria
     * @param string $password
     * @param bool $rememberMe
     * @return bool
     */
    public function login(array $loginCriteria, string $password, bool $rememberMe = false)
    {
        if (empty($loginCriteria) || empty($password)) return false;

        $admin = $this->getSingle($loginCriteria);

        if (!$admin) return false;

        if (!password_verify($password, $admin->password)) return false;

        if ($rememberMe) {
            Cookie::set(Config::get('auth.auth_session'), $admin->password);
        }
        Session::set('mvc_auth', $admin);
        return true;
    }

    /**
     * @return bool
     */
    public function logout()
    {
        Cookie::delete('mvc_auth');
        Session::delete('mvc_auth');
        return true;
    }

    public function user()
    {
        $loggedSession = Session::get('mvc_auth');
        if (isset($loggedSession->id)) {
            $id = $loggedSession->id;
            $data = $this->find($id);
            if ($data->password) {
                unset($data->password);
            }
            return $data;
        }
        return false;
    }

    public function checkToSeeLoggedIn()
    {
        $loggedSession = Session::get('mvc_auth');

        if (!$loggedSession) {
            $cookie = Cookie::get('mvc_auth');
            if ($cookie) {
                $user = $this->getSingle(['password' => $cookie]);
                if(!$user) return false;
                unset($user->password);
                Session::set('mvc_auth', $user);
                return true;
            }
            return false;
        }
        return true;
    }
}