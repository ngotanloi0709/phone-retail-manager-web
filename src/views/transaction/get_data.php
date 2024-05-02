<?php

use app\models\Customer;
use app\models\Product;

if (isset($_GET["name"])) {
    /** @var array $products */
    /** @var Product $product */
    foreach ($products as $product) {
        if (str_contains($product->getName(), $_GET["name"])) {
            echo "<li>". $product->getName(). "</li>";
        }
    }
}

if (isset($_GET["nameToGetStock"])) {
    /** @var array $products */
    /** @var Product $product */
    foreach ($products as $product) {
        if ($product->getName() == $_GET["nameToGetStock"]) {
            echo $product->getStock();
        }
    }
}

if (isset($_GET["customerPhone"])) {
    /** @var array $customers */
    /** @var Customer $customer */
    foreach ($customers as $customer) {
        if ($customer->getPhone() == $_GET["customerPhone"]) {
            echo $customer->getName(). "-" . $customer->getAddress();
        }
    }
}