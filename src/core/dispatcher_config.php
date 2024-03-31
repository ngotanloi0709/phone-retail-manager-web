<?php

use FastRoute\RouteCollector;
use function FastRoute\simpleDispatcher;

return simpleDispatcher(function (RouteCollector $r) {
    $r->addGroup('', function (RouteCollector $r) {
        $r->addRoute('GET', '/','HomeController@index');
        $r->addRoute('GET', '/home', 'HomeController@index');
        $r->addRoute('GET', '/login', 'HomeController@getLogin');
        $r->addRoute('POST', '/login', 'HomeController@postLogin');
        $r->addRoute('GET', '/register', 'HomeController@getRegister');
        $r->addRoute('POST', '/register', 'HomeController@postRegister');
        $r->addRoute('GET', '/logout', 'HomeController@postLogout');
        $r->addRoute('GET', '/error-not-found', 'HomeController@errorNotFound');
    });

    $r->addGroup('/admin', function (RouteCollector $r) {
        $r->addRoute('GET', '', 'AdminController@index');
        $r->addRoute('GET', '/', 'AdminController@index');
        $r->addRoute('GET', '/user-management', 'AdminController@getUserManagement');
    });
});