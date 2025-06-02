<?php
session_start();
require 'db.php';

if ($_SESSION['role'] !== 'superadmin') {
   echo "<p style='color:red;'>Access Denied</p>";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fname = $_POST['firstname'];
    $lname = $_POST['lastname'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role']; // New role field

    $stmt = $conn->prepare("INSERT INTO admin_users (firstname, lastname, username, password, role) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $fname, $lname, $username, $password, $role);

    if ($stmt->execute()) {
        header("Location: dashboard.php");
    } else {
        $error = "Error: " . $stmt->error;
    }
}
?>
