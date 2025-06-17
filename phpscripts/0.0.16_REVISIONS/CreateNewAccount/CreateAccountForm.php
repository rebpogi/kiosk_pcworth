<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Users Management</title>
  <link rel="stylesheet" href="CreateNewAccount/SuperAdminCreateAccounts.css">
</head>
<body>
  <div id="admin-users-page">
    <h2>Admin Users Management</h2>

    <h3>Create New Admin Account</h3>
    <form id="createAccountForm" method="POST" action="CreateNewAccount/SuperAdminCreateAccounts.php">
      <div>
        <label for="firstname">First Name</label>
        <input type="text" id="firstname" name="firstname" required>
        <div class="error" id="firstnameError"></div>
      </div>

      <div>
        <label for="lastname">Last Name</label>
        <input type="text" id="lastname" name="lastname" required>
        <div class="error" id="lastnameError"></div>
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

  <!-- Modal for Create Account Success/Error -->
  <div id="accountModal" class="modal">
    <div class="modal-box">
      <span class="close-modal" id="closeAccountModal">&times;</span>
      <div class="modal-header">
        <h2 id="accountModalTitle">Account Successfully Created</h2>
      </div>
      <div class="modal-body" id="accountModalMessage"></div>
      <div class="modal-footer">
        <button id="modalOkBtn" class="modal-ok-btn">OK</button>
      </div>
    </div>
  </div>

</body>
</html>
