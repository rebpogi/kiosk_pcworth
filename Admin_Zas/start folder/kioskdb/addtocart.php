<?php
session_start();

// Connect to database
$host = "localhost";
$username = "zas";
$password = "group4";
$database = "testing_backend";

$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Validate input
if (!isset($_POST['ID'], $_POST['quantity'])) {
  die("Invalid request.");
}

$product_id = intval($_POST['ID']);
$quantity = intval($_POST['quantity']);

// Fetch product details
$sql = "SELECT * FROM products WHERE ID = $product_id";
$result = $conn->query($sql);

if (!$result || $result->num_rows !== 1) {
  die("Product not found or unavailable.");
}

$product = $result->fetch_assoc();

// Check stock
if ($quantity > $product['quantity']) {
  die("Quantity exceeds available stock.");
}

// Initialize cart if not already
if (!isset($_SESSION['cart'])) {
  $_SESSION['cart'] = [];
}

// Add/update item in cart
if (isset($_SESSION['cart'][$product_id])) {
  $_SESSION['cart'][$product_id]['quantity'] += $quantity;
} else {
  $_SESSION['cart'][$product_id] = [
    'id' => $product['ID'],
    'name' => $product['product_display_name'],
    'price' => $product['price'],
    'image_url' => $product['immage'],
    'quantity' => $quantity
  ];  
}

$conn->close();

// Redirect to cart or confirmation page
header("Location: viewcart.php");
exit();
?>
