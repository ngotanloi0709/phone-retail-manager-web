<?php

if (isset($_GET["name"])) {
    foreach ($products as $product) {
        if (strpos($product->getName(), $_GET["name"]) !== false) {
            echo "<li>". $product->getName(). "</li>";
        }
    }
}

if (isset($_GET["nameToGetStock"])) {
    foreach ($products as $product) {
        if ($product->getName() == $_GET["nameToGetStock"]) {
            echo $product->getStock();
        }
    }
}

if (isset($_GET["customerId"])) {
    foreach ($customers as $customer) {
        if ($customer->getId() == $_GET["customerId"]) {
            echo $customer->getName();
        }
    }
}
?>