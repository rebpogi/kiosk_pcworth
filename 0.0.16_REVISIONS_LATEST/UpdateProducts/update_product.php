<?php
header('Content-Type: application/json');
require_once 'DB_connect.php';
session_start(); // Start the session

$response = [
    'success' => false,
    'message' => 'An error occurred',
    'errors' => [],
    'product' => [],
    'image_url' => null
];

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Invalid request method', 405);
    }

    // Check if user is logged in
    if (!isset($_SESSION['firstname'])) {
        throw new Exception('User not logged in', 401);
    }

    $productId = filter_input(INPUT_POST, 'ID', FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
    if (!$productId) {
        throw new Exception('Invalid product ID', 400);
    }

    // Validate required fields
    $requiredFields = [
        'product_display_name' => 'Product name',
        'price' => 'Price',
        'category' => 'Category',
        'manufacturer' => 'Manufacturer',
        'product_specifications' => 'Product specifications',
        'product_description' => 'Product description',
        'warranty_duration' => 'Warranty duration',
        'UID' => 'UID',
        'quantity' => 'Quantity'
    ];
    foreach ($requiredFields as $field => $name) {
        if (empty($_POST[$field])) {
            $response['errors'][$field] = "$name is required";
        }
    }

    // Sanitize and validate fields
    $displayName = filter_var($_POST['product_display_name'] ?? '', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $price = filter_var($_POST['price'] ?? 0, FILTER_VALIDATE_FLOAT);
    $category = filter_var($_POST['category'] ?? '', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $manufacturer = filter_var($_POST['manufacturer'] ?? '', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $specs = filter_var($_POST['product_specifications'] ?? '', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $description = filter_var($_POST['product_description'] ?? '', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $warranty = filter_var($_POST['warranty_duration'] ?? '', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $uid = filter_var($_POST['UID'] ?? '', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $quantity = filter_var($_POST['quantity'] ?? 0, FILTER_VALIDATE_INT);
    $status = isset($_POST['status']) ? 0 : 1;
    $updatedBy = $_SESSION['firstname']; // Get the firstname from session

    $optionalFields = [
        'Form_factor' => 'Not_Applicable',
        'Socket_type' => 'Not_Applicable',
        'Ram_socket_type' => 'Not_Applicable'
    ];
    foreach ($optionalFields as $field => $default) {
        ${$field} = isset($_POST[$field]) ? filter_var($_POST[$field], FILTER_SANITIZE_FULL_SPECIAL_CHARS) : $default;
    }

    // Custom validation
    if ($price === false || $price < 300 || $price > 300000) {
        $response['errors']['price'] = 'Price must be between ₱300 and ₱300,000';
    }
    if (!preg_match('/^\d{6,15}$/', $uid)) {
        $response['errors']['UID'] = 'UID must be 6-15 digits';
    }
    if ($quantity === false || $quantity < 10 || $quantity > 100) {
        $response['errors']['quantity'] = 'Quantity must be 10-100 pieces';
    }

    // Handle image upload
    $uploadDir = "../uploads/";
    $webPath = "uploads/";
    $imagePath = null;

    if (isset($_FILES['immage']) && $_FILES['immage']['error'] === UPLOAD_ERR_OK) {
        $filename = basename($_FILES['immage']['name']);
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        $allowedExts = ['jpg', 'jpeg', 'png'];

        if (!in_array($ext, $allowedExts)) {
            $response['errors']['immage'] = 'Only JPG, JPEG, PNG allowed';
        } elseif ($_FILES['immage']['size'] > 5 * 1024 * 1024) {
            $response['errors']['immage'] = 'File size exceeds 5MB';
        } elseif (!getimagesize($_FILES['immage']['tmp_name'])) {
            $response['errors']['immage'] = 'Invalid image file';
        } else {
            $stmt = $conn->prepare("SELECT immage FROM products WHERE ID = ?");
            $stmt->bind_param("i", $productId);
            $stmt->execute();
            $oldImage = $stmt->get_result()->fetch_assoc()['immage'];
            $stmt->close();

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $uniqueName = 'product_' . $productId . '_' . uniqid() . '.' . $ext;
            $filePath = $uploadDir . $uniqueName;
            $imagePath = $webPath . $uniqueName;

            if (move_uploaded_file($_FILES['immage']['tmp_name'], $filePath)) {
                $response['image_url'] = $imagePath;
            } else {
                throw new Exception('Image upload failed');
            }
        }
    }

    // If validation failed, return errors
    if (!empty($response['errors'])) {
        $response['message'] = 'Validation failed';
        echo json_encode($response);
        exit;
    }

    // Begin transaction
    $conn->begin_transaction();

    try {
        $sql = "UPDATE products SET 
            product_display_name = ?, price = ?, category = ?, manufacturer = ?, 
            Form_factor = ?, Socket_type = ?, Ram_socket_type = ?, 
            product_specifications = ?, product_description = ?, warranty_duration = ?, 
            UID = ?, quantity = ?, status = ?, updated_at = NOW(), updated_by = ?";

        $params = [
            $displayName, $price, $category, $manufacturer,
            $Form_factor, $Socket_type, $Ram_socket_type,
            $specs, $description, $warranty,
            $uid, $quantity, $status, $updatedBy
        ];
        $types = 'sdssssssssiiis';

        if ($imagePath) {
            $sql .= ", immage = ?";
            $params[] = $imagePath;
            $types .= 's';
        }

        $sql .= " WHERE ID = ?";
        $params[] = $productId;
        $types .= 'i';

        $stmt = $conn->prepare($sql);
        $stmt->bind_param($types, ...$params);
        if (!$stmt->execute()) {
            throw new Exception('Database update failed: ' . $stmt->error);
        }

        // Delete old image if a new one was uploaded
        if ($imagePath && isset($oldImage) && file_exists("../" . $oldImage)) {
            unlink("../" . $oldImage);
        }

        $conn->commit();

        $response['success'] = true;
        $response['message'] = 'Product updated successfully';
        $response['product'] = [
            'ID' => $productId,
            'display_name' => $displayName,
            'price' => $price,
            'category' => $category,
            'manufacturer' => $manufacturer,
            'quantity' => $quantity,
            'status' => $status,
            'updated_by' => $updatedBy
        ];

    } catch (Exception $e) {
        $conn->rollback();
        if ($imagePath && file_exists("../" . $imagePath)) {
            unlink("../" . $imagePath);
        }
        throw $e;
    }

} catch (Exception $e) {
    http_response_code($e->getCode() ?: 500);
    $response['message'] = $e->getMessage();
}

echo json_encode($response);
exit;