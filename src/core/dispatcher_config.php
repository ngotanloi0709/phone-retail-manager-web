<?php

use FastRoute\RouteCollector;
use function FastRoute\simpleDispatcher;

return simpleDispatcher(function (RouteCollector $r) {
    // user routes
    // $r->addRoute('GET', '/login', 'UserController@getLogin');
    // $r->addRoute('POST', '/login', 'UserController@postLogin');

    // home routes
     $r->addRoute('GET', '/', 'HomeController@index');
     $r->addRoute('GET', '/home', 'HomeController@index');

    // admin routes
    // $r->addRoute('GET', '/admin/', 'AdminController@index');
});