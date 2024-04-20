<?php

use DI\ContainerBuilder;
use Doctrine\ORM\EntityManager;
use League\Plates\Engine;
use function DI\autowire;

$containerBuilder = new ContainerBuilder();
$databaseConfig = require __DIR__ . '/database_config.php';

$containerBuilder->addDefinitions([
    Engine::class => autowire(Engine::class)->constructor(__DIR__ . '/../views'),
    EntityManager::class => autowire(EntityManager::class)->constructor($databaseConfig[0], $databaseConfig[1]),
]);

try {
    $containerBuilder = $containerBuilder->build();
} catch (Exception $e) {
    error_log($e->getMessage());
    exit('Could not build container at service_config.php.');
}

$containerBuilder->set('dispatcher', function () {
    return require __DIR__ . '/dispatcher_config.php';
});

return $containerBuilder;