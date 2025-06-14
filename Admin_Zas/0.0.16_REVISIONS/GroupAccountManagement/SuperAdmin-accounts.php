<?php
session_start();
include 'DB_connect.php';

// // Check if user is logged in and has admin privileges
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
    </style>
</head>
<body>
    <div id="admin-users-page">
        <h2>Admin Users Management</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT id, firstname, lastname, username, role FROM admin_users";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['firstname']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['lastname']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['role']) . "</td>";
                        echo "<td>
                                <button class='action-btn edit-btn' onclick='editUser(" . $row['id'] . ")'>Edit</button>
                                <button class='action-btn delete-btn' onclick='deleteUser(" . $row['id'] . ")'>Delete</button>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No admin users found</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
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
    </script>
</body>
</html>
