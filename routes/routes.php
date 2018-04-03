<?php

//Frontend Routes
$route->get('/', 'Frontend\AppController@index');
$route->get('home', 'Frontend\AppController@index');


$route->get('about', 'Frontend\AppController@about');
$route->get('contact', 'Frontend\AppController@contact');
$route->get('faq', 'Frontend\AppController@faq');
$route->post('contact', 'Frontend\AppController@contactAction');
$route->get('blog','Frontend\AppController@blog');


//Login Routes
$route->get('/@admin@login', 'Backend\LoginController@login');
$route->post('@admin@login', 'Backend\LoginController@loginAction');
$route->get('/admin/logout', 'Backend\LoginController@logout');

//Admin Routes
$route->get('/dashboard', 'Backend\BackendController@index', ['AuthMiddleware']);
$route->get('/admin', 'Backend\AdminController@index', ['AuthMiddleware']);
$route->get('/admin/add', 'Backend\AdminController@add', ['AuthMiddleware']);
$route->get('/admin/delete', 'Backend\AdminController@delete', ['AuthMiddleware', 'CheckSuperOrDevMiddleware']);
$route->post('/admin/add', 'Backend\AdminController@addAction', ['AuthMiddleware']);


$route->get('/admin/profile', 'Backend\AdminController@viewProfile', ['AuthMiddleware']);
$route->post('/admin/profile/update', 'Backend\AdminController@updateProfileInfo', ['AuthMiddleware']);
$route->post('/admin/update/password', 'Backend\AdminController@updatePassword', ['AuthMiddleware']);