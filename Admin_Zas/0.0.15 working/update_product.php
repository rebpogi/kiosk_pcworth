<?php
$conn = new mysqli('localhost', 'zas', 'group4', 'testing_backend');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ID'])) {
    $id = intval($_POST['ID']);
    $name = $_POST['product_display_name'];
    $price = floatval($_POST['price']);
    $quantity = intval($_POST['quantity']);
    $uid = $_POST['UID'];
    $category = $_POST['category'];
    $manufacturer = $_POST['manufacturer'];
    $formFactor = $_POST['Form_factor'] ?? '';
    $socketType = $_POST['Socket_type'] ?? ''; 
    $ramSocketType = $_POST['Ram_socket_type'];
    $specs = $_POST['product_specifications'];
    $description = $_POST['product_description'];
    $status = isset($_POST['status']) ? '0' : '1';
    $warranty = $_POST['warranty_duration'];

    $imagePath = $_POST['current_image'] ?? '';  // fallback to old image path

    // Check if a new image was uploaded
    if (isset($_FILES['new_immage']) && $_FILES['new_immage']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $fileTmp = $_FILES['new_immage']['tmp_name'];
        $fileName = basename($_FILES['new_immage']['name']);
        $ext = pathinfo($fileName, PATHINFO_EXTENSION);
        $allowed = ['jpg', 'jpeg', 'png'];

        if (in_array(strtolower($ext), $allowed)) {
            $newName = uniqid("img_") . "." . $ext;
            $imagePath = $uploadDir . $newName;

            if (!move_uploaded_file($fileTmp, $imagePath)) {
                die("Failed to move uploaded file.");
            }
        } else {
            die("Invalid file type.");
        }

        // Prepare update query INCLUDING immage field
        $stmt = $conn->prepare("UPDATE products SET 
            product_display_name = ?, 
            price = ?, 
            quantity = ?, 
            UID = ?, 
            category = ?, 
            manufacturer = ?, 
            Form_factor = ?, 
            Socket_type = ?, 
            Ram_socket_type = ?,
            product_specifications = ?, 
            product_description = ?, 
            status = ?, 
            immage = ?, 
            warranty_duration = ?, 
            updated_at = NOW()
            WHERE ID = ?");
        
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }

        $stmt->bind_param("sdisssssssssssi",
            $name, $price, $quantity, $uid, $category, $manufacturer, $formFactor, $socketType, $ramSocketType,
            $specs, $description, $status, $imagePath, $warranty, $id
        );

    } else {
        // No new image uploaded - prepare update query WITHOUT immage field
        $stmt = $conn->prepare("UPDATE products SET 
            product_display_name = ?, 
            price = ?, 
            quantity = ?, 
            UID = ?, 
            category = ?, 
            manufacturer = ?, 
            Form_factor = ?, 
            Socket_type = ?, 
            Ram_socket_type = ?,
            product_specifications = ?, 
            product_description = ?, 
            status = ?, 
            warranty_duration = ?, 
            updated_at = NOW()
            WHERE ID = ?");

        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }

        $stmt->bind_param("sdissssssssssi",
            $name, $price, $quantity, $uid, $category, $manufacturer, $formFactor, $socketType, $ramSocketType,
            $specs, $description, $status, $warranty, $id
        );
    }

    if ($stmt->execute()) {
        echo "<p style='color: green'>Product updated successfully!</p>";
    } else {
        echo "<p style='color: red'>Update failed: " . $stmt->error . "</p>";
    }

    $stmt->close();
}

$conn->close();
?>
