<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="customb.css" />
  <title>Custom Build</title>
 
</head>
<body>
  <!-- Header -->
  <header class="main-header">
    <img src="resource/logo1.png" alt="PC Worth Logo" class="logo" />
    <h1>Custom Build</h1>
    <div class="icons">
      <button onclick="location.href='secmainkiosk.php'">
        <img src="resource/home.png" alt="Home">
      </button>
      <button onclick="location.href=' '">
        <img src="resource/cart.png" alt="Cart">
      </button>
    </div>
    </div>
  </header>

  <!-- Table -->
  <table class="build-table" aria-label="PC Build Components Table">
    <thead>
      <tr>
        <th scope="col">Component</th>
        <th scope="col">Product</th>
        <th scope="col">Details</th>
        <th scope="col">Price</th>
      </tr>
    </thead>
    <tbody id="buildTableBody">
      <tr data-component="CPU">
        <td><img src="resource/cpu.png" alt="CPU Icon" /> </td>
        <td class="product-name" colspan="3">
          <button class="add-button" onclick="openPopup('CPU')">+ ADD COMPONENT</button>
        </td>
      </tr>
      <tr data-component="Motherboard">
        <td><img src="resource/mobo.png" alt="Motherboard Icon" /></td>
        <td class="product-name" colspan="3">
          <button class="add-button" onclick="openPopup('Motherboard')">+ ADD COMPONENT</button>
        </td>
      </tr>
      <tr data-component="GPU">
        <td><img src="resource/gpu.png" alt="GPU Icon" /></td>
        <td class="product-name" colspan="3">
          <button class="add-button" onclick="openPopup('GPU')">+ ADD COMPONENT</button>
        </td>
      </tr>
      <tr data-component="RAM">
        <td><img src="resource/ram.png" alt="RAM Icon" /> </td>
        <td class="product-name" colspan="3">
          <button class="add-button" onclick="openPopup('RAM')">+ ADD COMPONENT</button>
        </td>
      </tr>
      <tr data-component="Storage">
        <td><img src="resource/storage.png" alt="Storage Icon" /> </td>
        <td class="product-name" colspan="3">
          <button class="add-button" onclick="openPopup('Storage')">+ ADD COMPONENT</button>
        </td>
      </tr>
      <tr data-component="Case">
        <td><img src="resource/case.png" alt="Case Icon" /> </td>
        <td class="product-name" colspan="3">
          <button class="add-button" onclick="openPopup('Case')">+ ADD COMPONENT</button>
        </td>
      </tr>
      <tr data-component="PSU">
        <td><img src="resource/psu.png" alt="PSU Icon" /> </td>
        <td class="product-name" colspan="3">
          <button class="add-button" onclick="openPopup('PSU')">+ ADD COMPONENT</button>
        </td>
      </tr>
       <tr data-component="CPUCooler">
        <td><img src="resource/cpu cooler.png" alt="CPU Cooler Icon" /></td>
        <td class="product-name" colspan="3">
          <button class="add-button" onclick="openPopup('CPUCooler')">+ ADD COMPONENT</button>
        </td>
      </tr>

<tr data-component="CustomComponent"> 
  <td><img src="resource/CustomComponent.png" alt="CustomComponent" /></td> 
  <td class="product-name" colspan="3">
    <button class="add-button" onclick="openPopup('CustomComponent')">+ ADD CUSTOM COMPONENT</button>
  </td>
</tr>
      
    </tbody>
    
  </table>



  <!-- Checkout footer -->
  <footer class="checkout-footer" aria-label="Checkout Summary and Actions">
    <div class="subtotal">Subtotal: ₱0</div>
    <button class="checkout-btn" onclick="checkout()">Checkout</button>
  </footer>

  <!-- Popup -->
  <div id="componentPopup" class="popup-overlay hidden" role="dialog" aria-modal="true" aria-labelledby="popupTitle">
    <div class="popup-content">
      <div class="popup-header">
        <h3 id="popupTitle">Select Component</h3>
        <button class="popup-close-btn" aria-label="Close Popup" onclick="closePopup()">×</button>
      </div>
      <ul id="questionList" class="question-list" tabindex="0">
        <!-- Dynamic component options will appear here -->
      </ul>
    </div>
  </div>

<script  src="customb.js">
  

</script>
</body>
</html>
