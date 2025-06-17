<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include 'DB_connect.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'superadmin') {
    header("Location: ../login.php");
    exit();
}

$sql = "SELECT id, firstname, lastname, username, password, role FROM admin_users";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Super Admin Accounts</title>
    <style>
        #admin-users-page table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        #admin-users-page th, 
        #admin-users-page td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        #admin-users-page th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        #admin-users-page tr:hover {
            background-color: #f5f5f5;
        }

        #admin-users-page .action-btn {
            padding: 6px 12px;
            margin: 0 3px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        #admin-users-page .edit-btn {
            background-color: #4CAF50;
            color: white;
        }

        #admin-users-page .delete-btn {
            background-color: #f44336;
            color: white;
        }

        /* Edit form styled like the table */
        #edit-form-container {
            margin: 20px 0;
        }

        #edit-form-container table {
            width: 100%;
            border-collapse: collapse;
        }

        #edit-form-container td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }

        #edit-form-container input,
        #edit-form-container select {
            width: 95%;
            padding: 6px;
            box-sizing: border-box;
        }

        #edit-form-container .form-buttons {
            padding: 12px;
        }

        #edit-form-container button {
            padding: 6px 12px;
            margin-right: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        #edit-form-container button[type="submit"] {
            background-color: #4CAF50;
            color: white;
        }

        #edit-form-container button#cancel-edit {
            background-color: #6c757d;
            color: white;
        }

        .error-message {
            color: red;
            font-size: 0.85em;
        }
    </style>
</head>
<body>

<div id="admin-users-page">

    <h2>Admin Users Management</h2>

    <!-- Edit form will appear here -->
    <div id="edit-form-container" style="display: none;">
    <h3>Edit Admin User</h3>
    <form id="edit-user-form">
        <input type="hidden" name="id">

        <div class="form-row">
            <label>Firstname:</label>
            <input type="text" name="firstname" required>
        </div>

        <div class="form-row">
            <label>Lastname:</label>
            <input type="text" name="lastname" required>
        </div>

        <div class="form-row">
            <label>Username:</label>
            <input type="text" name="username" required>
        </div>
        <span id="username-error" class="error-message"></span>

        <div class="form-row">
            <label>Password:</label>
            <input type="text" name="password" required>
        </div>
        <span id="password-error" class="error-message"></span>

        <div class="form-row">
            <label>Role:</label>
            <select name="role" required>
                <option value="admin">Admin</option>
                <option value="user">User</option>
                <option value="superadmin">Superadmin</option>
            </select>
        </div>

        <div class="form-row" style="grid-column: 1 / span 2; text-align: right;">
            <button type="submit">Save</button>
            <button type="button" id="cancel-edit">Cancel</button>
        </div>
    </form>
</div>


    <!-- The table -->
    <div id="table-container">
        <h3>Current Admin Accounts</h3>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Firstname</th>
                    <th>Lastname</th>
                    <th>Username</th>
                    <th>Password</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr data-id="<?= $row['id'] ?>">
                            <td><?= htmlspecialchars($row['id']) ?></td>
                            <td><?= htmlspecialchars($row['firstname']) ?></td>
                            <td><?= htmlspecialchars($row['lastname']) ?></td>
                            <td><?= htmlspecialchars($row['username']) ?></td>
                            <td><?= htmlspecialchars($row['password']) ?></td>
                            <td><?= htmlspecialchars($row['role']) ?></td>
                            <td>
                                <button class='action-btn edit-btn'>Edit</button>
                                <button class="action-btn delete-btn">Delete</button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="7" style="text-align: center;">No accounts found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="SuperAdmin-accounts.js"></script>
</body>
</html>
