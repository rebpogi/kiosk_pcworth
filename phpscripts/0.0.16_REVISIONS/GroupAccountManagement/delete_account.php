<?php
session_start();
include 'DB_connect.php';

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['id'])) {
    $stmt = $conn->prepare("DELETE FROM admin_users WHERE id = ?");
    $stmt->bind_param("i", $data['id']);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Delete failed.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid input.']);
}
?>
