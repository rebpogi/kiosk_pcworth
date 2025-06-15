<?php
require_once 'DB_connect.php';

header('Content-Type: application/json');

if (!isset($_GET['id'])) {
    echo json_encode(['error' => 'Bundle ID not provided']);
    exit;
}

$bundleId = (int)$_GET['id'];
$query = "SELECT * FROM bundles WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $bundleId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(['error' => 'Bundle not found']);
    exit;
}

$bundle = $result->fetch_assoc();

// Fetch bundle parts if needed
$partsQuery = "SELECT * FROM bundle_parts WHERE bundle_id = ?";
$partsStmt = $conn->prepare($partsQuery);
$partsStmt->bind_param("i", $bundleId);
$partsStmt->execute();
$partsResult = $partsStmt->get_result();

$bundleParts = [];
while ($row = $partsResult->fetch_assoc()) {
    $bundleParts[$row['category']] = $row;
}

$bundle['parts'] = $bundleParts;

echo json_encode($bundle);
$stmt->close();
$conn->close();
?>