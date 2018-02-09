<?php
$route->get('/', 'Frontend\AppController@index');
$route->get('home', 'Frontend\AppController@index');


$route->get('about', 'Frontend\AppController@about');
$route->get('contact', 'Frontend\AppController@contact');
$route->get('faq', 'Frontend\AppController@faq');
$route->post('contact', 'Frontend\AppController@contactAction');


//Admin Route
$route->get('/dashboard', 'Backend\BackendController@index');
$route->get('/admin', 'Backend\AdminController@index');
$route->get('/admin/add', 'Backend\AdminController@add');
$route->get('/admin/delete', 'Backend\AdminController@delete');

$route->post('/admin/add', 'Backend\AdminController@addAction');