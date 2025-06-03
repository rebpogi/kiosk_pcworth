<?php
include('db.php');
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'superadmin') {
    echo "Access denied.";
    exit();
}

if (isset($_POST['id']) && isset($_POST['new_role'])) {
    $id = $_POST['id'];
    $newRole = $_POST['new_role'];

    // Prevent role from being set to something invalid
    if ($newRole !== 'admin' && $newRole !== 'superadmin') {
        echo "Invalid role.";
        exit();
    }

    $stmt = $conn->prepare("UPDATE admin_users SET role = ? WHERE id = ?");
    $stmt->bind_param("si", $newRole, $id);

    if ($stmt->execute()) {
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Failed to update role.";
    }
} else {
    echo "Missing parameters.";
}
?>
