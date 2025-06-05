  <?php
  // Connect to DB
  $host = "localhost";
  $username = "zas";
  $password = "group4";
  $database = "testing_backend";

  $conn = new mysqli($host, $username, $password, $database);
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  // Check if id is passed
  if (!isset($_GET['ID'])) {
    die("Product ID not specified.");
  }

  $id = intval($_GET['ID']);
  $sql = "SELECT * FROM products WHERE ID = $id AND status = 'Shown'";
  $result = $conn->query($sql);

  if ($result && $result->num_rows === 1) {
    $product = $result->fetch_assoc();
  } else {
    die("Product not found.");
  }

  $conn->close();
  ?>

  <!DOCTYPE html>
  <html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Product Page - Kiosk</title>
    <link rel="stylesheet" href="partso.css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
    const maxStock = <?php echo (int)$product['stock']; ?>;
    </script>
  <script src="viewpro.js" defer></script>
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
  <div class="max-w-5xl mx-auto p-6" style="margin-top: 360px;">

    <!-- Product Details Container -->
    <div class="max-w-5xl mx-auto p-6">
      <div class="bg-white shadow-md rounded-lg p-6 flex flex-col md:flex-row gap-6 items-start border">
        <!-- Product Image -->
        <img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="<?php echo htmlspecialchars($product['product_display_name']); ?>" class="w-full md:w-1/2 rounded shadow">

        <!-- Product Info -->
        <div class="flex-1 space-y-4">
          <h1 class="text-3xl font-bold"><?php echo htmlspecialchars($product['product_display_name']); ?></h1>
          <p class="text-red-600 text-2xl font-semibold">₱<?php echo number_format($product['price'], 2); ?></p>
          <?php if ((int)$product['quantity'] <= 0): ?>
          <p class="text-yellow-500 font-semibold">Out of Stock</p>
          <?php endif; ?>

        <?php if ((int)$product['quantity'] > 0): ?>
          <!-- Quantity -->
          <div class="flex items-center gap-4 mt-4">
            <label class="font-semibold">Quantity</label>
            <div class="flex items-center border rounded overflow-hidden">
              <button onclick="updateQty(-1)" class="px-3 py-1 text-white bg-blue-600 hover:bg-blue-700">-</button>
              <input type="text" id="qty" value="1" data-max="<?= (int)$product['quantity'] ?>" class="w-12 text-center border-l border-r" readonly />
              <button onclick="updateQty(1)" class="px-3 py-1 text-white bg-red-600 hover:bg-red-700">+</button>
            </div>
          </div>
        <?php endif; ?>
        </div>
      </div>

      <!-- Product Description -->
      <section class="mt-10 border-t pt-6">
        <h2 class="text-2xl font-bold mb-2">Product Description</h2>
        <p class="text-gray-700"><?php echo nl2br(htmlspecialchars($product['product_description'])); ?></p>
      </section>

      <!-- Specifications -->
      <section class="mt-10 border-t pt-6">
      <h2 class="text-2xl font-bold mb-2">Specifications</h2>
      <?php if (!empty($product['specs'])): ?>
          <div class="text-sm text-gray-800 whitespace-pre-line">
          <?= nl2br(htmlspecialchars($product['specs'])) ?>
          </div>
      <?php else: ?>
          <p class="text-sm text-gray-500">No specifications available.</p>
      <?php endif; ?>
      </section>

      <!-- Action Buttons -->
      <section class="mt-10 border-t pt-6 flex justify-between">
        <button onclick="goBack()" class="bg-blue-600 text-white px-8 py-3 rounded hover:bg-blue-700">Return</button>

        <?php if ((int)$product['quantity'] > 0): ?>
        <form action="addtocart.php" method="POST" onsubmit="return validateQty();">
        <input type="hidden" name="ID" value="<?= $product['ID'] ?>">
        <input type="hidden" name="quantity" id="form_qty" value="1">
        <button type="submit" class="bg-red-600 text-white px-8 py-3 rounded hover:bg-red-700">Add to Cart</button>
        </form>
        <?php else: ?>
          <button disabled class="bg-yellow-400 text-white px-8 py-3 rounded cursor-not-allowed">Out of Stock</button>
        <?php endif; ?>
      </section>
    </div>
  </body>
  </html>
