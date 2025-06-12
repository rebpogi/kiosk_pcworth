<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Custom Build Selection</title>
  <link rel="stylesheet" href="customb.css" />
  <style>
    .product-name, .product-details, .product-price {
      vertical-align: top;
    }

    .change-button, .add-button, .delete-button, .bottom-button {
      padding: 10px 18px;
      font-size: 1rem;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      margin-top: 5px;
      font-weight: bold;
    }

    .change-button {
      background-color: #0066cc;
      color: white;
    }

    .add-button {
      background-color: #007bff;
      color: white;
    }

    .delete-button {
      background-color: #dc3545; /* red */
      color: white;
    }

    .change-button:hover {
      background-color: #004999;
    }

    .add-button:hover {
      background-color: #0056b3;
    }

    .delete-button:hover {
      background-color: #a71d2a;
    }

    .section-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      max-width: 1200px;
      margin: 40px auto 20px auto;
      padding: 0 20px;
    }

    .section-header h2 {
      font-size: 28px;
    }

    .clearall {
      padding: 10px 16px;
      font-size: 1rem;
      background-color: #dc3545;
      color: white;
      border: none;
      border-radius: 6px;
      font-weight: bold;
      cursor: pointer;
    }

    .clearall:hover {
      background-color: #a71d2a;
    }

    .total-price {
      text-align: right;
      font-size: 1.4rem;
      font-weight: bold;
      margin-right: 40px;
      margin-top: 10px;
    }

    .bottom-actions {
      display: flex;
      justify-content: center;
      gap: 30px;
      margin: 40px 0;
    }

    .bottom-button {
      padding: 16px 30px;
      font-size: 24px;
      border-radius: 10px;
      font-weight: bold;
      transition: background-color 0.3s ease;
    }

    .bottom-button:first-child {
      background-color: #dc3545; /* Red for Return */
      color: white;
    }

    .bottom-button:last-child {
      background-color: #007bff; /* Blue for Add to Cart */
      color: white;
    }

    .bottom-button:first-child:hover {
      background-color: #a71d2a;
    }

    .bottom-button:last-child:hover {
      background-color: #0056b3;
    }
  </style>
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
    <h2>| Custom Build</h2>
    <div class="icons">
      <button onclick="location.href='secmainkiosk.php'">
        <img src="resource/home.png" alt="Home">
      </button>
        <button onclick="location.href='viewcart.php'" class="cart-button">
      <img src="resource/cart.png" alt="Cart">
      </button>
    </div>
  </nav>

  <!-- Aligned header and clear button -->
  <div class="section-header">
    <h2>Your Custom Build</h2>
    <button class="clearall" onclick="clearAllComponents()">Clear All</button>
  </div>

  <table class="build-table" aria-label="PC Build Components Table">
    <thead>
      <tr>
        <th scope="col">Component</th>
        <th scope="col">Product</th>
        <th scope="col">Details</th>
        <th scope="col">Price</th>
        <th scope="col">Action</th>
      </tr>
    </thead>
    <tbody id="buildTableBody">
      <!-- Component rows will be injected here -->
    </tbody>
  </table>

  <div class="total-price" id="totalPrice">Total: ₱0.00</div>

  <div class="bottom-actions">
    <button class="bottom-button" onclick="window.history.back()">Return</button>
    <button class="bottom-button" onclick="addToCart()">Add to Cart</button>

  </div>

  <script>
    const components = [
      { key: 'cpu', label: 'CPU', icon: 'cpu.png' },
      { key: 'mobo', label: 'Motherboard', icon: 'mobo.png' },
      { key: 'gpu', label: 'GPU', icon: 'gpu.png' },
      { key: 'ram', label: 'RAM', icon: 'ram.png' },
      { key: 'storage', label: 'Storage', icon: 'storage.png' },
      { key: 'case', label: 'Case', icon: 'case.png' },
      { key: 'psu', label: 'PSU', icon: 'psu.png' },
      { key: 'cpucooler', label: 'CPU Cooler', icon: 'cpu cooler.png' },
      { key: 'fan', label: 'Case Fan', icon: 'Casefan.png' },
      { key: 'monitor', label: 'Monitor', icon: 'Monitor.png' },
      { key: 'mouse', label: 'Mouse', icon: 'Mouse.png' },
      { key: 'keyboard', label: 'Keyboard', icon: 'Keyboard.png' }
    ];

    const buildTableBody = document.getElementById("buildTableBody");
    let total = 0;

    components.forEach(comp => {
      const product = sessionStorage.getItem(comp.key);
      const row = document.createElement("tr");
      row.setAttribute("data-component", comp.label);

      let html = `<td><img src="resource/${comp.icon}" alt="${comp.label} Icon" /></td>`;

      if (product) {
        const data = JSON.parse(product);
        const price = parseFloat(data.price);
        total += price;

        html += `
          <td class="product-name">${data.product_display_name}</td>
          <td class="product-details">${data.product_description}</td>
          <td class="product-price">₱${price.toLocaleString(undefined, {minimumFractionDigits: 2})}</td>
          <td>
            <button class="change-button" onclick="location.href='component_list.php?component=${comp.key}'">Change</button><br/>
            <button class="delete-button" onclick="deleteComponent('${comp.key}')">Delete</button>
          </td>
        `;
      } else {
        html += `
          <td class="product-name" colspan="4">
            <button class="add-button" onclick="location.href='component_list.php?component=${comp.key}'">+ ADD COMPONENT</button>
          </td>
        `;
      }

      row.innerHTML = html;
      buildTableBody.appendChild(row);
    });

    document.getElementById("totalPrice").textContent = `Total: ₱${total.toLocaleString(undefined, {minimumFractionDigits: 2})}`;

    function clearAllComponents() {
      components.forEach(c => sessionStorage.removeItem(c.key));
      location.reload();
    }

    function deleteComponent(key) {
      sessionStorage.removeItem(key);
      location.reload();
    }

            async function addToCart() {
        const components = [
          'cpu', 'mobo', 'gpu', 'ram', 'storage', 'case', 
          'psu', 'cpucooler', 'fan', 'monitor', 'mouse', 'keyboard'
        ];

        // For each component in sessionStorage, send POST to addtocart.php
        for (const key of components) {
          const itemStr = sessionStorage.getItem(key);
          if (!itemStr) continue;

          const item = JSON.parse(itemStr);

          // Prepare form data
          const formData = new FormData();
          formData.append('ID', item.ID);           // Make sure your sessionStorage item has 'ID'
          formData.append('quantity', 1);            // Set quantity as 1 for simplicity

          // Send POST request
          const response = await fetch('addtocart.php', {
            method: 'POST',
            body: formData
          });

          if (!response.ok) {
            alert('Failed to add some items to cart.');
            return;
          }
        }

        // After all items added, redirect to viewcart.php
        window.location.href = 'viewcart.php';
      }

      


  </script>
</body>
</html>
