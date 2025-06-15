<?php
require_once 'DB_connect.php';

header('Content-Type: application/json');

try {
    $bundleId = isset($_POST['bundle_id']) ? (int)$_POST['bundle_id'] : null;
    
    // Validate required fields
    $required = ['bundle_display_name', 'bundle_quantity', 'bundle_uid', 'bundle_price', 'bundle_description'];
    foreach ($required as $field) {
        if (empty($_POST[$field])) {
            throw new Exception("Missing required field: $field");
        }
    }

    // Handle file upload
    $imagePath = null;
    if (isset($_FILES['bundle_image']) && $_FILES['bundle_image']['error'] === UPLOAD_ERR_OK) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
        $fileType = $_FILES['bundle_image']['type'];
        
        if (!in_array($fileType, $allowedTypes)) {
            throw new Exception('Only JPG, JPEG, and PNG files are allowed.');
        }
        
        if ($_FILES['bundle_image']['size'] > 20 * 1024 * 1024) {
            throw new Exception('Image must be 20MB or smaller.');
        }
        
        $uploadDir = 'uploads/bundles/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        $extension = pathinfo($_FILES['bundle_image']['name'], PATHINFO_EXTENSION);
        $filename = uniqid() . '.' . $extension;
        $destination = $uploadDir . $filename;
        
        if (!move_uploaded_file($_FILES['bundle_image']['tmp_name'], $destination)) {
            throw new Exception('Failed to upload image.');
        }
        
        $imagePath = $destination;
    }

    // Prepare bundle data
    $bundleData = [
        'display_name' => $_POST['bundle_display_name'],
        'quantity' => (int)$_POST['bundle_quantity'],
        'uid' => $_POST['bundle_uid'],
        'price' => (float)$_POST['bundle_price'],
        'description' => $_POST['bundle_description'],
        'status' => isset($_POST['status']) ? (int)$_POST['status'] : 1,
        'image' => $imagePath
    ];

    if ($bundleId) {
        // Update existing bundle
        if ($imagePath) {
            $query = "UPDATE bundles SET 
                      bundle_display_name = ?, bundle_quantity = ?, bundle_uid = ?, 
                      bundle_price = ?, bundle_description = ?, status = ?, bundle_image = ?
                      WHERE id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("sisdsisi", 
                $bundleData['display_name'], $bundleData['quantity'], $bundleData['uid'],
                $bundleData['price'], $bundleData['description'], $bundleData['status'],
                $bundleData['image'], $bundleId
            );
        } else {
            $query = "UPDATE bundles SET 
                      bundle_display_name = ?, bundle_quantity = ?, bundle_uid = ?, 
                      bundle_price = ?, bundle_description = ?, status = ?
                      WHERE id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("sisdsii", 
                $bundleData['display_name'], $bundleData['quantity'], $bundleData['uid'],
                $bundleData['price'], $bundleData['description'], $bundleData['status'],
                $bundleId
            );
        }
    } else {
        // Create new bundle
        if (!$imagePath) {
            throw new Exception('Image is required for new bundles');
        }
        
        $query = "INSERT INTO bundles 
                  (bundle_display_name, bundle_quantity, bundle_uid, bundle_price, 
                   bundle_description, status, bundle_image, created_at)
                  VALUES (?, ?, ?, ?, ?, ?, ?, NOW())";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sisdsis", 
            $bundleData['display_name'], $bundleData['quantity'], $bundleData['uid'],
            $bundleData['price'], $bundleData['description'], $bundleData['status'],
            $bundleData['image']
        );
    }

    if (!$stmt->execute()) {
        throw new Exception('Failed to save bundle: ' . $stmt->error);
    }

    $newBundleId = $bundleId ?: $conn->insert_id;

    // Handle bundle parts
    $categories = ["CPU", "GPU", "Motherboard", "RAM", "HDD", "SSD", "CPU Cooler", 
                   "Power Supply", "Case", "Case Fanns", "Monitor", "Mouse", "Keyboard"];

    // First delete existing parts if updating
    if ($bundleId) {
        $deleteQuery = "DELETE FROM bundle_parts WHERE bundle_id = ?";
        $deleteStmt = $conn->prepare($deleteQuery);
        $deleteStmt->bind_param("i", $bundleId);
        $deleteStmt->execute();
        $deleteStmt->close();
    }

    // Insert new parts
    foreach ($categories as $category) {
        $uidField = "part_{$category}_uid";
        $qtyField = "part_{$category}_qty";
        
        if (!empty($_POST[$uidField])) {
            $partUid = $_POST[$uidField];
            $quantity = (int)($_POST[$qtyField] ?? 0);
            
            if ($quantity > 0) {
                $insertQuery = "INSERT INTO bundle_parts 
                                (bundle_id, category, part_uid, quantity)
                                VALUES (?, ?, ?, ?)";
                $insertStmt = $conn->prepare($insertQuery);
                $insertStmt->bind_param("issi", $newBundleId, $category, $partUid, $quantity);
                $insertStmt->execute();
                $insertStmt->close();
            }
        }
    }

    echo json_encode(['success' => true, 'message' => 'Bundle saved successfully']);
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

$conn->close();
?>