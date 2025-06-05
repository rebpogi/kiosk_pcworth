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

    <main>
     

      <!-- Brand sections -->
      <div class="brand" id="allbrand" style="display: none;">
        <div class="product-grid"></div>
      </div>

      <div class="brand" id="asus" style="display: none;">
        <div class="product-grid">
          <div class="product-card">
            <img src="resource/darkreaver.jpg" alt="Dark Reaver Build" />
            <h3 class="cardfont">Dark Reaver Build</h3>
            <div class="price">₱175,690.00</div>
            <div class="old-price">₱196,772.80</div>
            <a href="#" class="view-btn">View PC Details</a>
          </div>
        </div>
      </div>

      <div class="brand" id="msi" style="display: none;">
        <div class="product-grid">
          <div class="product-card">
            <img src="resource/eab.png" alt="Eabab Build" />
            <h3 class="cardfont">Eabab Build</h3>
            <div class="price">₱29,365.00</div>
            <div class="old-price">₱32,888.80</div>
            <a href="#" class="view-btn">View PC Details</a>
          </div>
        </div>
      </div>

      <div class="brand" id="asrock" style="display: none;">
        <div class="product-grid">
          <div class="product-card">
            <img src="resource/ss.png" alt="Sunshade Build" />
            <h3 class="cardfont">Sunshade Build</h3>
            <div class="price">₱24,995.00</div>
            <div class="old-price">₱27,994.40</div>
            <a href="#" class="view-btn">View PC Details</a>
          </div>
        </div>
      </div>

      <div class="brand" id="gigabyte" style="display: none;">
        <div class="product-grid">
          <div class="product-card">
            <img src="resource/sbl.png" alt="Sobrang Latina Build" />
            <h3 class="cardfont">Sobrang Latina Build</h3>
            <div class="price">₱47,161.00</div>
            <div class="old-price">₱52,820.32</div>
            <a href="#" class="view-btn">View PC Details</a>
          </div>
        </div>
      </div>

    </main>
  </div>
</body>
</html>
