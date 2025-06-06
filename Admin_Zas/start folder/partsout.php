<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="partso.css" />
  <title>Parts Out</title>
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
            <button onclick="setActiveSection('monitor')" class="btl">
        <img class="btlimg3" src="resource/Monitor.png" alt="Fan">
      </button>
            <button onclick="setActiveSection('mouse')" class="btl">
        <img class="btlimg3" src="resource/Mouse.png" alt="Fan">
      </button>
            <button onclick="setActiveSection('keyboard')" class="btl">
        <img class="btlimg3" src="resource/Keyboard.png" alt="Fan">
      </button>
    </aside>

    <main>
     

      <div class="item" id="allitem" style="display: none;">
        <div class="product-grid"><!-- Filled by JS --></div>
      </div>

<?php
// Step 1: Connect to database
$conn = new mysqli('localhost', 'zas', 'group4', 'testing_backend');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Step 2: Query all products
$sql = "SELECT * FROM products";
$result = $conn->query($sql);

// Step 3: Output product cards
if ($result->num_rows > 0) {
while ($row = $result->fetch_assoc()) {
    // Step 4: Extract product data
    $name = htmlspecialchars($row['product_display_name']);
    $price = number_format($row['price'], 2);
    $image = htmlspecialchars($row['immage']); // Make sure it's the right column name!
    $uid = htmlspecialchars($row['UID']);

    // Optional: Generate old price (like 12% markup)
    $old_price = number_format($row['price'] * 1.12, 2);
    echo "
       
    <div class='product-grid'>
    <div class='product-card'>
        <img src='uploads/$image' alt='$name'>
        <h3 class='cardfont'>$name</h3>
        <div class='price'>₱$price</div>
        <div class='old-price'>₱$old_price</div>
        <a href='product_page.php?uid=$uid' class='view-btn'>View PC Details</a>
    </div>

     <div class='product-card'>
        <img src='uploads/$image' alt='$name'>
        <h3 class='cardfont'>$name</h3>
        <div class='price'>₱$price</div>
        <div class='old-price'>₱$old_price</div>
        <a href='product_page.php?uid=$uid' class='view-btn'>View PC Details</a>
    </div>

     <div class='product-card'>
        <img src='uploads/$image' alt='$name'>
        <h3 class='cardfont'>$name</h3>
        <div class='price'>₱$price</div>
        <div class='old-price'>₱$old_price</div>
        <a href='product_page.php?uid=$uid' class='view-btn'>View PC Details</a>
    </div>

     <div class='product-card'>
        <img src='uploads/$image' alt='$name'>
        <h3 class='cardfont'>$name</h3>
        <div class='price'>₱$price</div>
        <div class='old-price'>₱$old_price</div>
        <a href='product_page.php?uid=$uid' class='view-btn'>View PC Details</a>
    </div>
    </div>
    ";
}
} else {
echo "No products found.";
}

