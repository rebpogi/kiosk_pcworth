<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Product</title>
  
  <link rel="stylesheet" href="InsertNewProduct/NewProductForm.css">
  <!-- <script src="FormsCategoryConditions.js" defer ></script> -->

  <style>
.error-message {
  color: red;
  font-size: 0.875rem;
  margin-top: 4px;
  display: block;
}
#socket-type-container {
  display: none;
}

#socket-type-container.visible {
  display: block;
}

  </style>
</head>
<body>
<div id="formsContainer">
  <div id="AddProductForms" style="display: block;">
    <h1>ADD PRODUCT</h1>

    <div class="form-wrapper"> 
     <!-- ==================== form start =============== -->
      <form id="productForm" method="POST" enctype="multipart/form-data">
        
        <div class="input-group">
          <div class="input-field">
            <p>Product Display Name</p>
            <input id="product_display_name" name="product_display_name" type="text" placeholder="Display_name" required>
            <span class="error-message" id="product_display_name-error"></span>
          </div>
          
          <div class="input-field">
            <p>Price</p>
            <input id="price" name="price" type="number" step="0.01" placeholder="₱00.00" required>
            <span class="error-message" id="price-error"></span>
          </div>
        </div>

        <div class="input-group">
          <div class="input-field">
            <p>Product Category</p>
            <select id="category" name="category" required>
              <option value="">Select Category</option>
              <option value="CPU">CPU</option>
              <option value="GPU">GPU</option>
              <option value="Mobo">Motherboard</option>
              <option value="RAM">Random access memory</option>
              <option value="Storage">Solid State Drive</option>
              <option value="PSU">Power Supply</option>
              <option value="Monitor">Monitor</option>
              <option value="Mouse">Mouse</option>
              <option value="Keyboard">Keyboard</option>
              <option value="CPUCooler">CPU Cooler</option>
              <option value="Case">Case</option>
              <option value="Casefan">Case Fans</option>
            </select>
            <span class="error-message" id="category-error"></span>
          </div>

          <div class="input-field">
            <p>Manufacturer</p>
            <select id="manufacturer" name="manufacturer" required>
              <option value="">Select Manufacturer</option>
              <option value="Intel">Intel</option>
              <option value="AMD">AMD</option>
              <option value="NVIDIA">NVIDIA</option>
              <option value="ASUS">ASUS</option>
              <option value="MSI">MSI</option>
              <option value="Gigabyte">Gigabyte</option>
              <option value="EVGA">EVGA</option>
              <option value="ASRock">ASRock</option>
              <option value="Corsair">Corsair</option>
              <option value="Inplay">Inplay</option>
              <option value="Legion">Legion</option>
              <option value="NETAC">NETAC</option>
              <option value="Crucial">Crucial</option>
              <option value="Kingston">Kingston</option>
            </select>
            <span class="error-message" id="manufacturer-error"></span>
          </div>
        </div>

        <div class="input-group">
          <div class="input-field">
            <p>Form Factor (for motherboard)</p>
            <select id="Form_factor" name="Form_factor" required>
              <option value="Not_Applicable">Not_applicable</option>
              <option value="MINI-ITX">Mini-ITX</option>
              <option value="MICRO-ITX">Micro-ITX</option>
              <option value="ATX">ATX</option>
              <option value="Extended-ATX">Extended-ATX</option>
            </select>
            <span class="error-message" id="Form_factor-error"></span>
          </div>

          <div class="input-field" id="socket-type-container" >
            <p>CPU Socket Type</p>
            <select id="Socket_type" name="Socket_type" required >
              <option value="Not_Applicable">Not_applicable</option>
              <option value="AM4">AM4</option>
              <option value="AM5">AM5</option>
              <option value="LGA1700">LGA1700</option>
              <option value="LGA1850">LGA1850</option>
            </select>
            <span class="error-message" id="Socket_type-error"></span>
          </div>
        </div>

        <div class="input-group">
          <div class="input-field">
            <p>RAM Socket Type</p>
            <select id="Ram_socket_type" name="Ram_socket_type" required>
              <option value="Not_Applicable">Not_applicable</option>
              <option value="DDR_4">DDR 4</option>
              <option value="DDR_5">DDR 5</option>
            </select>
            <span class="error-message" id="Ram_socket_type-error"></span>
          </div>
        </div>

        <p>Product Specifications</p>
        <textarea class="style_box" id="product_specifications" name="product_specifications" placeholder="Product Specifications here" required></textarea>
        <span class="error-message" id="product_specifications-error"></span>

        <p>Product Description</p>
        <textarea class="style_box" id="product_description" name="product_description" placeholder="Product Description here." required></textarea>
        <span class="error-message" id="product_description-error"></span>

        <br><br>
        <p><input type="checkbox" id="status" name="status"> Hide product on kiosk</p>
        <br><br>

        <p>Product Display Image</p>
        <p>Accepts .png .jpg .jpeg</p>
        <p>File size limit 20mb (megabytes)</p>
                                 <!-- <img id="imagePreview" src="#" alt="Product image" style="display: none; max-width: 200px;"><br><br> -->

        <label for="immage" class="custom-upload">Choose Image</label>
        <input id="immage" name="immage" type="file" accept=".png, .jpg, .jpeg" required><br><br>

        <span class="error-message" id="immage-error"></span>

        <p>Image Preview</p>
                            <!-- <img id="imagePreview" src="#" alt="Product image" style="display: none; width: 700px; height: 700px "> -->
        <!-- Image Preview -->
        <img id="preview" alt="Image Preview" style="display: none; width: 700px; height: 700px">
  <br>
  <br>
        
        <div class="input-group">
          <div class="input-field">
            <p>Warranty Duration</p>
            <select id="warranty_duration" name="warranty_duration" required>
              <option value="">Select Warranty Duration</option>
              <option value="No Warranty">No Warranty</option>
              <option value="30 Days">30 Days</option>
              <option value="90 Days">90 Days</option>
              <option value="180 Days">180 Days</option>
              <option value="365 Days">365 Days</option>
              <option value="2 Years">2 Years</option>
              <option value="3 Years">3 Years</option>
              <option value="5 Years">5 Years</option>
            </select>
            <span class="error-message" id="Warrantyduration-error"></span>
          </div>

          <div class="input-field">
            <p>UID / Tracking Number</p>
            <input type="text" placeholder="###" id="UID" name="UID">
            <span class="error-message" id="UID-error"></span>
          </div>
        </div>

        <p>Quantity / Available in stock</p>
        <input type="text" placeholder="##" id="quantity" name="quantity">
        <span class="error-message" id="quantity-error"></span>

        <br><br>
        <button type="button" id="saveNewProductBtn" class="new-Product-save">Save</button>

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
<script src="productFormValidation.js"></script>
</body>
</html>
