<?php
// save_receipt.php

// DB connection
$host = 'localhost';
$db = 'testing_backend';
$user = 'zas';
$pass = 'group4';
$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("DB connection failed: " . $conn->connect_error);
}

// Get POST data
$receiptNo = $_POST['receipt_no'] ?? '';
$paymentMethod = $_POST['payment_method'] ?? '';
$timestamp = date('Y-m-d H:i:s');

// Insert into database
$sql = "INSERT INTO receipts (receipt_no, payment_method, timestamp, status) VALUES (?, ?, ?, 'Pending')";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $receiptNo, $paymentMethod, $timestamp);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo "Receipt saved.";
} else {
    echo "Failed to save receipt.";
}

$stmt->close();
$conn->close();
?>
