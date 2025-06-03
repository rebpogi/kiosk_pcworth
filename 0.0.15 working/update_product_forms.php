<?php
require_once 'update_product.php'; 

$conn = new mysqli('localhost', 'zas', 'group4', 'testing_backend');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$product = "";
$formFactor = "";
$socketType = "";
$ramSocketType = "";

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $result = $conn->query("SELECT * FROM products WHERE ID = $id");
    if ($result) {
        $product = $result->fetch_assoc();

        // Assign for select inputs pre-selection:
        $formFactor = $product['Form_factor'] ?? '';
        $socketType = $product['Socket_type'] ?? '';
        $ramSocketType = $product['Ram_socket_type'] ?? '';
    }
}
?>

  <head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard Template · Bootstrap</title>
  <script src="admin.js" defer></script>

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css"
    integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
    integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js"
    integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script>

  <link rel="stylesheet" href="admin.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>

<body>
  <main>
        <!-- <button onclick="goBack()" class="new-Product-update" >← Go Back</button> -->
         <div>
           <button type="button" onclick="goBack()" class="new-Product-update">← Back</button>
        </div>

        <h1>EDIT PRODUCT</h1>
        <div class="form-wrapper">
          <form id="Update_product_form" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="ID" value="<?= htmlspecialchars($product['ID']) ?>">


                <div class="input-group">
                    <div class="input-field">
                        <p>Product Display Name</p>
                        <input id="product_display_name" name="product_display_name" type="text" placeholder="Display_name" required
                               value="<?= htmlspecialchars($product['product_display_name']) ?>">
                    </div>

                    <div class="input-field">
                        <p>Price</p>
                        <input id="price" name="price" type="number" placeholder="price" required
                               value="<?= htmlspecialchars($product['price']) ?>">
                    </div>
                </div>

                <div class="input-group">
                    <div class="input-field">
                        <p>Product Category</p>
                        <select id="category" name="category" required>
                            <option value="">Select Category</option>
                            <?php
                            $categories = ["CPU", "GPU", "Mobo", "RAM", "Storage", "PSU","Monitor","Mouse","Keyboard", "CPUCooler", "Case", "Casefan"];
                            foreach ($categories as $cat) {
                                $selected = ($product['category'] === $cat) ? 'selected' : '';
                                echo "<option value=\"$cat\" $selected>$cat</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="input-field">
                        <p>Manufacturer</p>
                              <select id="manufacturer" name="manufacturer" required>
                                <option value="">Select Manufacturer</option>
                                <option value="Nvidia" <?= ($product['manufacturer'] === 'Nvidia') ? 'selected' : '' ?>>Nvidia</option>
                                <option value="Intel" <?= ($product['manufacturer'] === 'Intel') ? 'selected' : '' ?>>Intel</option>
                                <option value="ASrock" <?= ($product['manufacturer'] === 'ASrock') ? 'selected' : '' ?>>ASrock</option>
                                <option value="Apple" <?= ($product['manufacturer'] === 'Apple') ? 'selected' : '' ?>>Apple</option>
                                <option value="Gigabyte" <?= ($product['manufacturer'] === 'Gigabyte') ? 'selected' : '' ?>>Gigabyte</option>
                                <option value="HP" <?= ($product['manufacturer'] === 'HP') ? 'selected' : '' ?>>HP</option>
                                <option value="AMD" <?= ($product['manufacturer'] === 'AMD') ? 'selected' : '' ?>>AMD</option>
                                <option value="ASUS" <?= ($product['manufacturer'] === 'ASUS') ? 'selected' : '' ?>>ASUS</option>
                              </select>
                    </div>
                </div>

                  <div class="input-group">
                    <div class="input-field">
                      <p>Form factor (for motherboard)</p>
                      <select id="Form_factor" name="Form_factor" required>
                        <option value="Not_Applicable" <?= ($formFactor == 'Not_Applicable') ? 'selected' : '' ?>>Not Applicable</option>
                        <option value="MINI-ITX" <?= ($formFactor == 'MINI-ITX') ? 'selected' : '' ?>>Mini-ITX</option>
                        <option value="MICRO-ITX" <?= ($formFactor == 'MICRO-ITX') ? 'selected' : '' ?>>Micro-ITX</option>
                        <option value="ATX" <?= ($formFactor == 'ATX') ? 'selected' : '' ?>>ATX</option>
                        <option value="Extended-ATX" <?= ($formFactor == 'Extended-ATX') ? 'selected' : '' ?>>Extended-ATX</option>
                      </select>
                    </div>

                    <div class="input-field">
                      <p>Socket type (for motherboard and CPU)</p>
                      <select id="Socket_type" name="Socket_type" required>
                        <option value="Not_Applicable" <?= ($socketType == 'Not_Applicable') ? 'selected' : '' ?>>Not Applicable</option>
                        <option value="AM4" <?= ($socketType == 'AM4') ? 'selected' : '' ?>>AM4</option>
                        <option value="AM5" <?= ($socketType == 'AM5') ? 'selected' : '' ?>>AM5</option>
                          <option value="LGA1700" <?= ($socketType == 'LGA1700') ? 'selected' : '' ?>>LGA1700</option>
                            <option value="LGA1850" <?= ($socketType == 'LGA1850') ? 'selected' : '' ?>>LGA1850</option>
                      </select>
                    </div>
                  </div>

                 <div class="input-group">
                <div class="input-field">
                  <p>RAM Socket type for RAM and Motherboard</p>
                  <select id="Ram_socket_type" name="Ram_socket_type" required>
                    <option value="Not_Applicable" <?= (isset($product['Ram_socket_type']) && $product['Ram_socket_type'] == 'Not_Applicable') ? 'selected' : '' ?>>Not Applicable</option>
                    <option value="DDR_4" <?= (isset($product['Ram_socket_type']) && $product['Ram_socket_type'] == 'DDR_4') ? 'selected' : '' ?>>DDR 4</option>
                    <option value="DDR_5" <?= (isset($product['Ram_socket_type']) && $product['Ram_socket_type'] == 'DDR_5') ? 'selected' : '' ?>>DDR 5</option>
                  </select>
                </div>
              </div>

                <p>Product Specifications</p>
                <textarea class="style_box" id="product_specifications" name="product_specifications" placeholder="Product Specifications here" required><?= htmlspecialchars($product['product_specifications']) ?></textarea>

                <p>Product Description</p>
                <textarea class="style_box" id="product_description" name="product_description" placeholder="Product Description here." required><?= htmlspecialchars($product['product_description']) ?></textarea>

                <p>
                     <br>
                    <input type="checkbox" id="status" name="status" <?= ($product['status'] === '0') ? 'checked' : '' ?>> Hide product on kiosk
                </p>
              <!-- OUTPUTS THE PRODUCT IMMAGE IN DB BY FETCHING ITS ID -->
              <?php if ($product): ?>
                <h2>Current File Name: <?= htmlspecialchars(basename($product['immage'])) ?></h2>
                  <?php
                    $imagePath = $product['immage'];
                    $absolutePath = __DIR__ . '/' . $imagePath;
                  ?>
                  <?php if (!empty($imagePath) && file_exists($absolutePath)): ?>
                      <img src="<?= htmlspecialchars($imagePath) ?>" alt="Product Image" style="max-width: 300px;">
                  <?php else: ?>
                      <p>No image available.</p>
                  <?php endif; ?>

              <?php else: ?>
                  <p>Product not found.</p>
              <?php endif; ?>


                  <!-- <input type="file" name="new_image" accept=".png, .jpg, .jpeg"> -->
          <input type="file" id="new_immage" name="new_immage" accept=".png, .jpg, .jpeg">
          <!-- Styled label that acts as the button -->
          <br>
          <br>
          <label for="new_immage" class="custom-update-immage">Upload New Image</label>
            <!-- Image Preview Title -->
          <p>Image preview</p>

          <!-- Image Preview with Style -->
          <img id="UpdateimagePreview" src="<?= htmlspecialchars($product['new_immage'] ?? '') ?>" alt="Image Preview">

                <div class="input-group">
                    <div class="input-field">
                      <p>Warranty Duration</p>
                        <select id="warranty_duration" name="warranty_duration" required>
                        <option value="">Select Warranty Duration</option>

                        <?php
                        $durations = ["No Warranty", "30 Days", "90 Days", "180 Days", "365 Days", "2 Years", "3 Years", "5 Years"];
                        foreach ($durations as $duration) {
                            $selected = ($product['warranty_duration'] === $duration) ? 'selected' : '';
                            echo "<option value=\"$duration\" $selected>$duration</option>";
                        }
                        ?>
                        </select>

                    </div>

                    <div class="input-field">
                        <p>UID / Tracking number</p>
                        <input type="text" placeholder="###" id="UID" name="UID" required
                               value="<?= htmlspecialchars($product['UID']) ?>">
                    </div>
                </div>

                <p>Quantity / Available in stock</p>
                <input type="text" placeholder="###" id="quantity" name="quantity" required
                       value="<?= htmlspecialchars($product['quantity']) ?>">

                <br><br>
                <button type="submit" name = "submit_update" id="submit_update" class="new-Product-update">Update</button>
                <br><br>
            </form>
        </div>
  </main>
  <script>
document.addEventListener('DOMContentLoaded', function () {
  const updateImageInput = document.getElementById('new_immage');
  const updatePreview = document.getElementById('UpdateimagePreview');

  if (updateImageInput && updatePreview) {
    updateImageInput.addEventListener('change', function(event) {
      const file = event.target.files[0];
      if (file && file.type.startsWith('image/')) {
        const reader = new FileReader();
        reader.onload = function(e) {
          updatePreview.src = e.target.result;
          updatePreview.style.display = 'block';
        };
        reader.readAsDataURL(file);
      }
    });
  }
});
</script>

</body>
