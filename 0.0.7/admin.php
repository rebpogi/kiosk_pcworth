<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard Template · Bootstrap</title>

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css"
    integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
    integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js"
    integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script>

  <link rel="stylesheet" href="admin.css">
  <script src="admin.js"></script>
</head>

<body>

  <nav class="navbar sticky-top shadow" style="width: 100%; background: #0C304A; font-size: 20px;">
    <span class="navbar-text px-3 text-white">PC WORTH ADMIN DASHBOARD</span>
  </nav>

  <div class="container-fluid">
    <div class="row">

      <!-- Sidebar -->
      <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
        <div class="position-sticky pt-3">
          <ul class="nav flex-column">
            <li class="nav-item">
              <button class="Dropdown-Btn" onclick="toggleDropdown(this)">Inventory</button>
              <div class="Dropdown-content" id="Inventory_Dropdown">
                <a href="#" onclick="animateClick(this); showForms('Products')">&#9733; Products</a>
                <a href="#" onclick="animateClick(this); showForms('Edit_Product_Information')">Edit Product Information</a>
                <a href="#" onclick="animateClick(this); showForms('option3')">Option 3</a>
              </div>
            </li>
          </ul>
        </div>
      </nav>

      <!-- Main Content -->
      <main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <div id="WelcomePageText" style="display: block;">
            PC WORTH KIOSK ADMIN PAGE
          </div>
        </div>

        <div id="formsContainer">

          <!-- Add Product Form -->
          <div id="AddProductForms" style="display: none;">
            <h1>ADD PRODUCT</h1>

<!--Medyo gray na nakapaligid sa mga form-->
<div class="form-wrapper">


           <!-- === FORM START === -->
<form id="productForm" method="POST" action="test_insert.php" enctype="multipart/form-data">
    <div class="input-group">
      <div class="input-field">
          <p>Product Display Name</p>
          <input id="product_display_name" name="product_display_name" type="text" placeholder="Display_name" required>
      </div>
  
      <div class="input-field">
        <p>Price</p>
        <input id="price" type="number" placeholder="price" required>
      </div>
    </div>

    <div class="input-group">
      <div class="input-field">
          <p>Product Category</p>
          <select id="category" name="category" required>
            <option value="">Select Category</option>
            <option value="CPU">CPU</option>
            <option value="GPU">Graphics Card</option>
            <option value="MOBO">Motherboard</option>
            <option value="RAM">Random access memory</option>
            <option value="SSD">Solid State Drive</option>
            <option value="HDD">Hard Disk Drive</option>
            <option value="PSU">Power Supply</option>
            <option value="HEATSINK">Heat Sink</option>
            <option value="CASE">Case</option>
            <option value="CASE FANS">Case Fans</option>
            <option value="accessories">Accessories</option>
          </select>
      </div>
      <div class="input-field" required>
          <p>Manufacturer</p>
          <input id="manufacturer" name="manufacturer" type="text" placeholder="manufacturer">
      </div>
   </div>

      
        <p>Product Specifications</p>
        <textarea class ="style_box" id="product_specifications" name="product_specifications" placeholder="Product Specifications here" required ></textarea>

        <p>Product Description</p>
        <textarea class ="style_box" id="product_description" name="product_description" placeholder="Product Description here." required></textarea>
  

    <br><br>
        <p>
          <input type="checkbox" id="status" name="status" > Hide product on kiosk
        </p>
    
    
    <br>
    <br>
        <p>Current Image:</p><br>
        <img src="<?= htmlspecialchars($product['image_url']) ?>" width="250"><br>
        <!-- Label triggers hidden input -->
          <br><br>
        <label for="immage" class="custom-upload">Choose Image</label>
        <input id="immage" name="immage" type="file" accept=".png, .jpg, .jpeg" required ><br><br>
    

    <div class="input-group">
      <div class="input-field">
        <p>Warranty Duration</p>
          <input type="text" placeholder="365 Days" id="warranty_duration" name="warranty_duration" required >
      </div>

      <div class="input-field">
        <p>UID / Tracking number</p>
          <input type="text" placeholder="###" id="UID" name="UID" required >
      </div>
    </div>

        <p>Quantity / Available in stock</p>
        <input type="text" placeholder="###" id="quantity" name="quantity" required>
<br>
<br>
        <button type="submit" class="new-Product-save">Save</button>
<br>
<br>
</form>
<!--=== Form ends === -->
    </div>
          </div>

          <!-- Custom Prompt -->
          <div id="customPrompt" class="prompt-overlay">
            <div class="prompt-box">
              <p>New product saved!</p>
              <button onclick="closePrompt()">OK</button>
            </div>
          </div>

          <!-- Edit Product Section -->
          <div id="EditProduct" style="display: none;">
            <h1>EDIT PRODUCT INFORMATION</h1>
            <form class="d-flex mb-3">
              <input class="form-control me-2" type="search" placeholder="Search..." aria-label="Search">
              <button class="btn btn-primary" type="submit">Search</button>
            </form>
          </div>

          <!-- Option 3 -->
          <div id="option3Content" style="display: none;">
            <p>Option 3 content here.</p>
          </div>

        </div>
      </main>
    </div>
  </div>

</body>

</html>
