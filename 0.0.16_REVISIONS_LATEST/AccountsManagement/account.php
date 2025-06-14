<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../admin.php");
    exit();
}

include 'DB_connect.php';

$currentUsername = $_SESSION['username']; // No need for isset check again
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <script src="account.js"></script>
  <meta charset="UTF-8">
  <title>Account Info</title>
  <style>
    /* Scoped to #account-section only */
    #account-section {
      font-family: Arial, sans-serif;
      padding: 30px;
      background: #f5f5f5;
    }

    #account-section h2, 
    #account-section h3 {
      margin-bottom: 10px;
    }

    #account-section .form-group {
      margin-bottom: 15px;
    }

    #account-section input[type="text"],
    #account-section input[type="password"] {
      width: 100%;
      padding: 8px;
      box-sizing: border-box;
    }

    #account-section .submit-btn {
      background-color: #3498db;
      color: white;
      border: none;
      padding: 10px 20px;
      cursor: pointer;
      font-weight: bold;
      border-radius: 4px;
    }

    #account-section .password-wrapper {
      position: relative;
    }

    #account-section .toggle-btn {
      position: absolute;
      right: 0;
      top: 0;
      height: 100%;
      background: transparent;
      border: none;
      cursor: pointer;
      padding: 0 10px;
      font-weight: bold;
    }

    #account-section .message {
      margin-top: 10px;
      color: green;
      font-weight: bold;
    }

    #account-section hr {
      margin: 30px 0;
    }
    
  </style>
</head>
<body>
 <div id="account-section">
  <h2>Account Details</h2>
  <form id="accountForm">
    <div class="form-group">
      <label for="username">Username</label>
      <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($currentUsername); ?>" readonly />
    </div>

    <div class="form-group">
      <label for="password">Password</label>
      <div class="password-wrapper">
        <input type="password" id="password" value="••••••••" readonly />
        <button type="button" id="togglePassword" class="toggle-btn">Show</button>
      </div>
    </div>

    <button type="button" id="editInfoBtn" class="submit-btn">Edit Info</button>
  </form>

  <hr id="editFormSeparator" style="display:none;">
  <h3 id="editFormTitle" style="display:none;">Update Account</h3>
  <form id="editAccountForm" style="display:none;">
    <div class="form-group">
      <label for="newUsername">New Username</label>
      <input type="text" id="newUsername" name="newUsername" value="<?php echo htmlspecialchars($currentUsername); ?>" required>
      <span class="error-message" id="usernameError" style="color: red; display: none;"></span>
    </div>

    <div class="form-group">
      <label for="newPassword">New Password</label>
      <div class="password-wrapper">
        <input type="password" id="newPassword" name="newPassword" />
        <button type="button" id="toggleNewPassword" class="toggle-btn">Show</button>
      </div>
      <span class="error-message" id="passwordError" style="color: red; display: none;"></span>
    </div>

    <div class="form-group">
      <label for="confirmPassword">Confirm Password</label>
      <input type="password" id="confirmPassword" name="confirmPassword" />
      <span class="error-message" id="confirmPasswordError" style="color: red; display: none;"></span>
    </div>

    <button type="submit" class="submit-btn">Save Changes</button>
  </form>

<div id="successModal" class="modal" style="display: none;">
  <div class="modal-content">
    <span class="close-modal">&times;</span>
    <h3>Success!</h3>
    <p id="modalMessage">Account updated successfully!</p>
    <button class="modal-close-btn submit-btn">OK</button>
  </div>
</div>
<script>
document.getElementById("updateAccountForm").addEventListener("submit", async (e) => {
    e.preventDefault(); // Prevent page reload

    const formData = new FormData(e.target);

    try {
        const response = await fetch("your_php_endpoint.php", {
            method: "POST",
            body: formData,
            credentials: "include" // Required for session cookies
        });

        const data = await response.json();

        if (data.status === "success") {
            alert("Account updated successfully!");
            // Optional: Redirect or update UI
        } else {
            alert("Error: " + (data.message || "Update failed"));
        }
    } catch (error) {
        console.error("Fetch error:", error);
        alert("Network error. Please try again.");
    }
});
</script>

</div>

<script>
// Initialize when the content is loaded
if (typeof initializeAccountInfoHandlers === 'function') {
    initializeAccountInfoHandlers();
}
</script>
  <script src="AccountsManagement/account.js"></script> <!-- Adjust the path -->
  <!-- Modal Structure -->

</body>
</html>
