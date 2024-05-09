<?php

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;

$databaseConfig = $GLOBALS['config']['DATABASE']['DEV_CONTAINER'];
$config = ORMSetup::createAttributeMetadataConfiguration(
    paths: array(__DIR__ . "/src/models"),
    isDevMode: true,
);


$connection = DriverManager::getConnection($databaseConfig, $config);

return [$connection, $config];