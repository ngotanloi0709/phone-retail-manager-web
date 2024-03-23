<?php

use Doctrine\ORM\EntityManager;

$container = require_once __DIR__ . "/../src/core/service_config.php";

$container->set(EntityManager::class, function () {
    return require __DIR__ . '/../src/core/database_config.php';
});

return $container;