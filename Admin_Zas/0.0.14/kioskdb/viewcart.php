<?php
session_start();

$host = "localhost";
$username = "zas";
$password = "group4";
$database = "testing_backend";

$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}
$cart = &$_SESSION['cart'];

// Clear cart if requested
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['clear_cart'])) {
    $_SESSION['cart'] = [];
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Handle AJAX update requests
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_qty') {
    $productId = intval($_POST['product_id']);
    $newQty = max(1, intval($_POST['quantity']));

    // Get current stock from DB
    $stmt = $conn->prepare("SELECT quantity FROM products WHERE id = ?");
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $stmt->bind_result($stock);
    $stmt->fetch();
    $stmt->close();

    if ($stock === null) {
      // Invalid product ID
      http_response_code(400);
      echo json_encode(['error' => 'Invalid product']);
      exit;
    }

    // Clamp quantity to available stock
    $newQty = min($newQty, $stock);

    if (isset($cart[$productId])) {
        $cart[$productId]['quantity'] = $newQty;
    }

    $subtotal = $cart[$productId]['price'] * $newQty;

    $total = 0;
    foreach ($cart as $item) {
        $total += $item['price'] * $item['quantity'];
    }

    header('Content-Type: application/json');
    echo json_encode(['subtotal' => number_format($subtotal, 2), 'total' => number_format($total, 2), 'newQty' => $newQty]);
    exit;
}

// Handle remove item form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_item'])) {
    $productId = intval($_POST['product_id']);
    unset($cart[$productId]);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

$total = 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Shopping Cart - Kiosk</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-900 font-sans">
  <div class="max-w-3xl mx-auto p-4 flex flex-col min-h-screen">
    <!-- Header -->
    <div class="flex items-center justify-between border-b pb-4 mb-4">
      <div class="flex items-center gap-2">
        <img src="resource/logo.png" alt="PC Worth Logo" class="w-50 h-10">
        <h1 class="text-xl font-bold"><i class="fas fa-shopping-cart mr-1"></i> My Cart</h1>
      </div>
      <form method="POST">
        <button type="submit" name="clear_cart" class="flex items-center text-red-600 border border-red-500 px-3 py-1 rounded hover:bg-red-100">
          <i class="fas fa-times-circle mr-1"></i> Clear Cart
        </button>
      </form>
    </div>

    <!-- Cart Items -->
    <div class="flex-1">
      <?php if (empty($cart)): ?>
        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded">
          Your cart is empty.
        </div>
      <?php else: ?>
        <?php foreach ($cart as $id => $item):
          $subtotal = $item['price'] * $item['quantity'];
          $total += $subtotal;
        ?>
        <form method="POST" class="bg-white shadow rounded-lg mb-4 p-4 flex items-center justify-between" data-product-id="<?= $id ?>">
          <input type="hidden" name="product_id" value="<?= $id ?>">
          <div class="flex items-center gap-4">
            <img src="<?= htmlspecialchars($item['image_url']) ?>" alt="<?= htmlspecialchars($item['name']) ?>" class="w-20 h-20 object-cover rounded">
            <div>
              <h2 class="font-semibold"><?php echo htmlspecialchars($item['name']); ?></h2>
            <!-- Quantity buttons -->
            <div class="flex items-center gap-2 mt-2">
              <label for="qty-<?= $id ?>" class="font-semibold">Qty:</label>

              <button type="button" 
                class="qty-btn-minus bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700" 
                data-product-id="<?= $id ?>">-</button>

                <?php
                // Fetch stock for each product
                $stmt = $conn->prepare("SELECT quantity FROM products WHERE id = ?");
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $stmt->bind_result($stock);
                $stmt->fetch();
                $stmt->close();
                ?>
                <input type="text" id="qty-<?= $id ?>" class="qty-input w-16 text-center border rounded px-2 py-1" 
                data-product-id="<?= $id ?>" data-stock="<?= $stock ?>" value="<?= $item['quantity'] ?>" readonly />

              <button type="button" 
                class="qty-btn-plus bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700" 
                data-product-id="<?= $id ?>">+</button>
            </div>
            </div>
          </div>
          <div class="text-right space-y-2">
            <p class="text-red-600 font-bold text-lg subtotal" data-product-id="<?= $id ?>">
            ₱<?= number_format($item['price'] * $item['quantity'], 2) ?>
            </p>
            <button type="submit" name="remove_item" class="flex items-center gap-1 text-red-600 hover:text-red-800 text-sm border border-red-500 px-2 py-1 rounded">
            <i class="fas fa-trash-alt"></i> Remove
            </button>
          </div>
        </form>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>

    <!-- Footer -->
    <div class="bg-white shadow-md p-4 rounded-lg mt-6 flex justify-between items-center">
      <div class="text-lg font-semibold">Cart Total: <span id="total">₱<?= number_format($total, 2) ?></span></div>
    <div class="space-x-2">
    <?php
        $return_to = isset($_SESSION['return_to']) ? $_SESSION['return_to'] : 'index.php';
    ?>
    <form method="GET" action="<?= htmlspecialchars($return_to) ?>" style="display: inline;">
        <button type="submit" class="bg-blue-900 text-white px-4 py-2 rounded hover:bg-blue-800">Return</button>
    </form>
    <form action="select_payment.php" method="POST" style="display: inline;">
        <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
        Proceed to Checkout
        </button>
    </form>
    </div>
    </div>
  </div>

  <script src="cart.js"></script>
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script> <!-- FontAwesome -->
</body>
</html>



