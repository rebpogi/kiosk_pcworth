<?php
session_start();
$_SESSION['return_to'] = $_SERVER['REQUEST_URI'];
// Database connection
$host = "localhost";
$username = "zas"; // Change if needed
$password = "group4";     // Change if needed
$database = "testing_backend"; // Change to your actual DB name

$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Fetch products from DB
$categories = ['gpu', 'cpu', 'mobo', 'ram', 'storage', 'psu', 'case', 'cpucooler', 'fan'];
$products = [];

foreach ($categories as $category) {
  $sql = "SELECT * FROM products WHERE category = '$category' AND status = 'Shown'";
  $result = $conn->query($sql);
  if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $products[$category][] = $row;
    }
  } else {
    $products[$category] = [];
  }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="partso.css" />
  <script src="partso.js" defer></script>
  <title>Parts Out</title>
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
  <h2>| Parts Out</h2>
  <div class="icons">
    <button onclick="location.href='secmainkiosk.php'">
      <img src="resource/home.png" alt="Home">
    </button>
    <button onclick="location.href='viewcart.php'">
      <img src="resource/cart.png" alt="Cart">
    </button>
  </div>
</nav>

<div class="container">
  <aside>
    <!-- All Items Button -->
    <button onclick="setActiveSection('allitem')" class="btl">
      <img class="btlimg1" src="resource/allitem.png" alt="All Items">
    </button>

    <!-- Category buttons -->
    <?php foreach ($categories as $cat): ?>
      <button onclick="setActiveSection('<?php echo $cat ?>')" class="btl">
        <img class="btlimg1" src="resource/<?php echo $cat ?>.png" alt="<?php echo ucfirst($cat) ?>">
      </button>
    <?php endforeach; ?>
  </aside>

  <main>
    <?php foreach ($products as $cat => $items): ?>
    <div class="item" id="<?php echo $cat ?>" style="display: none;">
      <div class="product-grid">
        <?php foreach ($items as $product): ?>
          <div class="product-card">
            <img src="../<?php echo htmlspecialchars($product['immage']); ?>" 
            alt="<?php echo htmlspecialchars($product['product_display_name']); ?>" 
            class="w-full md:w-1/2 rounded shadow">
            <h3 class="cardfont"><?php echo htmlspecialchars($product['product_display_name']) ?></h3>
            <div class="price">₱<?php echo number_format($product['price'], 2) ?></div>
            <a href="viewproduct.php?ID=<?php echo $product['ID']; ?>" class="view-btn">View Item Details</a>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
    <?php endforeach; ?>

    <div class="item" id="allitem" style="display: none;">
      <div class="product-grid"><!-- JS Clones Items Here --></div>
    </div>

  </main>
</div>

</body>
</html>