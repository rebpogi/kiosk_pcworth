<?php
session_start();

// Database connection (update credentials as needed)
$host = 'localhost';
$user = 'zas';
$password = 'group4'; // or your actual DB password
$dbname = 'testing_backend'; // change this to your actual database name

$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ensure cart exists and is not empty
if (!isset($_SESSION['cart']) || count($_SESSION['cart']) === 0) {
    header("Location: startmainkiosk.php");
    exit;
}

// Loop through the cart and update stock
foreach ($_SESSION['cart'] as $item) {
    $product_id = intval($item['id']);
    $quantity = intval($item['quantity']);

    // Prevent reducing stock below zero
    $stmt = $conn->prepare("UPDATE products SET quantity = quantity - ? WHERE id = ? AND quantity >= ?");
    $stmt->bind_param("iii", $quantity, $product_id, $quantity);
    $stmt->execute();
    $stmt->close();
}

// Clear cart after transaction
unset($_SESSION['cart']);
$conn->close();


?>