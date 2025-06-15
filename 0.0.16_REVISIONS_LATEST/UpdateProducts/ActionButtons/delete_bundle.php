<?php
require_once 'DB_connect.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['id'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
    exit;
}

$bundleId = (int)$_POST['id'];

try {
    // Start transaction
    $conn->begin_transaction();

    // First delete bundle parts
    $deletePartsQuery = "DELETE FROM bundle_parts WHERE bundle_id = ?";
    $deletePartsStmt = $conn->prepare($deletePartsQuery);
    $deletePartsStmt->bind_param("i", $bundleId);
    
    if (!$deletePartsStmt->execute()) {
        throw new Exception('Failed to delete bundle parts');
    }

    // Then delete the bundle
    $deleteBundleQuery = "DELETE FROM bundles WHERE id = ?";
    $deleteBundleStmt = $conn->prepare($deleteBundleQuery);
    $deleteBundleStmt->bind_param("i", $bundleId);
    
    if (!$deleteBundleStmt->execute()) {
        throw new Exception('Failed to delete bundle');
    }

    // Commit transaction
    $conn->commit();
    
    echo json_encode(['success' => true, 'message' => 'Bundle deleted successfully']);
} catch (Exception $e) {
    $conn->rollback();
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

$conn->close();
?>