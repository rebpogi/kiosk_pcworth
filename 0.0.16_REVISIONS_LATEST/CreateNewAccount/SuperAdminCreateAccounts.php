<?php
session_start();
include 'DB_connect.php';
// Uncomment below for access control
// if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'superadmin') {
//     header("Location: login.php");
//     exit();
// }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Users Management</title>
    <style>
        #admin-users-page {
            font-family: Arial, sans-serif;
            padding: 20px;
        }

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

        #admin-users-page form {
            margin-top: 30px;
            background: #f9f9f9;
            padding: 20px;
            border-radius: 6px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            max-width: 400px;
        }

        #admin-users-page form div {
            margin-bottom: 15px;
        }

        #admin-users-page label {
            display: block;
            margin-bottom: 6px;
            font-weight: bold;
        }

        #admin-users-page input,
        #admin-users-page select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        #admin-users-page .save-btn {
            background-color: #2196F3;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
        }

        #admin-users-page .error {
            color: red;
            font-size: 0.9em;
        }
    </style>
</head>
<body>
    <div id="admin-users-page">
        <h2>Admin Users Management</h2>

        <h3>Create New Admin Account</h3>
        <form onsubmit="return validateForm()">
            <div>
                <label for="firstname">First Name</label>
                <input type="text" id="firstname" name="firstname" required>
                <div class="error" id="firstnameError"></div>
            </div>

            <div>
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
                <div class="error" id="usernameError"></div>
            </div>

            <div>
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
                <div class="error" id="passwordError"></div>
            </div>

            <div>
                <label for="role">Role</label>
                <select id="role" name="role" required>
                    <option value="">Select Role</option>
                    <option value="admin">admin</option>
                    <option value="superadmin">superadmin</option>
                </select>
            </div>

            <button type="submit" class="save-btn">Save</button>
        </form>
    </div>

    <script>
        function editUser(id) {
            window.location.href = 'edit_user.php?id=' + id;
        }

        function deleteUser(id) {
            if (confirm('Are you sure you want to delete this user?')) {
                window.location.href = 'delete_user.php?id=' + id;
            }
        }

        function validateForm() {
            let isValid = true;

            const firstname = document.getElementById('firstname');
            const username = document.getElementById('username');
            const password = document.getElementById('password');

            document.getElementById('firstnameError').innerText = '';
            document.getElementById('usernameError').innerText = '';
            document.getElementById('passwordError').innerText = '';

            if (firstname.value.trim().length < 8) {
                document.getElementById('firstnameError').innerText = 'First name must be at least 8 characters.';
                isValid = false;
            }

            if (username.value.trim().length < 8) {
                document.getElementById('usernameError').innerText = 'Username must be at least 8 characters.';
                isValid = false;
            }

            if (password.value.trim().length < 8) {
                document.getElementById('passwordError').innerText = 'Password must be at least 8 characters.';
                isValid = false;
            }

            return isValid;
        }
    </script>
</body>
</html>
