<?php
session_start();
include('db.php');

if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'superadmin') {
    echo "Unauthorized access.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $firstname = $conn->real_escape_string($_POST['firstname']);
    $lastname = $conn->real_escape_string($_POST['lastname']);
    $username = $conn->real_escape_string($_POST['username']);
    $password = $conn->real_escape_string($_POST['password']);
    $role = $conn->real_escape_string($_POST['role']);

    // Optional: Add validation here (e.g. username uniqueness)

    $sql = "UPDATE admin_users SET 
                firstname='$firstname', 
                lastname='$lastname', 
                username='$username', 
                password='$password', 
                role='$role' 
            WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
} else {
    echo "Invalid request method.";
}
?>