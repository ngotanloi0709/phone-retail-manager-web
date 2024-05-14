<?php

return [
    'LOCAL' => [
        'driver' => 'pdo_mysql',
        'host' => 'localhost',
        'dbname' => 'phone-retail-manager-web',
        'user' => 'root',
        'password' => '',
        'port' => 3306,
        'unix_socket' => '/Applications/XAMPP/xamppfiles/var/mysql/mysql.sock'
    ],
    'DEV_CONTAINER' => [
        'driver' => 'pdo_mysql',
        'host' => 'mariadb',
        'dbname' => 'prs',
        'user' => 'root',
        'password' => 'root',
        'port' => 3306,
        'unix_socket' => '/Applications/XAMPP/xamppfiles/var/mysql/mysql.sock'
    ]
];