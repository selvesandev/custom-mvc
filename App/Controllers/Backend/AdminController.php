<?php

namespace Application\App\Controllers\Backend;

use Application\App\Controllers\Controller;
use Application\System\Validation;

class AdminController extends Controller
{
    private $_data = [];
    private $_view = 'Backend/master';

    public function index()
    {
        $this->_data['page'] = 'admin.php';
        $this->_data['title'] = 'Admins';
        return view($this->_view, $this->_data);
    }

    public function add()
    {
        $this->_data['page'] = 'add-admin.php';
        $this->_data['title'] = 'Add Admin';

        return view($this->_view, $this->_data);
    }




    public function addAction()
    {
        $validate = new Validation();
        $rules = [
            'name' => 'required|min:3|max:20|exact:20',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|min:6',
            'password_confirmation' => 'required|matches:password'
        ];

        $validate->validate($rules);

        if (!$validate->isValid()) {
            //rediect back with validation message
        }

        //manage data

        //model call
        //insert data
        //check the response

        //error success
    }
}