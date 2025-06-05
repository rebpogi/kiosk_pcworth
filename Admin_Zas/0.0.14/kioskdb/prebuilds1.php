<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>PC Worth Products</title>
  <link rel="stylesheet" href="your-style.css">
  <style>
    .product-card {
      border: 1px solid #ddd;
      border-radius: 10px;
      padding: 10px;
      width: 220px;
      text-align: center;
    }
    .product-card img {
      width: 100%;
      height: auto;
      border-radius: 5px;
    }
  </style>
</head>
<body>

  <header>
    <div class="slideshow">
      <div class="slide"><img src="resource/frame1.png" alt="Slide 1" /></div>
      <div class="slide"><img src="resource/frame2.png" alt="Slide 2" /></div>
      <div class="slide"><img src="resource/frame3.png" alt="Slide 3" /></div>
      <div class="slide"><img src="resource/frame4.png" alt="Slide 4" /></div>
      <div class="slide"><img src="resource/frame5.png" alt="Slide 5" /></div>
    </div>
  </header>

  <div class="container-fluid">
    <div class="row">
      <!-- Sidebar -->
      <div class="col-md-2">
       <div class="btn-group-vertical w-100">
  <button class="btn btn-primary my-1" onclick="filterByBrand('all')">All Brands</button>
  <button class="btn btn-outline-primary my-1" onclick="filterByBrand('ASUS')">ASUS</button>
  <button class="btn btn-outline-primary my-1" onclick="filterByBrand('MSI')">MSI</button>
  <button class="btn btn-outline-primary my-1" onclick="filterByBrand('ASRock')">ASRock</button>
  <button class="btn btn-outline-primary my-1" onclick="filterByBrand('Gigabyte')">Gigabyte</button>
</div>
      </div>

      <!-- Main content -->
      <div class="col-md-10">
        <!-- Banner -->
        <img src="your-banner.jpg" class="img-fluid" alt="Banner">

        <!-- Search box -->
        <input type="text" id="searchBox" placeholder="Search products..." class="form-control my-3">

        <!-- Product Grid -->
        <div id="product-container" class="d-flex flex-wrap justify-content-center gap-3 p-3">
          <!-- Cards will be injected here -->
        </div>
      </div>
    </div>
  </div>

  <script>
    // Fetch products from PHP
    fetch('fetch_prod.php')
      .then(response => response.json())
      .then(products => {
        const container = document.getElementById('product-container');
        container.innerHTML = '';

        products.forEach(p => {
          const card = `
            <div class="product-card">
              <img src="${p.image}" alt="${p.name}" />
              <h5>${p.name}</h5>
              <p>₱${parseFloat(p.price).toLocaleString()}</p>
            </div>
          `;
          container.innerHTML += card;
        });
      });

    // Optional: Filter products by name
    document.getElementById('searchBox').addEventListener('input', function () {
      const keyword = this.value.toLowerCase();
      document.querySelectorAll('.product-card').forEach(card => {
        const name = card.querySelector('h5').textContent.toLowerCase();
        card.style.display = name.includes(keyword) ? 'block' : 'none';
      });
    });
  </script>
</body>
</html>
