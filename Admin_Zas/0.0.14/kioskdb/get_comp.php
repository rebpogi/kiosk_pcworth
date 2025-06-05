<?php

$host = "localhost";
$username = "zas";
$password = "group4";
$database = "testing_backend";

$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
  die(json_encode(['error' => 'Database connection failed.']));
}

$category = $_GET['category'] ?? '';
$category = $conn->real_escape_string($category);

$sql = "SELECT ID, product_display_name, price, immage FROM products 
        WHERE category = '$category' AND status = 'Shown'";

$result = $conn->query($sql);
$products = [];

if ($result) {
  while ($row = $result->fetch_assoc()) {
    $products[] = $row;
  }
}

$conn->close();
header('Content-Type: application/json');
echo json_encode($products);
