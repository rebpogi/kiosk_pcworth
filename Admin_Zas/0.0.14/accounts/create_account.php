<?php
session_start();
require 'db.php';

// Check if user is logged in and is superadmin
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'superadmin') {
    header("Location: login.php");
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newUsername = trim($_POST['username']);
    $newPassword = trim($_POST['password']);
    $role = $_POST['role'];

    if (!empty($newUsername) && !empty($newPassword) && in_array($role, ['admin', 'superadmin'])) {
        $hashedPassword = hash('sha256', $newPassword);

        // Check if username already exists
        $checkSql = "SELECT id FROM admin_users WHERE username = ?";
        $checkStmt = $conn->prepare($checkSql);
        $checkStmt->bind_param("s", $newUsername);
        $checkStmt->execute();
        $checkStmt->store_result();

        if ($checkStmt->num_rows > 0) {
            $message = "Username already exists!";
        } else {
            $sql = "INSERT INTO admin_users (username, password, role) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $newUsername, $hashedPassword, $role);
            if ($stmt->execute()) {
                $message = "Account created successfully!";
            } else {
                $message = "Failed to create account.";
            }
        }
    } else {
        $message = "Please fill all fields correctly.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Create Account</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css">
</head>
<body>
  <div class="container mt-5">
    <h2>Create New Admin Account</h2>

    <?php if (isset($message)): ?>
      <div class="alert alert-info"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <form method="POST">
      <div class="mb-3">
        <label for="username" class="form-label">Username:</label>
        <input type="text" class="form-control" name="username" required>
      </div>

      <div class="mb-3">
        <label for="password" class="form-label">Password:</label>
        <input type="password" class="form-control" name="password" required>
      </div>

      <div class="mb-3">
        <label for="role" class="form-label">Role:</label>
        <select class="form-select" name="role" required>
          <option value="admin">Admin</option>
          <option value="superadmin">Superadmin</option>
        </select>
      </div>

      <button type="submit" class="btn btn-primary">Create Account</button>
      <a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
    </form>
  </div>
</body>
</html>
