<?php
require_once 'DB_connect.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['id'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
    exit;
}

$bundleId = (int)$_POST['id'];

try {
    // First get current status
    $query = "SELECT status FROM bundles WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $bundleId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        throw new Exception('Bundle not found');
    }
    
    $bundle = $result->fetch_assoc();
    $newStatus = $bundle['status'] ? 0 : 1;
    
    // Update status
    $updateQuery = "UPDATE bundles SET status = ? WHERE id = ?";
    $updateStmt = $conn->prepare($updateQuery);
    $updateStmt->bind_param("ii", $newStatus, $bundleId);
    
    if (!$updateStmt->execute()) {
        throw new Exception('Failed to update status');
    }
    
    echo json_encode([
        'success' => true,
        'message' => 'Status updated successfully',
        'newStatus' => $newStatus
    ]);
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

$conn->close();
?>