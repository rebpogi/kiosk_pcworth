<?php
session_start();
include('db.php');
if (!isset($_SESSION['id']) || !isset($_SESSION['role'])) {
    header("Location: loginpage.php");
    exit();
}

$id = $_SESSION['id'];
$role = $_SESSION['role'];

$sql = "SELECT * FROM admin_users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $userData = $result->fetch_assoc();
} else {
    $userData = null; // fallback
}

$superadminaccess = ($role === 'superadmin');
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard Template · Bootstrap</title>

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css"
    integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
    integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js"
    integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="acc.css">
  <script src="acc.js"></script>
</head>

<body>

  <nav class="navbar sticky-top shadow" style="width: 100%; background: #0C304A; font-size: 20px;">
  <span class="navbar-text px-3 text-white">PC WORTH ADMIN DASHBOARD</span>

  <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#logoutModal" style="margin-right: 10px;">
    <img src="uploads/logout_icon.png" width="48px" style="margin-right: 0px; background-color: red; padding: 5px; border-radius: 8px;" alt="Logout Icon">
  </button>
</nav>

<!-- Logout Confirmation Modal -->
<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="logoutModalLabel">Confirm Logout</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Are you sure you want to log out?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <a href="logout.php" class="btn btn-danger">Logout</a>
      </div>
    </div>
  </div>
