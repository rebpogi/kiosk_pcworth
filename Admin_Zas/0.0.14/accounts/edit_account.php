<?php
include('db.php');
session_start();

if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'superadmin') {
    echo "Unauthorized access.";
    exit();
}

if (!isset($_GET['id'])) {
    echo "No account ID provided.";
    exit();
}

$id = $_GET['id'];
$query = "SELECT * FROM admin_users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$account = $result->fetch_assoc();

if (!$account) {
    echo "Account not found.";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Account</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="container mt-5">
    <h2>Edit Account</h2>
    <form method="POST" action="update_account.php">
        <input type="hidden" name="id" value="<?= $account['id'] ?>">

        <div class="form-group">
            <label>Firstname:</label>
            <input type="text" name="firstname" class="form-control" value="<?= htmlspecialchars($account['firstname']) ?>" required>
        </div>

        <div class="form-group">
            <label>Lastname:</label>
            <input type="text" name="lastname" class="form-control" value="<?= htmlspecialchars($account['lastname']) ?>" required>
        </div>

        <div class="form-group">
            <label>Username:</label>
            <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($account['username']) ?>" required>
        </div>

        <div class="form-group">
            <label>Password:</label>
            <input type="text" name="password" class="form-control" value="<?= htmlspecialchars($account['password']) ?>" required>
        </div>

        <div class="form-group">
            <label>Role:</label>
            <select name="role" class="form-control">
                <option value="admin" <?= $account['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                <option value="superadmin" <?= $account['role'] === 'superadmin' ? 'selected' : '' ?>>Superadmin</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Save Changes</button>
        <a href="dashboard.php" class="btn btn-secondary">Cancel</a>
    </form>
</body>
</html>
