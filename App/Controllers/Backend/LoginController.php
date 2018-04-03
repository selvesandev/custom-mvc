<?php

namespace Application\App\Controllers\Backend;

use Application\App\Controllers\Controller;
use Application\App\Models\Admin;
use Application\System\Cookie;
use Application\System\Session;
use Application\System\Validation;

class LoginController extends Controller
{
    private $_data = [];
    private $_validation;
    private $_admin;

    public function __construct()
    {
        $this->_validation = new Validation();
        $this->_admin = new Admin();
    }


    public function login()
    {
        if ($this->_admin->checkToSeeLoggedIn()) {
            return redirect()->to('/dashboard');
        }

        return view('Backend/login', $this->_data);
    }


    public function loginAction()
    {
        $this->_validation->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        if (!$this->_validation->isValid()) {
            Session::set('validation_errors', $this->_validation->getErrors());
            return redirect()->back();
        }

        $email = $_POST['email'];
        $password = $_POST['password'];
        $rememberMe = isset($_POST['remember_me']);


        if ($this->_admin->login(['email' => $email, 'status' => 1], $password, $rememberMe))
            return redirect()->to('dashboard');

        Session::set('fail', 'Invalid User Name or password');
        return redirect()->back();
    }

    public function logout()
    {
        $this->_admin->logout();
        return redirect()->to('/@admin@login');
    }
}