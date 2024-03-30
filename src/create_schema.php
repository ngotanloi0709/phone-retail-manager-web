<?php

use app\models\Category;
use app\models\Customer;
use app\models\Transaction;
use app\models\TransactionDetail;
use app\models\Product;
use app\models\User;
use Doctrine\ORM\Tools\SchemaTool;

require_once __DIR__ . '/../vendor/autoload.php';

$entityManager = require_once __DIR__ . '/../src/core/database_config.php';

$schemaTool = new SchemaTool($entityManager);

$classes = array(
    $entityManager->getClassMetadata(User::class),
    $entityManager->getClassMetadata(Customer::class),
    $entityManager->getClassMetadata(Transaction::class),
    $entityManager->getClassMetadata(TransactionDetail::class),
    $entityManager->getClassMetadata(Product::class),
    $entityManager->getClassMetadata(Category::class),
);

$schemaTool->updateSchema($classes);