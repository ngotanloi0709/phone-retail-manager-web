<?php

if (isset($_POST["q"])) {
    foreach ($products as $product) {
        if (strpos($product->getName(), $_POST["q"]) !== false) {
            echo "<li>". $product->getName(). "</li>";
        }
    }
}
?>