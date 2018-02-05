<?php
$route->get('/', 'Frontend\AppController@index');
$route->get('home', 'Frontend\AppController@index');


$route->get('about', 'Frontend\AppController@about');
$route->get('contact', 'Frontend\AppController@contact');
$route->get('faq', 'Frontend\AppController@faq');
$route->post('contact', 'Frontend\AppController@contactAction');


//Admin Route
$route->get('/admin', 'Backend\BackendController@index');