$conn->close();
?>

      <div class="item" id="gpu" style="display: none;">
        <div class="product-grid">

          <div class="product-card">
            <img src="resource/darkreaver.jpg" alt="Dark Reaver Build">
            <h3 class="cardfont">GeForce RTX 3060 Ti 12GB</h3>
            <div class="price">₱175,690.00</div>
            <div class="old-price">₱196,772.80</div>
            <a href="#" class="view-btn">View PC Details</a>
          </div>

          <div class="product-card">
            <img src="resource/darkreaver.jpg" alt="Dark Reaver Build">
            <h3 class="cardfont">GeForce RTX 3050 6GB</h3>
            <div class="price">₱175,690.00</div>
            <div class="old-price">₱196,772.80</div>
            <a href="#" class="view-btn">View PC Details</a>
          </div>

        </div>
      </div>

      <div class="item" id="cpu" style="display: none;">
        <div class="product-grid">

          <div class="product-card">
            <img src="resource/darkreaver.jpg" alt="Intel i7 9700F">
            <h3 class="cardfont">Intel i7 9700F</h3>
            <div class="price">₱15,690.00</div>
            <div class="old-price">₱17,772.80</div>
            <a href="#" class="view-btn">View Item Details</a>
          </div>

 <div class="product-card">
            <img src="resource/darkreaver.jpg" alt="Intel i7 9700F">
            <h3 class="cardfont">Intel i7 9700F</h3>
            <div class="price">₱15,690.00</div>
            <div class="old-price">₱17,772.80</div>
            <a href="#" class="view-btn">View Item Details</a>
          </div> <div class="product-card">
            <img src="resource/darkreaver.jpg" alt="Intel i7 9700F">
            <h3 class="cardfont">Intel i7 9700F</h3>
            <div class="price">₱15,690.00</div>
            <div class="old-price">₱17,772.80</div>
            <a href="#" class="view-btn">View Item Details</a>
          </div> <div class="product-card">
            <img src="resource/darkreaver.jpg" alt="Intel i7 9700F">
            <h3 class="cardfont">Intel i7 9700F</h3>
            <div class="price">₱15,690.00</div>
            <div class="old-price">₱17,772.80</div>
            <a href="#" class="view-btn">View Item Details</a>
          </div> <div class="product-card">
            <img src="resource/darkreaver.jpg" alt="Intel i7 9700F">
            <h3 class="cardfont">Intel i7 9700F</h3>
            <div class="price">₱15,690.00</div>
            <div class="old-price">₱17,772.80</div>
            <a href="#" class="view-btn">View Item Details</a>
          </div> <div class="product-card">
            <img src="resource/darkreaver.jpg" alt="Intel i7 9700F">
            <h3 class="cardfont">Intel i7 9700F</h3>
            <div class="price">₱15,690.00</div>
            <div class="old-price">₱17,772.80</div>
            <a href="#" class="view-btn">View Item Details</a>
          </div> <div class="product-card">
            <img src="resource/darkreaver.jpg" alt="Intel i7 9700F">
            <h3 class="cardfont">Intel i7 9700F</h3>
            <div class="price">₱15,690.00</div>
            <div class="old-price">₱17,772.80</div>
            <a href="#" class="view-btn">View Item Details</a>
          </div> <div class="product-card">
            <img src="resource/darkreaver.jpg" alt="Intel i7 9700F">
            <h3 class="cardfont">Intel i7 9700F</h3>
            <div class="price">₱15,690.00</div>
            <div class="old-price">₱17,772.80</div>
            <a href="#" class="view-btn">View Item Details</a>
          </div>


        </div>
      </div>

      <div class="item" id="mobo" style="display: none;">
        <div class="product-grid">
 <div class="product-card">
            <img src="resource/darkreaver.jpg" alt="Intel i7 9700F">
            <h3 class="cardfont">ASRock B550 Pro</h3>
            <div class="price">₱15,690.00</div>
            <div class="old-price">₱17,772.80</div>
            <a href="#" class="view-btn">View Item Details</a>
          </div>

      </div></div>

      <div class="item" id="ram" style="display: none;">
        <div class="product-grid">


      </div></div>
      <div class="item" id="storage" style="display: none;">
        <div class="product-grid">


      </div></div>
      <div class="item" id="psu" style="display: none;">
        <div class="product-grid">


      </div></div>
      <div class="item" id="case" style="display: none;">
        <div class="product-grid">

        
        </div></div>
      <div class="item" id="cpucooler" style="display: none;">
        <div class="product-grid">


        </div></div>
      <div class="item" id="fan" style="display: none;">
        <div class="product-grid">


        </div></div>
      <div class="item" id="monitor" style="display: none;">
        <div class="product-grid">


        </div></div>
              <div class="item" id="mouse" style="display: none;">
        <div class="product-grid">


        </div></div>
              <div class="item" id="Keyboard" style="display: none;">
        <div class="product-grid">


        </div></div>
    </main>
  </div>

  <script>
    let activeSection = 'allitem';

    function setActiveSection(sectionId) {
      activeSection = sectionId;
      const items = document.querySelectorAll('.item');

      items.forEach(item => {
        item.style.display = (item.id === sectionId) ? 'block' : 'none';
      });

      if (sectionId === 'allitem') {
        const allitemDiv = document.querySelector('#allitem .product-grid');
        allitemDiv.innerHTML = '';

        items.forEach(item => {
          if (item.id !== 'allitem') {
            const productCards = item.querySelectorAll('.product-card');
            productCards.forEach(card => {
              allitemDiv.appendChild(card.cloneNode(true));
            });
          }
        });
      }

      filterContent();
    }

    function filterContent() {
      const input = document.getElementById('searchInput').value.toLowerCase();
      const activeitem = document.getElementById(activeSection);
      if (!activeitem) return;

      const products = activeitem.querySelectorAll('.product-card');
      products.forEach(product => {
        const text = product.textContent.toLowerCase();
        product.style.display = text.includes(input) ? 'block' : 'none';
      });
    }

    window.onload = () => {
      setActiveSection('allitem');
    };
  </script>
</body>
</html>