</div>


  <div class="container-fluid">
    <div class="row">

      <!-- Sidebar -->
      <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
        <div class="position-sticky pt-3">
          <ul class="nav flex-column">
            <li class="nav-item">
              <button class="Dropdown-Btn" onclick="toggleDropdown(this)">Inventory</button>
              <div class="Dropdown-content" id="Inventory_Dropdown">
                <a href="#" onclick="animateClick(this); showForms('Products')">&#9733; Products</a>
                <a href="#" onclick="animateClick(this); showForms('Edit_Product_Information')">Edit Product Information</a>
                <a href="#" onclick="animateClick(this); showForms('Manage_Account')">Account Setting</a>
                <?php if ($superadminaccess): ?>
                <a href="#" onclick="animateClick(this); showForms('AccountCreation')">Create Account</a>
                <a href="#" onclick="animateClick(this); showForms('ViewAccounts')">Accounts</a>
                <?php endif; ?>
              </div>
            </li>
          </ul>
        </div>
      </nav>

          <!-- Account Settings -->
          <div id="ManageAccount" style="display: none;">
            <h1>Manage Account</h1>
            <form action="updateaccount.php" method="POST">
              <h2><?= htmlspecialchars($userData['firstname'] . ' ' . $userData['lastname']) ?></h2>
                 <p>First Name</p>
                  <input type="text" id="FirstName" name="FirstName" placeholder="First Name" value="<?= htmlspecialchars($userData['firstname']) ?>">

                  <p>Last Name</p>
                  <input type="text" id="LastName" name="LastName" placeholder="Last Name" value="<?= htmlspecialchars($userData['lastname']) ?>">

                  <p>Username</p>
                  <input type="text" id="Username" name="Username" placeholder="Username" value="<?= htmlspecialchars($userData['username']) ?>">
                 <p>Password</p>
                <div class="input-box">
                <input type="password" placeholder="password" id="password" name="Password" value="<?= htmlspecialchars($userData['password']) ?>" readonly>
                <img src="uploads/close_eye.png" id="eyeicon">
                <img src="uploads/edit_pen.png" id="editpen">
                </div>
                <div class="button-wrapper">
                  <button class="save_details" style="font-size: 32px;">Save Details</button>
                </div>
              </form> 

              <br>
              <h1>Permissions</h1>
            <form>
              <p>Products</p>
            <hr>
              <p>Edit_Product_Information</p>
            <hr>
              <p>Account_Creation</p>
              </form> 
          </div>
          <!-- Custom Prompt -->
          <div id="New_Details_Prompt" class="prompt-overlay">
            <div class="prompt-box">
              <p>Details Saved</p>
              <button onclick="close_Details_Prompt()">OK</button>
            </div>
          </div>

           <!-- Create Account -->
          <div id="CreateAccount" style="display: none;">
        <form action="create_admin.php" method="POST">
        <h2>Create New Admin Account</h2>
          <form method="POST">
          <label>First Name:</label><br>
          <input type="text" name="firstname" required><br>
        <label>Last Name:</label><br>
        <input type="text" name="lastname" required><br>
        <label>Username:</label><br>
        <input type="text" name="username" required><br>
        <label>Password:</label><br>
        <div class="input-box">
        <input type="password" name="password" required><br>
        <img src="uploads/close_eye.png" id="eyeicon">
        </div>
        <label>Role:</label><br>
          <select name="role" required>
          <option value="">Select Role</option>
          <option value="admin">Admin</option>
          <option value="superadmin">Superadmin</option>
          </select><br><br>
       <button class="save_details" style="font-size: 32px;">Create Admin</button>
         </form>
        </div>

        <!-- View Accounts -->
        <div id="Accounts" style="display: none;">
        <h2>Account List</h2>
        <?php
        include('db.php');

            if (!isset($_SESSION['id']) || !isset($_SESSION['role'])) {
           echo "<p>Unauthorized access.</p>";
            exit();
          }

        $role = $_SESSION['role'];
        $sql = "SELECT * FROM admin_users";
         $result = $conn->query($sql);

          if ($result && $result->num_rows > 0): ?>
              <div class="table-responsive">
                <table class="table table-bordered table-striped">
                  <thead class="thead-dark">
                    <tr>
                      <th>ID</th>
                      <th>Firstname</th>
                      <th>Lastname</th>
                      <th>Username</th>
                      <th>Password</th>
                      <th>Role</th>
                        <?php if ($role === 'superadmin'): ?>
                         <th>Actions</th>
                         <?php endif; ?>
                    </tr>
                  </thead>
                  <tbody>
                  <?php while ($row = $result->fetch_assoc()): ?>
                    <tr id="view-row-<?= $row['id'] ?>">
                      <td><?= htmlspecialchars($row['id']) ?></td>
                      <td><?= htmlspecialchars($row['firstname']) ?></td>
                      <td><?= htmlspecialchars($row['lastname']) ?></td>
                      <td><?= htmlspecialchars($row['username']) ?></td>
                      <td><?= htmlspecialchars($row['password']) ?></td>
                      <td><?= htmlspecialchars($row['role']) ?></td>
                      <?php if ($role === 'superadmin'): ?>
                        <td style="text-align: center;">
                          <button class="btn btn-sm btn-warning" onclick="showEditRow(<?= $row['id'] ?>)">Edit</button>

                          <button class="btn btn-sm btn-danger" style="border: none; box-shadow: none;" onclick="if (confirm('Are you sure you want to delete this account?')) { window.location.href = 'delete_account.php?id=<?= $row['id'] ?>'; }">Delete
                          </button>
                        </td>
                      <?php endif; ?>
                    </tr>

                    <!-- Hidden Edit Form Row -->
                    <tr id="edit-row-<?= $row['id'] ?>" style="display:none;">
                      <form action="updateaccount.php" method="POST">
                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                        <td><?= $row['id'] ?></td>
                        <td><input type="text" name="firstname" value="<?= htmlspecialchars($row['firstname']) ?>" class="form-control form-control-sm"></td>
                        <td><input type="text" name="lastname" value="<?= htmlspecialchars($row['lastname']) ?>" class="form-control form-control-sm"></td>
                        <td><input type="text" name="username" value="<?= htmlspecialchars($row['username']) ?>" class="form-control form-control-sm"></td>
                        <td><input type="text" name="password" value="<?= htmlspecialchars($row['password']) ?>" class="form-control form-control-sm"></td>
                        <td>
                          <select name="role" class="form-control form-control-sm">
                            <option value="admin" <?= $row['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                            <option value="superadmin" <?= $row['role'] === 'superadmin' ? 'selected' : '' ?>>Superadmin</option>
                          </select>
                        </td>
                        <td>
                          <button type="submit" class="btn btn-sm btn-success">Update</button>
                          <button type="button" class="btn btn-sm btn-secondary" onclick="hideEditRow(<?= $row['id'] ?>)">Cancel</button>
                        </td>
                      </form>
                    </tr>
                  <?php endwhile; ?>
                  </tbody>
                </table>
              </div>
            <?php else: ?>
              <p>No accounts found.</p>
            <?php endif; ?>
          </div>
        </div>
          

        </div>
      </main>
    </div>
  </div>



</body>

</html>
