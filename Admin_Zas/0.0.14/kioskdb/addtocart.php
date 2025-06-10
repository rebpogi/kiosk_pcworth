<?php
session_start();

// Connect to database
$host = "localhost";
$username = "zas";
$password = "group4";
$database = "testing_backend";

$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
  response(false, "Database connection failed.");
}

// Validate input
if (!isset($_POST['ID'], $_POST['quantity'])) {
  response(false, "Invalid request.");
}

$product_id = intval($_POST['ID']);
$quantity = intval($_POST['quantity']);

// Fetch product details
$sql = "SELECT * FROM products WHERE ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

if (!$result || $result->num_rows !== 1) {
  response(false, "Product not found or unavailable.");
}

$product = $result->fetch_assoc();

// Check stock
if ($quantity > $product['quantity']) {
  response(false, "Quantity exceeds available stock.");
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

// Return JSON if AJAX, else redirect
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
  response(true);
} else {
  header("Location: viewcart.php");
  exit();
}

function response($success, $message = "") {
  header('Content-Type: application/json');
  echo json_encode(['success' => $success, 'message' => $message]);
  exit();
}
