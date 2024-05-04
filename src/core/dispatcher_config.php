<?php

use FastRoute\RouteCollector;
use function FastRoute\simpleDispatcher;

return simpleDispatcher(function (RouteCollector $r) {
    $r->addGroup('', function (RouteCollector $r) {
        $r->addRoute('GET', '/','HomeController@index');
        $r->addRoute('GET', '/home', 'HomeController@index');
        $r->addRoute('GET', '/login', 'HomeController@getLogin');
        $r->addRoute('POST', '/login', 'HomeController@postLogin');
//        $r->addRoute('GET', '/register', 'HomeController@getRegister');
//        $r->addRoute('POST', '/register', 'HomeController@postRegister');
        $r->addRoute('GET', '/logout', 'HomeController@postLogout');
        $r->addRoute('GET', '/error-not-found', 'HomeController@errorNotFound');
        $r->addRoute('GET', '/login-by-email', 'HomeController@loginByEmail');
    });

    $r->addGroup('/user', function (RouteCollector $r) {
        $r->addRoute('GET', '', 'UserController@getPersonalInformation');
        $r->addRoute('GET', '/', 'UserController@getPersonalInformation');
        $r->addRoute('GET', '/personal-information', 'UserController@getPersonalInformation');
        $r->addRoute('POST', '/change-personal-information', 'UserController@changPersonalInformation');
        $r->addRoute('POST', '/change-password', 'UserController@changePersonalPassword');
        $r->addRoute('POST', '/change-avatar', 'UserController@changeAvatar');
        $r->addRoute('GET', '/change-password-first-time', 'UserController@getChangePasswordFirstTime');
        $r->addRoute('POST', '/change-password-first-time', 'UserController@postChangePasswordFirstTime');
    });

    $r->addGroup('/admin', function (RouteCollector $r) {
        $r->addRoute('GET', '', 'AdminController@index');
        $r->addRoute('GET', '/', 'AdminController@index');
        $r->addRoute('GET', '/user-management', 'AdminController@getUserManagement');
        $r->addRoute('POST', '/create-new-user', 'AdminUserController@createNewUser');
        $r->addRoute('POST', '/send-login-email', 'AdminUserController@sendLoginEmail');
        $r->addRoute('POST', '/delete-user', 'AdminUserController@deleteUser');
        $r->addRoute('POST', '/edit-user', 'AdminUserController@editUser');
        $r->addRoute('POST', '/change-user-password', 'AdminUserController@changeUserPassword');
        $r->addRoute('GET', '/sale-information', 'AdminUserController@getUserSaleInformation');
    });

    $r->addGroup('/transaction', function (RouteCollector $r) {
        $r->addRoute('GET', '', 'TransactionController@index');
        $r->addRoute('GET', '/', 'TransactionController@index');
        $r->addRoute('GET', '/transaction_management', 'TransactionController@getTransactionManagement');
        $r->addRoute('GET', '/transaction_create', 'TransactionController@getTransactionCreate');
        $r->addRoute('GET', '/get_data', 'TransactionController@getData');
        $r->addRoute('GET', '/transaction_checkout', 'TransactionController@getTransactionCheckout');
        $r->addRoute('POST', '/transaction_checkout', 'TransactionController@postTransaction');
        $r->addRoute('GET', '/transaction_invoice', 'TransactionController@getTransactionInvoice');
    });

    $r->addGroup('/customer', function (RouteCollector $r) {
        $r->addRoute('GET', '', 'CustomerController@index');
        $r->addRoute('GET', '/', 'CustomerController@index');
        $r->addRoute('GET', '/customer_transhistory', 'CustomerController@getTransactionHistory');
        $r->addRoute('POST', '/edit-customer', 'CustomerController@editCustomer');
    });
    $r->addGroup('/statistics', function (RouteCollector $r) {
        $r->addRoute('GET', '', 'StatisticsController@index');
        $r->addRoute('GET', '/', 'StaticticsController@index');
        $r->addRoute('GET', '/getdata', 'StatisticsController@getData');
    });
});