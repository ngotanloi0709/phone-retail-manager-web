<?php

use DI\ContainerBuilder;

$containerBuilder = new ContainerBuilder();
$container = $containerBuilder->build();

$container->set('dispatcher', function () {
    return require __DIR__ . '/routes.php';
});

$container->set('container', $container);

return $container;