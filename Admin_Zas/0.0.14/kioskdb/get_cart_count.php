<?php
session_start();

$totalQuantity = 0;

if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        if (isset($item['quantity'])) {
            $totalQuantity += $item['quantity'];
        }
    }
}

echo $totalQuantity;
?>