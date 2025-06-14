<?php
session_start();
require 'AccountsManagement/DB_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password']; // unhashed

    $sql = "SELECT * FROM admin_users WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();

    $result = $stmt->get_result();
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        $_SESSION['id'] = $user['id']; // ✅ Store user ID for update functionality
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        header("Location: admin.php");
        exit();
    } else {
        $error = "Invalid credentials";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Page</title>
  <link rel="stylesheet" href="AccountsManagement/acc.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css"
    integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
    integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js"
    integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script>

  <link rel="stylesheet" href="AccountsManagement/acc.css">
  <!-- <script src="acc.js"></script> -->
</head>
<body>
  <div class="signin-page">
    <nav class="navbar sticky-top shadow" style="width: 100%; background: #0C304A; font-size: 20px;">
      <span class="navbar-text px-3 text-white">
        <img alt="pcworthkiosklogo" height="48px" src="uploads/kiosklogo.png" />
      </span>
    </nav>
<h1>SUPER ADMIN USERNAME :FORONZAS
<br>
PASSWORD: 123456AaA
<br>
ROLE : SUPERADMIN
</h1>
    <main>
      <div class="title-container">
        <h1>Sign in</h1>
      </div>

      <?php if (isset($error)) echo "<p style='color:red; text-align: center;'>$error</p>"; ?>

      <form method="POST" action="">
        <div class="form-group mb-3">
          <input type="text" class="form-control" name="username" placeholder="Username" required />
        </div>
        <div class="form-group mb-3">
          <input type="password" class="form-control" name="password" placeholder="Password" required />
        </div>
        <button type="submit" class="btn btn-primary w-100">SIGN IN</button>
      </form>
    </main>
  </div>
</body>
</html>
