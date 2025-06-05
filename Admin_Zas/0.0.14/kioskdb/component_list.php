<?php
// Connect to your MySQL database
$servername = "localhost";
$username = "zas";
$password = "group4";
$dbname = "testing_backend";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$category = isset($_GET['component']) ? $_GET['component'] : 'cpu';
$categoryDisplay = ucfirst($category);

$sql = "SELECT * FROM products WHERE LOWER(category) = ? AND status = 'Shown'";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $category);
$stmt->execute();
$result = $stmt->get_result();

$components = [];
if ($result && $result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $components[] = $row;
  }
} else {
  echo "<p style='color:red;text-align:center;'>No components found for category: $categoryDisplay</p>";
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Select Component - <?= htmlspecialchars($categoryDisplay) ?></title>
  <link rel="stylesheet" href="customb.css" />
  <style>
    .return-button {
      display: block;
      margin: 30px auto 50px;
      padding: 12px 24px;
      font-size: 16px;
      background-color: #444;
      color: #fff;
      border: none;
      border-radius: 10px;
      cursor: pointer;
      transition: background-color 0.3s ease, transform 0.2s ease;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .return-button:hover {
      background-color: #666;
      transform: scale(1.05);
    }
  </style>
</head>
<body>
  <header>
    <div class="slideshow">
      <div class="slide"><img src="resource/frame1.png"></div>
      <div class="slide"><img src="resource/frame2.png"></div>
      <div class="slide"><img src="resource/frame3.png"></div>
      <div class="slide"><img src="resource/frame4.png"></div>
      <div class="slide"><img src="resource/frame5.png"></div>
    </div>
  </header>

  <nav>
    <img src="resource/logo1.png" class="logo" alt="Logo">
    <h2>| Custom Build</h2>
    <div class="icons">
      <button onclick="location.href='secmainkiosk.php'">
        <img src="resource/home.png" alt="Home">
      </button>
      <button onclick="location.href=' '">
        <img src="resource/cart.png" alt="Cart">
      </button>
    </div>
  </nav>

  <h2 class="section-title">Select a <?= htmlspecialchars($categoryDisplay) ?> Component</h2>

  <table class="build-table" aria-label="Component List Table">
    <thead>
      <tr>
        <th scope="col">Component</th>
        <th scope="col">Product</th>
        <th scope="col">Details</th>
        <th scope="col">Price</th>
        <th scope="col">Action</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($components as $product): ?>
        <tr>
          <td><img src="resource/<?= htmlspecialchars(strtolower($category)) ?>.png" alt="<?= htmlspecialchars($categoryDisplay) ?> Icon"></td>
          <td><?= htmlspecialchars($product['product_display_name']) ?></td>
          <td><?= htmlspecialchars($product['product_description']) ?></td>
          <td>₱<?= number_format($product['price'], 2) ?></td>
          <td>
            <button class="add-button" onclick='selectComponent("<?= strtolower($category) ?>", <?= json_encode($product, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>)'>Select</button>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <button class="return-button" onclick="window.history.back()">Return</button>

  <script>
    function selectComponent(component, product) {
      sessionStorage.setItem(component, JSON.stringify(product));
      window.location.href = "CBSelection.php";
    }
  </script>
</body>
</html>
