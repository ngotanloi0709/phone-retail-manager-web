<?php

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;

$config = ORMSetup::createAttributeMetadataConfiguration(
    paths: array(__DIR__ . "/src/models"),
    isDevMode: true,
);

$connection = DriverManager::getConnection([
    'driver' => 'pdo_mysql',
    'host' => 'localhost',
    'dbname' => 'phone-retail-manager-web',
    'user' => 'root',
    'password' => '',
    'port' => 3306,
    'unix_socket' => '/Applications/XAMPP/xamppfiles/var/mysql/mysql.sock'
], $config);

return new EntityManager($connection, $config);