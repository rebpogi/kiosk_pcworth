<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="preb.css">
  <title>PC Worth - Pre-Build</title>



<script>
function showSection(sectionId) {
  const brands = document.querySelectorAll('.brand');
  brands.forEach(brand => {
    brand.style.display = (brand.id === sectionId) ? 'block' : 'none';
  });
}

function searchBrand() {
  const input = document.getElementById("searchInput").value.toLowerCase();
  const brands = document.querySelectorAll('.brand');
  let found = false;

  brands.forEach(brand => {
    if (brand.id.includes(input)) {
      brand.style.display = "block";
      found = true;
    } else {
      brand.style.display = "none";
    }
  });

  if (!found) {
    alert("No brand matched your search.");
  }
}


let activeSection = 'asus'; // default

function setActiveSection(sectionId) {
  activeSection = sectionId;
  const brands = document.querySelectorAll('.brand');
  brands.forEach(brand => {
    brand.style.display = (brand.id === sectionId) ? 'block' : 'none';
  });
  filterContent(); // reapply search filter
}

function filterContent() {
  const input = document.getElementById('searchInput').value.toLowerCase();
  const activeBrand = document.getElementById(activeSection);
  const products = activeBrand.querySelectorAll('.product');

  products.forEach(product => {
    const text = product.textContent.toLowerCase();
    product.style.display = text.includes(input) ? 'block' : 'none';
  });
}
</script>

</head>
<body>

  <header>
    <div class="slideshow">
 <div class="slide">  <img src="resource/frame1.png"></div>
 <div class="slide"> <img src="resource/frame2.png"></div>
 <div class="slide">  <img src="resource/frame3.png"></div>
 <div class="slide">  <img src="resource/frame4.png"></div>
 <div class="slide">  <img src="resource/frame5.png"></div>
</div>
   
  </header>

  <nav>
  
    <img src="resource/logo1.png" class="logo">
    <h2>| Pre-Build</h2>
    <div class="icons">
     <button onclick="location.href='secmainkiosk.php'"> <img src="resource/home.png" alt="Home"> </button>
        <button onclick="location.href=' '"><img src="resource/cart.png" alt="Cart"></button>
    </div>
  </nav>

  <div class="container">
    <aside>
<!-- Section buttons -->
 <button  onclick="setActiveSection('all')" class="btl"><img class="btlimg5" src="resource/pcwg.png"></button>
 
<button  onclick="setActiveSection('asus')" class="btl"><img class="btlimg1" src="resource/asusl.png"></button>
<button  onclick="setActiveSection('msi')" class="btl"><img class="btlimg2" src="resource/msil.png"></button>
<button  onclick="setActiveSection('asrock')" class="btl"><img class="btlimg3" src="resource/asrl.png"></button>
<button  onclick="setActiveSection('gigabyte')" class="btl"><img class="btlimg4" src="resource/gigal.png"></button>
   </aside>



    <main>
      
<div style="margin-bottom: 20px;">
  <input type="text" id="searchInput" placeholder="Search brand..." />
  <button onclick="searchBrand()">Search</button>
</div>




<!-- Brand sections with products -->
<div class="brands">
  <div class="brand" id="asus">

<div class="product-card">
        <img src="resource/darkreaver.jpg" >
        <h3 class="cardfont" >Dark Reaver Build</h3>
        <div class="price">₱175,690.00</div>
        <div class="old-price">₱196,772.80</div>
        <a href="#" class="view-btn">View PC Details</a>
      </div>

  </div>

  <div class="brand" id="msi" style="display: none;">
  
  <div class="product-card">
        <img src="resource/eab.png" >
        <h3 class="cardfont">Eabab Build</h3>
        <div class="price">₱29,365.00</div>
        <div class="old-price">₱32,888.80</div>
        <a href="#" class="view-btn">View PC Details</a>
      </div>

  </div>

 <div class="brand" id="asrock" style="display: none;">

 <div class="product-card">
        <img src="resource/ss.png">
        <h3 class="cardfont">Sunshade Build</h3>
        <div class="price">₱24,995.00</div>
        <div class="old-price">₱27,994.40</div>
        <a href="#" class="view-btn">View PC Details</a>
      </div>


  </div>

<div class="brand" id="gigabyte" style="display: none;">

 <div class="product-card">
        <img src="resource/eab.png" >
        <h3 class="cardfont">Sobrang Latina Build</h3>
        <div class="price">₱47,161.00</div>
        <div class="old-price">52,820.32.00</div>
        <a href="#" class="view-btn">View PC Details</a>
      </div>


  </div>
  
  
  <div class="brand" id="all" style="display: none;">
    <div class="product">MSI B450 Tomahawk</div>
    <div class="product">MSI Z690 Edge</div>
  </div>

</div>
















    

      



      
    </main>
  </div>

</body>
</html>