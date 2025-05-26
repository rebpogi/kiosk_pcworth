<!DOCTYPE html> 
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="partso.css">

  <script>
    let activeSection = 'allitem'; // default

    function setActiveSection(sectionId) {
      activeSection = sectionId;
      const items = document.querySelectorAll('.item');
      items.forEach(item => {
        item.style.display = (item.id === sectionId) ? 'block' : 'none';
      });
      filterContent(); // reapply search filter
    }

    function filterContent() {
      const input = document.getElementById('searchInput').value.toLowerCase();
      const activeitem = document.getElementById(activeSection);
      if (!activeitem) return;
      // product-card is the class for products
      const products = activeitem.querySelectorAll('.product-card');

      products.forEach(product => {
        const text = product.textContent.toLowerCase();
        product.style.display = text.includes(input) ? 'block' : 'none';
      });
    }

    function searchitem() {
      const input = document.getElementById("searchInput").value.toLowerCase();
      const items = document.querySelectorAll('.item');
      let found = false;

      items.forEach(item => {
        if (item.id.includes(input)) {
          item.style.display = "block";
          found = true;
        } else {
          item.style.display = "none";
        }
      });

      if (!found) {
        alert("No item matched your search.");
      }
    }
  </script>
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
      <button onclick="location.href=' '">
        <img src="resource/cart.png" alt="Cart">
      </button>
    </div>
  </nav>

  <div class="container">
    <aside>
      <!-- Search input -->
      <input 
        type="text" 
        id="searchInput" 
        placeholder="Search products..." 
        oninput="filterContent()" 
        style="width: 100%; margin-bottom: 10px;"
      />

      <!-- Section buttons -->
      <button onclick="setActiveSection('allitem')" class="btl">
        <img class="btlimg1" src="resource/allitem.png" alt="All Items">
      </button>
      <button onclick="setActiveSection('gpu')" class="btl">
        <img class="btlimg1" src="resource/gpu.png" alt="GPU">
      </button>
      <button onclick="setActiveSection('cpu')" class="btl">
        <img class="btlimg1" src="resource/cpu.png" alt="CPU">
      </button>
      <button onclick="setActiveSection('mobo')" class="btl">
        <img class="btlimg2" src="resource/mobo.png" alt="Motherboard">
      </button>
      <button onclick="setActiveSection('ram')" class="btl">
        <img class="btlimg2" src="resource/ram.png" alt="RAM">
      </button>
      <button onclick="setActiveSection('storage')" class="btl">
        <img class="btlimg2" src="resource/storage.png" alt="Storage">
      </button>
      <button onclick="setActiveSection('psu')" class="btl">
        <img class="btlimg3" src="resource/psu.png" alt="PSU">
      </button>
      <button onclick="setActiveSection('case')" class="btl">
        <img class="btlimg3" src="resource/case.png" alt="Case">
      </button>
      <button onclick="setActiveSection('cpucooler')" class="btl">
        <img class="btlimg3" src="resource/cpu cooler.png" alt="CPU Cooler">
      </button>
      <button onclick="setActiveSection('fan')" class="btl">
        <img class="btlimg3" src="resource/fan.png" alt="Fan">
      </button>
    </aside>

    <main>
      <!-- Sections with products -->
      <div class="item" id="allitem" style="display:none;">
        <!-- Add all products here or logic to show all -->
        <!-- Example -->
        <div class="product-card">
          <img src="resource/darkreaver.jpg" alt="Dark Reaver Build">
          <h3 class="cardfont">Dark Reaver Build</h3>
          <div class="price">₱175,690.00</div>
          <div class="old-price">₱196,772.80</div>
          <a href="#" class="view-btn">View PC Details</a>
        </div>
      </div>

      <div class="item" id="gpu" style="display:none;">
        <div class="product-card">
          <img src="resource/darkreaver.jpg" alt="Dark Reaver Build">
          <h3 class="cardfont">Dark Reaver Build</h3>
          <div class="price">₱175,690.00</div>
          <div class="old-price">₱196,772.80</div>
          <a href="#" class="view-btn">View PC Details</a>
        </div>
      </div>

      <div class="item" id="cpu" style="display:none;">
        <!-- CPU products here -->
      </div>

      <div class="item" id="mobo" style="display:none;">
        <!-- Motherboard products here -->
      </div>

      <div class="item" id="ram" style="display:none;">
        <!-- RAM products here -->
      </div>

      <div class="item" id="storage" style="display:none;">
        <!-- Storage products here -->
      </div>

      <div class="item" id="psu" style="display:none;">
        <!-- PSU products here -->
      </div>

      <div class="item" id="case" style="display:none;">
        <!-- Case products here -->
      </div>

      <div class="item" id="cpucooler" style="display:none;">
        <!-- CPU cooler products here -->
      </div>

      <div class="item" id="fan" style="display:none;">
        <!-- Fan products here -->
      </div>
    </main>
  </div>

  <script>
    // Show default section on load
    window.onload = () => {
      setActiveSection('allitem');
    };
  </script>

</body>
</html>
