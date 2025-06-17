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

    // Check if username exists
    $stmt = $conn->prepare("SELECT id FROM admin_users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo json_encode(['success' => false, 'field' => 'username', 'error' => 'Username already exists.']);
        $stmt->close();
        $conn->close();
        exit;
    }

    // Insert into DB
    $insert = $conn->prepare("INSERT INTO admin_users (firstname, lastname, username, password, role) VALUES (?, ?, ?, ?, ?)");
    $insert->bind_param("sssss", $firstname, $lastname, $username, $password, $role);

    if ($insert->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Error creating account: ' . $conn->error]);
    }

    $insert->close();
    $stmt->close();
    $conn->close();
    exit;
}
?>
