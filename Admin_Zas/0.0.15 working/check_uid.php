<?php
// check_uid.php
header('Content-Type: application/json');
include 'DB_connect.php';

$response = ['exists' => false];

if (!isset($_GET['uid']) || empty(trim($_GET['uid']))) {
    echo json_encode(['error' => 'No UID provided']);
    exit;
}

$uid = trim($_GET['uid']);

try {
    $stmt = $conn->prepare("SELECT COUNT(*) as count FROM products WHERE UID = ?");
    $stmt->bind_param("s", $uid);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    
    $response['exists'] = $result['count'] > 0;
} catch (Exception $e) {
    $response['error'] = 'Database error';
}

echo json_encode($response);
?>