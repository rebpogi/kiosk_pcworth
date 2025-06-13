<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="preb.css" />
  <title>PC Worth - Pre-Build</title>
  <script>
    let activeSection = 'allbrand';

    function setActiveSection(sectionId) {
      activeSection = sectionId;
      const brands = document.querySelectorAll('.brand');

      brands.forEach(brand => {
        brand.style.display = (brand.id === sectionId) ? 'block' : 'none';
      });

      if (sectionId === 'allbrand') {
        const allbrandDiv = document.querySelector('#allbrand .product-grid');
        if (!allbrandDiv) return;
        allbrandDiv.innerHTML = '';

        brands.forEach(brand => {
          if (brand.id !== 'allbrand') {
            const productCards = brand.querySelectorAll('.product-card');
            productCards.forEach(card => {
              allbrandDiv.appendChild(card.cloneNode(true));
            });
          }
        });
      }

      filterContent();
    }

    function filterContent() {
      const input = document.getElementById('searchInput').value.toLowerCase();
      const activeBrand = document.getElementById(activeSection);
      if (!activeBrand) return;

      const products = activeBrand.querySelectorAll('.product-card');
      products.forEach(product => {
        const text = product.textContent.toLowerCase();
        product.style.display = text.includes(input) ? 'block' : 'none';
      });
    }

    window.onload = () => {
      setActiveSection('allbrand');
    };
  </script>
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

  <nav>
    <img src="resource/logo1.png" class="logo" alt="Logo" />
    <h2>| Pre-Build</h2>
    <div class="icons">
      <button onclick="location.href='secmainkiosk.php'">
        <img src="resource/home.png" alt="Home" />
      </button>
      <button onclick="location.href=' '">
        <img src="resource/cart.png" alt="Cart" />
      </button>
    </div>
  </nav>

  <div class="container">
   <!-- Brand Filter Buttons (Lowercase IDs) -->
<aside>
  <button onclick="setActiveSection('allbrand')" class="btl">
    <img class="btlimg5" src="resource/pcwg.png" alt="All Brands" />
  </button>
  <button onclick="setActiveSection('asus')" class="btl">
    <img class="btlimg1" src="resource/asusl.png" alt="ASUS" />
  </button>
  <button onclick="setActiveSection('msi')" class="btl">
    <img class="btlimg2" src="resource/msil.png" alt="MSI" />
  </button>
  <button onclick="setActiveSection('asrock')" class="btl">
    <img class="btlimg3" src="resource/asrl.png" alt="ASRock" />
  </button>
  <button onclick="setActiveSection('gigabyte')" class="btl">
    <img class="btlimg4" src="resource/gigal.png" alt="Gigabyte" />
  </button>
</aside>

    </aside>

<?php
$conn = new mysqli('localhost', 'root', '', 'testing_backend');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$products_by_brand = [];
$sql = "SELECT * FROM prebuilt_pcs";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $brand_key = strtolower($row['brand']); // lowercase
        $products_by_brand[$brand_key][] = $row;
    }
}
?>



<!-- HTML layout here (same as yours up to the <main> tag) -->

<main>
<!-- All Brands Section -->
<div class="brand" id="allbrand">
  <div class="product-grid">
    <?php foreach ($products_by_brand as $brand => $products): ?>
      <?php foreach ($products as $product): ?>
        <div class="product-card">
          <img src="<?php echo $product['image_path']; ?>" alt="<?php echo $product['name']; ?>" />
          <h3 class="cardfont"><?php echo $product['name']; ?></h3>
          <div class="price">₱<?php echo number_format($product['promo_price'], 2); ?></div>
          <a href="#" class="view-btn">View PC Details</a>
        </div>
      <?php endforeach; ?>
    <?php endforeach; ?>
  </div>
</div>

<!-- Individual Brand Sections -->
<?php foreach ($products_by_brand as $brand => $products): ?>
  <div class="brand" id="<?php echo $brand; ?>" style="display: none;">
    <div class="product-grid">
      <?php foreach ($products as $product): ?>
        <div class="product-card">
          <img src="<?php echo $product['image_path']; ?>" alt="<?php echo $product['name']; ?>" />
          <h3 class="cardfont"><?php echo $product['name']; ?></h3>
          <div class="price">₱<?php echo number_format($product['promo_price'], 2); ?></div>
          <a href="#" class="view-btn">View PC Details</a>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
<?php endforeach; ?>

</main>

  </div>
</body>
</html>
