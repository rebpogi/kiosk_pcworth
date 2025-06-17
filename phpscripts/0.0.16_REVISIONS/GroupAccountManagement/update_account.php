<?php
header('Content-Type: application/json'); // So JS can expect JSON

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $host = "localhost";
    $user = "zas";
    $pass = "group4";
    $db = "testing_backend";

    $conn = new mysqli($host, $user, $pass, $db);

    if ($conn->connect_error) {
        echo json_encode(['success' => false, 'error' => 'Connection failed: ' . $conn->connect_error]);
        exit;
    }

    $id = intval($_POST['id']);
    $firstname = trim($_POST['firstname']);
    $lastname = trim($_POST['lastname']);
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $role = trim($_POST['role']);

    if ($role !== 'admin' && $role !== 'superadmin') {
        $role = 'admin';
    }

    // Password length validation
    if (strlen($password) < 6) {
        echo json_encode(['success' => false, 'field' => 'password', 'error' => 'Password must be at least 6 characters.']);
        $conn->close();
        exit;
    }

    // Check if username exists for another user
    $stmt = $conn->prepare("SELECT id FROM admin_users WHERE username = ? AND id != ?");
    $stmt->bind_param("si", $username, $id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo json_encode(['success' => false, 'field' => 'username', 'error' => 'Username already exists.']);
        $stmt->close();
        $conn->close();
        exit;
    }

    $stmt->close();

    // Update DB
    $update = $conn->prepare("UPDATE admin_users SET firstname = ?, lastname = ?, username = ?, password = ?, role = ? WHERE id = ?");
    $update->bind_param("sssssi", $firstname, $lastname, $username, $password, $role, $id);

    if ($update->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Error updating account: ' . $conn->error]);
    }

    $update->close();
    $conn->close();
    exit;
}
?>
