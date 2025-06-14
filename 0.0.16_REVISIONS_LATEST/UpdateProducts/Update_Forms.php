<?php
// Update_Forms.php

if (!isset($_GET['id'])) {
  die("Product ID is required.");
}

$productId = intval($_GET['id']);
$product = null;

// Database connection (adjust credentials as needed)
$conn = new mysqli("localhost", "zas", "group4", "testing_backend");

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i", $productId);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

$stmt->close();
$conn->close();

if (!$product) {
  die("Product not found.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Product - <?= htmlspecialchars($product['product_display_name']) ?></title>
  <link rel="stylesheet" href="InsertNewProduct/NewProductForm.css">
  <style>
    .error-message { color: red; font-size: 0.875rem; }
  </style>
</head>
<body>

<h1>Edit Product</h1>
<button type="button" onclick="goBack()">← Back</button>



<div id="formsContainer">
  <div id="AddProductForms" style="display: block;">

    <div class="form-wrapper"> 
      <form id="UpdateProductForm" action="/phpscripts/0.0.16_REVISIONS_LATEST/UpdateProducts/update_product.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="ID" value="<?= $productId ?>">

        <div class="input-group">
          <div class="input-field">
            <p>Product Display Name</p>
            <input id="product_display_name" name="product_display_name" type="text" placeholder="Display_name" value="<?= htmlspecialchars($product['product_display_name']) ?>" required>
            <span class="error-message" id="product_display_name-error"></span>
          </div>

          <div class="input-field">
            <p>Price</p>
            <input id="price" name="price" type="number" step="0.01" placeholder="₱00.00" value="<?= htmlspecialchars($product['price']) ?>" required>
            <span class="error-message" id="price-error"></span>
          </div>
        </div>

        <div class="input-group">
          <div class="input-field">
            <p>Product Category</p>
            <select id="category" name="category" required>
              <option value="">Select Category</option>
              <?php
              $categories = ["CPU", "GPU", "Mobo", "RAM", "Storage", "PSU", "Monitor", "Mouse", "Keyboard", "CPUCooler", "Case", "Casefan"];
              foreach ($categories as $cat) {
                $selected = ($product['category'] === $cat) ? 'selected' : '';
                echo "<option value=\"$cat\" $selected>$cat</option>";
              }
              ?>
            </select>
            <span class="error-message" id="category-error"></span>
          </div>

          <div class="input-field">
            <p>Manufacturer</p>
            <select id="manufacturer" name="manufacturer" required>
              <?php
              $manufacturers = ["Intel", "AMD", "NVIDIA", "ASUS", "MSI", "Gigabyte", "EVGA", "ASRock", "Corsair", "Inplay", "Legion", "NETAC", "Crucial", "Kingston"];
              echo '<option value="">Select Manufacturer</option>';
              foreach ($manufacturers as $m) {
                $selected = ($product['manufacturer'] === $m) ? 'selected' : '';
                echo "<option value=\"$m\" $selected>$m</option>";
              }
              ?>
            </select>
            <span class="error-message" id="manufacturer-error"></span>
          </div>
        </div>

        <div class="input-group">
          <div class="input-field">
            <p>Form Factor (for motherboard)</p>
            <select id="Form_factor" name="Form_factor" required>
              <?php
              $factors = ["Not_Applicable", "MINI-ITX", "MICRO-ITX", "ATX", "Extended-ATX"];
              foreach ($factors as $f) {
                $selected = ($product['Form_factor'] === $f) ? 'selected' : '';
                echo "<option value=\"$f\" $selected>$f</option>";
              }
              ?>
            </select>
            <span class="error-message" id="Form_factor-error"></span>
          </div>

          <div class="input-field" id="socket-type-container" style="display: <?= ($product['Socket_type'] && $product['Socket_type'] != 'Not_Applicable') ? 'block' : 'none' ?>;">
            <p>CPU Socket Type</p>
            <select id="Socket_type" name="Socket_type" required>
              <?php
              $sockets = ["Not_Applicable", "AM4", "AM5", "LGA1700", "LGA1850"];
              foreach ($sockets as $s) {
                $selected = ($product['Socket_type'] === $s) ? 'selected' : '';
                echo "<option value=\"$s\" $selected>$s</option>";
              }
              ?>
            </select>
            <span class="error-message" id="Socket_type-error"></span>
          </div>
        </div>

        <div class="input-group">
          <div class="input-field">
            <p>RAM Socket Type</p>
            <select id="Ram_socket_type" name="Ram_socket_type" required>
              <?php
              $rams = ["Not_Applicable", "DDR_4", "DDR_5"];
              foreach ($rams as $r) {
                $selected = ($product['Ram_socket_type'] === $r) ? 'selected' : '';
                echo "<option value=\"$r\" $selected>$r</option>";
              }
              ?>
            </select>
            <span class="error-message" id="Ram_socket_type-error"></span>
          </div>
        </div>

        <p>Product Specifications</p>
        <textarea class="style_box" id="product_specifications" name="product_specifications" required><?= htmlspecialchars($product['product_specifications']) ?></textarea>
        <span class="error-message" id="product_specifications-error"></span>

        <p>Product Description</p>
        <textarea class="style_box" id="product_description" name="product_description" required><?= htmlspecialchars($product['product_description']) ?></textarea>
        <span class="error-message" id="product_description-error"></span>

        <br><br>
        <p><input type="checkbox" id="status" name="status" <?= $product['status'] ? '' : 'checked' ?>> Hide product on kiosk</p>
        <br><br>

        <p>Product Display Image</p>
        <p>Accepts .png .jpg .jpeg</p>
        <p>File size limit 20mb (megabytes)</p>
                <?php if (!empty($product['immage'])): ?>
                  <img id="imagePreview" 
                      src="<?= htmlspecialchars($product['immage']) ?>" 
                      alt="Product image" 
                      style="max-width: 700px;">
              <?php endif; ?>

            <p>Image path: <?= htmlspecialchars($product['immage']) ?></p>

          <label for="immage_update" class="custom-upload">Choose Image</label>
          <input id="immage_update" class="custom-upload" name="immage" type="file" accept=".png, .jpg, .jpeg" style="display: none;">
          <span class="error-message" id="immage-error"></span>

          <p>Image Preview</p>
          <img id="preview" alt="Image Preview" style="display: none; width: 700px; height: 700px">
          <br><br>

        <div class="input-group">
          <div class="input-field">
            <p>Warranty Duration</p>
            <select id="warranty_duration" name="warranty_duration" required>
              <?php
              $durations = ["No Warranty", "30 Days", "90 Days", "180 Days", "365 Days", "2 Years", "3 Years", "5 Years"];
              foreach ($durations as $d) {
                $selected = ($product['warranty_duration'] === $d) ? 'selected' : '';
                echo "<option value=\"$d\" $selected>$d</option>";
              }
              ?>
            </select>
            <span class="error-message" id="Warrantyduration-error"></span>
          </div>

          <div class="input-field">
            <p>UID / Tracking Number</p>
            <input type="text" placeholder="###" id="UID" name="UID" value="<?= htmlspecialchars($product['UID']) ?>">
            <span class="error-message" id="UID-error"></span>
          </div>
        </div>

        <p>Quantity / Available in stock</p>
        <input type="text" placeholder="##" id="quantity" name="quantity" value="<?= htmlspecialchars($product['quantity']) ?>">
        <span class="error-message" id="quantity-error"></span>

        <br><br>
      <button type="submit" id="updateProductBtn" class="new-Product-save">Update Product</button>
          <div id="popupModal" class="modalNewProduct">
          <div class="modalNewProduct-message">
            <button id="closeModal" class="modalNewProduct-close" type="button">×</button>
            <p id="modalMessage">Product saved successfully!</p>
          </div>
        </div>

        <br><br>
      </form>
    </div>
  </div>
</div>
<!-- Success Modal -->
<script>
// Initialize form validation when this form loads
if (typeof initUpdateProductFormValidation === 'function') {
    initUpdateProductFormValidation();
}
</script>
<script src="productFormValidationTest.js"></script>
</body>
</html>

