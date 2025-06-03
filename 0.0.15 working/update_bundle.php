<?php
require_once 'DB_connect.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get bundle ID (required for update)
    $bundle_id = intval($_POST['bundle_id']);
    if (!$bundle_id) {
        $errors['bundle_id'] = "Invalid bundle ID.";
    }

    // Sanitize inputs
    $bundle_display_name = trim($_POST['bundle_display_name']);
    $bundle_quantity = intval($_POST['bundle_quantity']);
    $bundle_uid = trim($_POST['bundle_uid']); // Keep as string for UID validation
    $bundle_price = floatval($_POST['bundle_price']);
    $bundle_description = trim($_POST['bundle_description']);
    $status = isset($_POST['status']) ? 1 : 0;

    // Validate required fields
    if (empty($bundle_display_name)) {
        $errors['bundle_display_name'] = "Bundle name is required.";
    }
    if (empty($bundle_uid)) {
        $errors['bundle_uid'] = "UID is required.";
    }

    // Handle image upload (optional)
    $imagePath = null;
    if (isset($_FILES['bundle_image']) && $_FILES['bundle_image']['error'] === UPLOAD_ERR_OK) {
        $targetDir = 'uploads/bundles/';
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }
        $fileTmp = $_FILES['bundle_image']['tmp_name'];
        $fileName = basename($_FILES['bundle_image']['name']);
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowedExts = ['jpg', 'jpeg', 'png'];
        if (!in_array($fileExt, $allowedExts)) {
            $errors['bundle_image'] = "Invalid image format. Allowed: jpg, jpeg, png.";
        } else {
            $newFileName = uniqid('bundle_', true) . '.' . $fileExt;
            $targetPath = $targetDir . $newFileName;

            if (move_uploaded_file($fileTmp, $targetPath)) {
                $imagePath = $targetPath;
            } else {
                $errors['bundle_image'] = "Image upload failed.";
            }
        }
    }

    if (empty($errors)) {
        // Update bundles table
        if ($imagePath) {
            // Update with new image
            $stmt = $conn->prepare("UPDATE bundles SET bundle_display_name=?, bundle_quantity=?, bundle_uid=?, bundle_price=?, bundle_description=?, status=?, bundle_image=?, updated_at=NOW() WHERE id=?");
            $stmt->bind_param("siidsisi", $bundle_display_name, $bundle_quantity, $bundle_uid, $bundle_price, $bundle_description, $status, $imagePath, $bundle_id);
        } else {
            // Update without changing image
            $stmt = $conn->prepare("UPDATE bundles SET bundle_display_name=?, bundle_quantity=?, bundle_uid=?, bundle_price=?, bundle_description=?, status=?, updated_at=NOW() WHERE id=?");
            $stmt->bind_param("siidsii", $bundle_display_name, $bundle_quantity, $bundle_uid, $bundle_price, $bundle_description, $status, $bundle_id);
        }

        if ($stmt->execute()) {
            // Delete old parts for this bundle first
            $stmtDel = $conn->prepare("DELETE FROM bundle_parts WHERE bundle_id=?");
            $stmtDel->bind_param("i", $bundle_id);
            $stmtDel->execute();

            // Insert updated parts
            $part_fields = ['category', 'uid', 'name', 'qty', 'price'];
            foreach ($_POST as $key => $val) {
                if (strpos($key, 'part_') === 0 && strpos($key, '_uid') !== false) {
                    $category = explode('_', $key)[1];
                    $part_data = [];
                    foreach ($part_fields as $field) {
                        $field_key = "part_{$category}_{$field}";
                        $part_data[$field] = $_POST[$field_key] ?? '';
                    }

                    // Validate part quantity and price before inserting
                    $part_qty = intval($part_data['qty']);
                    $part_price = floatval($part_data['price']);
                    if ($part_qty > 0 && $part_price >= 0) {
                        $stmtPart = $conn->prepare("INSERT INTO bundle_parts (bundle_id, part_uid, part_name, category, quantity, unit_price, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())");
                        $stmtPart->bind_param("iissid", $bundle_id, $part_data['uid'], $part_data['name'], $category, $part_qty, $part_price);
                        $stmtPart->execute();
                    }
                }
            }

            header("Location: admin.php?update_success=1");
            exit();
        } else {
            $errors['bundle'] = "Failed to update bundle.";
        }
    }
}

if (!empty($errors)) {
    echo "<h2>Error updating bundle:</h2>";
    foreach ($errors as $err) {
        echo "<p style='color:red;'>$err</p>";
    }
    echo '<p><a href="javascript:history.back()">Go Back</a></p>';
}
?>
