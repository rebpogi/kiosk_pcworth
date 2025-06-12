<?php
header('Content-Type: application/json');
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();

$host = 'localhost';
$db = 'testing_backend';
$user = 'zas';
$pass = 'group4';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => "Connection failed: " . $conn->connect_error]));
}

// Check if image file is uploaded
if (!isset($_FILES['immage']) || $_FILES['immage']['error'] !== UPLOAD_ERR_OK) {
    die(json_encode(['success' => false, 'message' => "File upload failed or no file uploaded."]));
}

// File upload configuration (same as before)
$uploadDir = "../uploads/";
$webPath = "uploads/";
$maxFileSize = 20 * 1024 * 1024; // 5MB
$allowedExtensions = ['jpg', 'jpeg', 'png'];

// Process image upload (for new products)
$imagePathForDB = null; // Initialize as null if no image is uploaded

if (isset($_FILES['immage']) && $_FILES['immage']['error'] === UPLOAD_ERR_OK) {
    // Validate file
    $filename = basename($_FILES['immage']['name']);
    $imageFileType = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

    if (!in_array($imageFileType, $allowedExtensions)) {
        $response['errors']['immage'] = 'Only JPG/PNG allowed';
    } elseif ($_FILES['immage']['size'] > $maxFileSize) {
        $response['errors']['immage'] = 'File too large (max 5MB)';
    } elseif (!getimagesize($_FILES['immage']['tmp_name'])) {
        $response['errors']['immage'] = 'Invalid image file';
    } else {
        // Generate unique filename (without productId for new inserts)
        $uniqueName = 'product_' . uniqid() . '_' . time() . '.' . $imageFileType;
        $targetFile = $uploadDir . $uniqueName;
        $imagePathForDB = $webPath . $uniqueName; // Web path for DB

        // Create directory if missing
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        // Save the file
        if (!move_uploaded_file($_FILES['immage']['tmp_name'], $targetFile)) {
            throw new Exception('Failed to save image');
        }
    }
}

// Sanitize POST data
$product_display_name = $conn->real_escape_string($_POST['product_display_name'] ?? '');
$price = floatval($_POST['price'] ?? 0);
$category = $conn->real_escape_string($_POST['category'] ?? '');
$manufacturer = $conn->real_escape_string($_POST['manufacturer'] ?? '');
$Form_factor = $conn->real_escape_string($_POST['Form_factor'] ?? '');
$Socket_type = $conn->real_escape_string($_POST['Socket_type'] ?? '');
$Ram_socket_type = $conn->real_escape_string($_POST['Ram_socket_type'] ?? '');
$product_specifications = $conn->real_escape_string($_POST['product_specifications'] ?? '');
$product_description = $conn->real_escape_string($_POST['product_description'] ?? '');
$status = isset($_POST['status']) ? 0 : 1;
$warranty_duration = $conn->real_escape_string($_POST['warranty_duration'] ?? '');
$UID = $conn->real_escape_string($_POST['UID'] ?? '');
$quantity = intval($_POST['quantity'] ?? 0);

$sql = "INSERT INTO products (
    product_display_name, price, category, manufacturer, Form_factor, Socket_type, Ram_socket_type,
    product_specifications, product_description, status, immage, warranty_duration, UID, quantity
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    die(json_encode(['success' => false, 'message' => "Prepare failed: " . $conn->error]));
}

$stmt->bind_param(
    "sdsssssssssssd",
    $product_display_name,
    $price,
    $category,
    $manufacturer,
    $Form_factor,
    $Socket_type,
    $Ram_socket_type,
    $product_specifications,
    $product_description,
    $status,
    $imagePathForDB,
    $warranty_duration,
    $UID,
    $quantity
);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Product added successfully!']);
} else {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>