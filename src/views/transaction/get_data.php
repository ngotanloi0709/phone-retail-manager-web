<?php

use app\models\Customer;
use app\models\Product;
use app\utils\DataHelper;

if (isset($_GET["name"])) {
    /** @var array $products */
    /** @var Product $product */
    $inputName = strtolower($_GET["name"]);
    foreach ($products as $product) {
        $productName = strtolower($product->getName());
        if (str_contains($productName, $inputName)) {
            echo "<li class='list-group-item list-group-item-info' style='width: 300px;'>". $product->getName(). "</li>";
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
            echo DataHelper::getDisplayStringData($customer->getName()). "-" . DataHelper::getDisplayStringData($customer->getAddress());
            return;
        }
    }
}