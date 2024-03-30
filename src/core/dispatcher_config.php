<?php

use FastRoute\RouteCollector;
use function FastRoute\simpleDispatcher;

return simpleDispatcher(function (RouteCollector $r) {
    $r->addGroup('', function (RouteCollector $r) {
        $r->addRoute('GET', '/','HomeController@index');
        $r->addRoute('GET', '/home', 'HomeController@index');
        $r->addRoute('GET', '/login', 'HomeController@getLogin');
        $r->addRoute('GET', '/error', 'HomeController@error');
    });

    $r->addGroup('/admin', function (RouteCollector $r) {
        $r->addRoute('GET', '', 'AdminController@index');
        $r->addRoute('GET', '/', 'AdminController@index');
    });
});