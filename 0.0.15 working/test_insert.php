<?php
$conn = new mysqli('localhost', 'zas', 'group4', 'testing_backend');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form inputs
    $name = $_POST['product_display_name'] ?? '';
    $price = $_POST['price'] ?? 0;
    $quantity = $_POST['quantity'] ?? 0;
    $uid = $_POST['UID'] ?? '';
    $category = $_POST['category'] ?? '';
    $manufacturer = $_POST['manufacturer'] ?? '';
    $FormFactor = $_POST['Form_factor'] ?? '';
    $SocketType = $_POST['Socket_type'] ?? ''; 
$ramSocketType = $_POST['Ram_socket_type'] ?? '';  // <-- Add this fallback
    $specs = $_POST['product_specifications'] ?? '';
    $description = $_POST['product_description'] ?? '';
    $status = isset($_POST['status']) ? '0' : '1';
    $warranty = $_POST['warranty_duration'] ?? '';

    // Handle image
    $imagePath = '';
    if (isset($_FILES['immage']) && $_FILES['immage']['error'] === 0) {
        $ext = pathinfo($_FILES['immage']['name'], PATHINFO_EXTENSION);
        $allowed = ['jpg', 'jpeg', 'png'];
        if (in_array(strtolower($ext), $allowed)) {
            $uploadDir = "uploads/";
            if (!is_dir($uploadDir)) mkdir($uploadDir);
            $newName = uniqid("img_") . "." . $ext;
            $imagePath = $uploadDir . $newName;
            move_uploaded_file($_FILES['immage']['tmp_name'], $imagePath);
        }
    }


    // Insert into database
    $stmt = $conn->prepare("INSERT INTO products (
        product_display_name, price, quantity, UID, category, manufacturer, Form_factor, Socket_type,Ram_socket_type, 
        product_specifications, product_description, status, immage, warranty_duration, created_at) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?,? , ?, ?, ?, ?, NOW())");

    $stmt->bind_param(
    "sdisssssssssss",
    $name,
    $price,
    $quantity,
    $uid,
    $category,
    $manufacturer,
    $FormFactor,
    $SocketType,
    $ramSocketType,
    $specs,
    $description,
    $status,
    $imagePath,
    $warranty
);


    if ($stmt->execute()) {
        echo "Product added successfully!    ";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
