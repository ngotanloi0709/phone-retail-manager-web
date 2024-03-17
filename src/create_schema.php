<?php

use app\models\Order;
use app\models\OrderItem;
use app\models\Product;
use app\models\User;
use Doctrine\ORM\Tools\SchemaTool;

require_once __DIR__ . '/../vendor/autoload.php';

$entityManager = require_once __DIR__ . '/../src/core/database_config.php';

$schemaTool = new SchemaTool($entityManager);

$classes = array(
    $entityManager->getClassMetadata(User::class),
    $entityManager->getClassMetadata(Order::class),
    $entityManager->getClassMetadata(Product::class),
    $entityManager->getClassMetadata(OrderItem::class),
);

$schemaTool->updateSchema($classes);