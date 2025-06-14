<?php
include 'DB_connect.php';

$name = $_POST['name'] ?? '';
$currentId = $_POST['current_id'] ?? 0;

$stmt = $conn->prepare("SELECT id FROM products WHERE product_display_name = ? AND id != ?");
$stmt->bind_param("si", $name, $currentId);
$stmt->execute();
$stmt->store_result();

echo json_encode(['exists' => $stmt->num_rows > 0]);    
?>