<?php
session_start();
include('db.php');

if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'superadmin') {
    echo "Unauthorized access.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);

    // Optional: Prevent deleting yourself or other critical accounts

    $sql = "DELETE FROM admin_users WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        header("Location: your_account_page.php?msg=delete_success");
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
} else {
    echo "Invalid request method.";
}
?>