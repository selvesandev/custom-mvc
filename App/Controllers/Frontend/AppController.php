<?php

namespace Application\App\Controllers\Frontend;

class AppController
{
    private $_page = 'Frontend';

    public function index()
    {
        $data['name'] = 'Ram';
        $data['age'] = 40;
        return view($this->_page . '/home', $data);
    }

    /**
     * @return bool
     */
    public function about()
    {
        return view($this->_page . '/about');
    }

    /**
     * @return bool
     */
    public function contact()
    {
        return view($this->_page . '/contact');
    }

    /**
     * @return bool
     */
    public function faq()
    {
        return view($this->_page . '/faq');
    }

    /**
     *
     */
    public function contactAction()
    {
        print_r($_POST);
    }
}