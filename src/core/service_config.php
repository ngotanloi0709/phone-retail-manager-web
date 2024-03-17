<?php

use DI\ContainerBuilder;
use League\Plates\Engine;

$containerBuilder = new ContainerBuilder();

$containerBuilder->addDefinitions([
    Engine::class => function () {
        return require __DIR__ . '/engine_config.php';
    }
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

$containerBuilder->set('engine', function ($containerBuilder) {
    return $containerBuilder->get(Engine::class);
});



return $containerBuilder;