<?php
session_start();
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');

include 'DB_connect.php';

// Initialize response array
$response = ['status' => 'error', 'message' => ''];

try {
    if (!isset($_SESSION['username'])) {
        throw new Exception('Not logged in');
    }

    $currentUsername = $_SESSION['username'];
    $newUsername = $_POST['newUsername'] ?? '';
    $newPassword = $_POST['newPassword'] ?? '';
    $confirmPassword = $_POST['confirmPassword'] ?? '';

    // Validation
    if (strlen($newUsername) < 7) {
        throw new Exception('Username must be at least 7 characters');
    }
    
    if (strlen($newPassword) < 7) {
        throw new Exception('Password must be at least 7 characters');
    }
    
    if ($newPassword !== $confirmPassword) {
        throw new Exception('Passwords do not match');
    }

    // REMOVED PASSWORD HASHING - STORING PLAIN TEXT
    $plainTextPassword = $newPassword;

    // Check if new username already exists
    $checkSql = "SELECT username FROM admin_users WHERE username = ?";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bind_param("s", $newUsername);
    $checkStmt->execute();
    $checkStmt->store_result();
    
    if ($checkStmt->num_rows > 0 && $newUsername !== $currentUsername) {
        throw new Exception('Username already exists');
    }
    $checkStmt->close();

    // Update user with plain text password
    $updateSql = "UPDATE admin_users SET username = ?, password = ? WHERE username = ?";
    $updateStmt = $conn->prepare($updateSql);
    
    if (!$updateStmt) {
        throw new Exception('Database error: ' . $conn->error);
    }

    $updateStmt->bind_param("sss", $newUsername, $plainTextPassword, $currentUsername);

    if ($updateStmt->execute()) {
        $_SESSION['username'] = $newUsername;
        $response = ['status' => 'success'];
    } else {
        throw new Exception('Update failed: ' . $updateStmt->error);
    }
    
    $updateStmt->close();
} catch (Exception $e) {
    $response['message'] = $e->getMessage();
} finally {
    if (isset($conn)) {
        $conn->close();
    }
    
    // Ensure proper JSON output
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
    exit();
}