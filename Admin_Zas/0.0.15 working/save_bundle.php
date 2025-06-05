<?php
require_once 'DB_connect.php';

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Sanitize and fetch inputs
        $bundle_id = isset($_POST['bundle_id']) ? intval($_POST['bundle_id']) : null;
        $bundle_display_name = trim($_POST['bundle_display_name']);
        $bundle_quantity = intval($_POST['bundle_quantity']);
        $bundle_uid = intval($_POST['bundle_uid']);
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

        // Handle image upload
        $imagePath = null;
        $isNewImage = isset($_FILES['bundle_image']) && $_FILES['bundle_image']['error'] === UPLOAD_ERR_OK;

        if ($isNewImage) {
            // Process new image upload
            $targetDir = 'uploads/bundles/';
            if (!file_exists($targetDir)) {
                mkdir($targetDir, 0777, true);
            }
            
            $fileTmp = $_FILES['bundle_image']['tmp_name'];
            $fileName = basename($_FILES['bundle_image']['name']);
            $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            $newFileName = uniqid('bundle_', true) . '.' . $fileExt;
            $targetPath = $targetDir . $newFileName;

            if (move_uploaded_file($fileTmp, $targetPath)) {
                $imagePath = $targetPath;
            } else {
                $errors['bundle_image'] = "Image upload failed.";
            }
        }

        // For updates, get existing image if no new one uploaded
        if (!$isNewImage && $bundle_id) {
            $stmt = $conn->prepare("SELECT bundle_image FROM bundles WHERE id = ?");
            $stmt->bind_param("i", $bundle_id);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($row = $result->fetch_assoc()) {
                $imagePath = $row['bundle_image'];
            }
        }

        // Only require image for new bundles
        if (!$bundle_id && !$imagePath) {
            $errors['bundle_image'] = "Image is required for new bundles.";
        }

        if (empty($errors)) {
            // Start transaction
            $conn->begin_transaction();

            if ($bundle_id) {
                // UPDATE existing bundle
                $sql = "UPDATE bundles SET 
                        bundle_display_name = ?,
                        bundle_quantity = ?,
                        bundle_uid = ?,
                        bundle_price = ?,
                        bundle_description = ?,
                        status = ?";

                $params = [$bundle_display_name, $bundle_quantity, $bundle_uid, 
                          $bundle_price, $bundle_description, $status];
                $types = "siidsi";

                // Only include image in update if a new one was uploaded
                if ($isNewImage) {
                    $sql .= ", bundle_image = ?";
                    $params[] = $imagePath;
                    $types .= "s";
                }

                $sql .= " WHERE id = ?";
                $params[] = $bundle_id;
                $types .= "i";

                $stmt = $conn->prepare($sql);
                if (!$stmt) {
                    throw new Exception("Prepare failed: " . $conn->error);
                }

                $stmt->bind_param($types, ...$params);
                if (!$stmt->execute()) {
                    throw new Exception("Execute failed: " . $stmt->error);
                }

                // Delete existing parts
                $stmt = $conn->prepare("DELETE FROM bundle_parts WHERE bundle_id = ?");
                if (!$stmt) {
                    throw new Exception("Prepare failed: " . $conn->error);
                }
                $stmt->bind_param("i", $bundle_id);
                if (!$stmt->execute()) {
                    throw new Exception("Execute failed: " . $stmt->error);
                }

            } else {
                // INSERT new bundle
                $stmt = $conn->prepare("INSERT INTO bundles (bundle_display_name, bundle_quantity, bundle_uid, bundle_price, bundle_description, status, bundle_image, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");
                if (!$stmt) {
                    throw new Exception("Prepare failed: " . $conn->error);
                }
                $stmt->bind_param("siidsis", $bundle_display_name, $bundle_quantity, $bundle_uid, $bundle_price, $bundle_description, $status, $imagePath);
                
                if (!$stmt->execute()) {
                    throw new Exception("Execute failed: " . $stmt->error);
                }
                $bundle_id = $stmt->insert_id;
            }

            // Process parts
            foreach ($_POST as $key => $val) {
                if (strpos($key, 'part_') === 0 && strpos($key, '_uid') !== false) {
                    $category = explode('_', $key)[1];
                    
                    $part_uid = $_POST["part_{$category}_uid"];
                    $part_name = $_POST["part_{$category}_name"];
                    $part_qty = $_POST["part_{$category}_qty"];
                    $part_price = $_POST["part_{$category}_price"];

                    $stmtPart = $conn->prepare("INSERT INTO bundle_parts (bundle_id, part_uid, part_name, category, quantity, unit_price, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())");
                    if (!$stmtPart) {
                        throw new Exception("Prepare failed: " . $conn->error);
                    }
                    $stmtPart->bind_param("iissid", $bundle_id, $part_uid, $part_name, $category, $part_qty, $part_price);
                    if (!$stmtPart->execute()) {
                        throw new Exception("Execute failed: " . $stmtPart->error);
                    }
                }
            }

            // Commit transaction
            $conn->commit();

            // Redirect on success
            header("Location: admin.php?success=1");
            exit();
        }
    } catch (Exception $e) {
        // Rollback transaction on error
        $conn->rollback();
        $errors['database'] = "Database error: " . $e->getMessage();
    }
}

// If we get here, either GET request or an error occurred
echo "<h2>Bundle Save/Update Status:</h2>";
if (!empty($errors)) {
    echo "<div style='color:red;'>";
    foreach ($errors as $type => $message) {
        echo "<p><strong>$type:</strong> $message</p>";
    }
    echo "</div>";
} else {
    echo "<p style='color:green;'>No errors occurred, but no action was taken.</p>";
}
echo '<p><a href="javascript:history.back()">Go Back</a></p>';
?>
