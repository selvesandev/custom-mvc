<?php

namespace Application\App\Controllers\Backend;

use Application\App\Controllers\Controller;

class BackendController extends Controller
{
    private $_data = [];

    public function index()
    {
        $this->_data['title'] = 'Welcome';
        $this->_data['page'] = 'home.php';
        return view('Backend/master', $this->_data);
    }

    public function add()
    {

    }
}