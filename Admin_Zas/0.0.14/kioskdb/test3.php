<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>PC Build Popup Selector</title>
<style>
  /* Reset */
  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Segoe UI', sans-serif;
  }
  body {
    background: #f0f2f5;
    min-height: 100vh;
    padding-bottom: 80px; /* for footer */
  }
  /* Header */
  .main-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 20px 20px;
    border-bottom: 2px solid #ccc;
    background: #fff;
  }
  .logo {
    height: 50px;
  }
  .header-icons button {
    background: none;
    border: none;
    font-size: 20px;
    margin-left: 10px;
    cursor: pointer;
  }
  /* Table */
  .build-table {
    width: 100%;
    max-width: 900px;
    margin: 20px auto;
    border-collapse: collapse;
    background: #fff;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
  }
  .build-table th, .build-table td {
    padding: 12px 10px;
    text-align: left;
    border-bottom: 1px solid #ddd;
    vertical-align: middle;
  }
  .build-table td img {
    height: 170px;
    margin-right: 10px;
    vertical-align: middle;
  }
  .add-button {
    background-color: #1962a3;
    color: #fff;
    padding: 8px 16px;
    border: none;
    border-radius: 6px;
    font-weight: bold;
    cursor: pointer;
    box-shadow: 2px 2px 5px #ccc;
    transition: background-color 0.3s;
  }
  .add-button:hover {
    background-color: #154a7b;
  }
  /* Centered Popup */
  .popup-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
  }
  .popup-overlay.hidden {
    display: none;
  }
  .popup-content {
    background: #fff;
    border-radius: 12px;
    width: 400px;
    max-width: 90vw;
    max-height: 80vh;
    overflow-y: auto;
    padding: 20px 25px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.3);
    display: flex;
    flex-direction: column;
  }
  .popup-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
  }
  .popup-header h3 {
    font-size: 22px;
    font-weight: 700;
    color: #1962a3;
  }
  .popup-close-btn {
    background: none;
    border: none;
    font-size: 26px;
    font-weight: bold;
    cursor: pointer;
    color: #888;
    transition: color 0.3s;
  }
  .popup-close-btn:hover {
    color: #1962a3;
  }
  /* Question list */
  .question-list {
    list-style: none;
    display: flex;
    flex-direction: column;
    gap: 15px;
  }
  .question-item {
    background: #f8f8f8;
    padding: 12px 15px;
    border-radius: 10px;
    cursor: pointer;
    transition: background-color 0.25s ease;
    display: flex;
    align-items: center;
    gap: 12px;
    border: 2px solid transparent;
  }
  .question-item:hover {
    background-color: #e6f0ff;
    border-color: #1962a3;
  }
  .question-item img {
    width: 60px;
    height: 60px;
    object-fit: contain;
    border-radius: 6px;
    background: white;
    box-shadow: 0 1px 5px rgba(0,0,0,0.1);
  }
  .question-item strong {
    font-size: 16px;
    flex-grow: 1;
    color: #222;
  }
  .question-item .price {
    font-weight: bold;
    color: #d10000;
    min-width: 85px;
    text-align: right;
  }
  /* Footer */
  .checkout-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: #1962a3;
    color: #fff;
    padding: 15px 20px;
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    max-width: 900px;
    margin: 0 auto;
    border-radius: 0 0 12px 12px;
    box-shadow: 0 -3px 6px rgba(0,0,0,0.2);
  }
  .subtotal {
    font-size: 18px;
    font-weight: 600;
  }
  .checkout-btn {
    background-color: #800000;
    color: #fff;
    font-size: 20px;
    padding: 8px 25px;
    border: none;
    border-radius: 12px;
    cursor: pointer;
    transition: background-color 0.3s;
  }
  .checkout-btn:hover {
    background-color: #5c0000;
  }
  .add-button.disabled {
    opacity: 0.5;
    cursor: not-allowed;
  }
</style>
</head>
<body>

  <!-- Header -->
  <header class="main-header">
    <img src="resource/logo1.png" alt="PC Worth Logo" class="logo" />
    <h1>Custom Build</h1>
    <div class="header-icons">
      <button class="home-icon">🏠</button>
      <button class="cart-icon">🛒</button>
    </div>
  </header>

  <!-- Table -->
  <table class="build-table">
    <thead>
      <tr>
        <th>Component</th>
        <th>Product</th>
        <th>Details</th>
        <th>Price</th>
      </tr>
    </thead>
    <tbody id="buildTableBody">
      <tr data-component="CPU">
        <td><img src="resource/cpu.png" alt="CPU Icon" /> CPU</td>
        <td class="product-name" colspan="3">
          <button class="add-button" onclick="openPopup('CPU')">+ ADD COMPONENT</button>
        </td>
      </tr>
      <tr data-component="Motherboard">
        <td><img src="resource/mobo.png" alt="Motherboard Icon" /> Motherboard</td>
        <td class="product-name" colspan="3">
          <button class="add-button" onclick="openPopup('Motherboard')">+ ADD COMPONENT</button>
        </td>
      </tr>
      <tr data-component="GPU">
        <td><img src="resource/gpu.png" alt="GPU Icon" /> GPU</td>
        <td class="product-name" colspan="3">
          <button class="add-button" onclick="openPopup('GPU')">+ ADD COMPONENT</button>
        </td>
      </tr>
      <tr data-component="RAM">
        <td><img src="resource/ram.png" alt="RAM Icon" /> RAM</td>
        <td class="product-name" colspan="3">
          <button class="add-button" onclick="openPopup('RAM')">+ ADD COMPONENT</button>
        </td>
      </tr>
      <tr data-component="SSD">
        <td><img src="resource/storage.png" alt="SSD Icon" /> SSD</td>
        <td class="product-name" colspan="3">
          <button class="add-button" onclick="openPopup('SSD')">+ ADD COMPONENT</button>
        </td>
      </tr>
      <tr data-component="Case">
        <td><img src="resource/case.png" alt="Case Icon" /> Case</td>
        <td class="product-name" colspan="3">
          <button class="add-button" onclick="openPopup('Case')">+ ADD COMPONENT</button>
        </td>
      </tr>
      <tr data-component="PSU">
        <td><img src="resource/psu.png" alt="PSU Icon" /> PSU</td>
        <td class="product-name" colspan="3">
          <button class="add-button" onclick="openPopup('PSU')">+ ADD COMPONENT</button>
        </td>
      </tr>
       <tr data-component="CPU Cooler">
        <td><img src="resource/cpu cooler.png" alt="CPU Cooler Icon" /> CPU Cooler</td>
        <td class="product-name" colspan="3">
          <button class="add-button" onclick="openPopup('CPU Cooler')">+ ADD COMPONENT</button>
        </td>
      </tr>
    </tbody>
  </table>

  <!-- Popup -->
  <div id="popupOverlay" class="popup-overlay hidden">
    <div class="popup-content">
      <div class="popup-header">
        <h3 id="popupTitle">Select Component</h3>
        <button class="popup-close-btn" onclick="closePopup()">×</button>
      </div>
      <ul id="questionList" class="question-list"></ul>
    </div>
  </div>

  <!-- Checkout Footer -->
  <footer class="checkout-footer">
    <div class="subtotal">Subtotal: ₱0.00</div>
    <button class="checkout-btn" onclick="checkout()">Check Out</button>
  </footer>

<script>
  // Component Data (You can add more products here)
  const data = {
    CPU: [
        



      { id: 'intel_i3_12th', brand: 'Intel', model: 'Core i3', generation: '12th Gen', socket: 'LGA1700', name: 'Intel Core i3-12100', img: 'resource/intel_i3_12th.png', price: 4800 },
      { id: 'intel_i3_13th', brand: 'Intel', model: 'Core i3', generation: '13th Gen', socket: 'LGA1700', name: 'Intel Core i3-13100', img: 'resource/intel_i3_13th.png', price: 4800 },
      { id: 'intel_i3_14th', brand: 'Intel', model: 'Core i3', generation: '14th Gen', socket: 'LGA1700', name: 'Intel Core i3-14100', img: 'resource/intel_i3_14th.png', price: 4800 },

      // Intel Core i5 (about 2x i3)
      { id: 'intel_i5_12th', brand: 'Intel', model: 'Core i5', generation: '12th Gen', socket: 'LGA1700', name: 'Intel Core i5-12400', img: 'resource/intel_i5_12th.png', price: 9600 },
      { id: 'intel_i5_13th', brand: 'Intel', model: 'Core i5', generation: '13th Gen', socket: 'LGA1700', name: 'Intel Core i5-13400', img: 'resource/intel_i5_13th.png', price: 9600 },
      { id: 'intel_i5_14th', brand: 'Intel', model: 'Core i5', generation: '14th Gen', socket: 'LGA1700', name: 'Intel Core i5-14400', img: 'resource/intel_i5_14th.png', price: 9600 },

      // Intel Core i7 (about 3.5x i3)
      { id: 'intel_i7_12th', brand: 'Intel', model: 'Core i7', generation: '12th Gen', socket: 'LGA1700', name: 'Intel Core i7-12700', img: 'resource/intel_i7_12th.png', price: 16800 },
      { id: 'intel_i7_13th', brand: 'Intel', model: 'Core i7', generation: '13th Gen', socket: 'LGA1700', name: 'Intel Core i7-13700', img: 'resource/intel_i7_13th.png', price: 16800 },
      { id: 'intel_i7_14th', brand: 'Intel', model: 'Core i7', generation: '14th Gen', socket: 'LGA1700', name: 'Intel Core i7-14700', img: 'resource/intel_i7_14th.png', price: 16800 },

      // Intel Core i9 (about 5x i3)
      { id: 'intel_i9_12th', brand: 'Intel', model: 'Core i9', generation: '12th Gen', socket: 'LGA1700', name: 'Intel Core i9-12900', img: 'resource/intel_i9_12th.png', price: 24000 },
      { id: 'intel_i9_13th', brand: 'Intel', model: 'Core i9', generation: '13th Gen', socket: 'LGA1700', name: 'Intel Core i9-13900', img: 'resource/intel_i9_13th.png', price: 24000 },
      { id: 'intel_i9_14th', brand: 'Intel', model: 'Core i9', generation: '14th Gen', socket: 'LGA1700', name: 'Intel Core i9-14900', img: 'resource/intel_i9_14th.png', price: 24000 },


      { id: 'intel_Ultra 5', brand: 'Intel', model: 'Core Ultra', generation: 'Ultra 5', socket: 'LGA1851', name: 'Intel Core Ultra 5 245T', img: 'resource/intel_ultra5.png', price: 11000 },
      { id: 'intel_Ultra 7', brand: 'Intel', model: 'Core Ultra', generation: 'Ultra 7', socket: 'LGA1851', name: 'Intel Core Ultra 7 265T', img: 'resource/intel_ultra7.png', price: 18000 },
      { id: 'intel_Ultra 9', brand: 'Intel', model: 'Core Ultra', generation: 'Ultra 9', socket: 'LGA1851', name: 'Intel Core Ultra 9 285T', img: 'resource/intel_ultra9.png', price: 28000 },

      // AMD Ryzen 3 Series (Budget)
      { id: 'amd_ryzen_3_3100', brand: 'AMD', model: 'AM4', generation: '3000 Series', socket: 'AM4', name: 'AMD Ryzen 3 3100', img: 'resource/amd_ryzen3_3100.png', price: 4500 },
      { id: 'amd_ryzen_3_4100', brand: 'AMD', model: 'AM4', generation: '4000 Series', socket: 'AM4', name: 'AMD Ryzen 3 4100', img: 'resource/amd_ryzen3_4100.png', price: 5200 },

      // AMD Ryzen 5 Series (Mainstream)
      { id: 'amd_ryzen_5_3600', brand: 'AMD', model: 'AM4', generation: '3000 Series', socket: 'AM4', name: 'AMD Ryzen 5 3600', img: 'resource/amd_ryzen5_3600.png', price: 7500 },
      { id: 'amd_ryzen_5_5600X', brand: 'AMD', model: 'AM4', generation: '5000 Series', socket: 'AM4', name: 'AMD Ryzen 5 5600X', img: 'resource/amd_ryzen5_5600x.png', price: 9000 },
      { id: 'amd_ryzen_5_7600X', brand: 'AMD', model: 'AM5', generation: '7000 Series', socket: 'AM5', name: 'AMD Ryzen 5 7600X', img: 'resource/amd_ryzen5_7600x.png', price: 9500 },

      // AMD Ryzen 7 Series (High Performance)
      { id: 'amd_ryzen_7_3700X', brand: 'AMD', model: 'AM4', generation: '3000 Series', socket: 'AM4', name: 'AMD Ryzen 7 3700X', img: 'resource/amd_ryzen7_3700x.png', price: 12000 },
      { id: 'amd_ryzen_7_5800X', brand: 'AMD', model: 'AM4', generation: '5000 Series', socket: 'AM4', name: 'AMD Ryzen 7 5800X', img: 'resource/amd_ryzen7_5800x.png', price: 15500 },
      { id: 'amd_ryzen_7_7700X', brand: 'AMD', model: 'AM5', generation: '7000 Series', socket: 'AM5', name: 'AMD Ryzen 7 7700X', img: 'resource/amd_ryzen7_7700x.png', price: 14500 },

      // AMD Ryzen 9 Series (Enthusiast)
      { id: 'amd_ryzen_9_3900X', brand: 'AMD', model: 'AM4', generation: '3000 Series', socket: 'AM4', name: 'AMD Ryzen 9 3900X', img: 'resource/amd_ryzen9_3900x.png', price: 18000 },
      { id: 'amd_ryzen_9_5900X', brand: 'AMD', model: 'AM4', generation: '5000 Series', socket: 'AM4', name: 'AMD Ryzen 9 5900X', img: 'resource/amd_ryzen9_5900x.png', price: 21000 },
      { id: 'amd_ryzen_9_7950X', brand: 'AMD', model: 'AM5', generation: '7000 Series', socket: 'AM5', name: 'AMD Ryzen 9 7950X', img: 'resource/amd_ryzen9_7950x.png', price: 28000 },


     
    ],


   Motherboard: [
  // Intel 12th/13th Gen LGA1700
  { id: 'asus_z690', brand: 'ASUS', model: 'Z690', socket: 'LGA1700', ddr: 'DDR5', name: 'ASUS ROG Strix Z690-F Gaming', img: 'resource/asus_z690.png', price: 14000 },
  { id: 'msi_z690', brand: 'MSI', model: 'Z690', socket: 'LGA1700', ddr: 'DDR4', name: 'MSI MAG Z690 Tomahawk WiFi', img: 'resource/msi_z690.png', price: 13000 },
  { id: 'gigabyte_z690', brand: 'Gigabyte', model: 'Z690', socket: 'LGA1700', ddr: 'DDR5', name: 'Gigabyte Z690 AORUS Master', img: 'resource/gigabyte_z690.png', price: 15000 },

  // Intel B660 (midrange)
  { id: 'asus_b660', brand: 'ASUS', model: 'B660', socket: 'LGA1700', ddr: 'DDR4', name: 'ASUS TUF Gaming B660-PLUS', img: 'resource/asus_b660.png', price: 7500 },
  { id: 'msi_b660', brand: 'MSI', model: 'B660', socket: 'LGA1700', ddr: 'DDR4', name: 'MSI PRO B660M-A DDR4', img: 'resource/msi_b660.png', price: 6800 },

  // AMD AM4 (3000-5000 series Ryzen)
  { id: 'asus_x570', brand: 'ASUS', model: 'X570', socket: 'AM4', ddr: 'DDR4', name: 'ASUS ROG Strix X570-E Gaming', img: 'resource/asus_x570.png', price: 14000 },
  { id: 'msi_x570', brand: 'MSI', model: 'X570', socket: 'AM4', ddr: 'DDR4', name: 'MSI MPG X570 Gaming Edge WiFi', img: 'resource/msi_x570.png', price: 12000 },
  { id: 'gigabyte_x570', brand: 'Gigabyte', model: 'X570', socket: 'AM4', ddr: 'DDR4', name: 'Gigabyte X570 AORUS Elite', img: 'resource/gigabyte_x570.png', price: 11500 },

  // AMD B550 (midrange)
  { id: 'asus_b550', brand: 'ASUS', model: 'B550', socket: 'AM4', ddr: 'DDR4', name: 'ASUS TUF Gaming B550-PLUS', img: 'resource/asus_b550.png', price: 7500 },
  { id: 'msi_b550', brand: 'MSI', model: 'B550', socket: 'AM4', ddr: 'DDR4', name: 'MSI B550-A PRO', img: 'resource/msi_b550.png', price: 7000 },

  // AMD AM5 (7000 series Ryzen)
  { id: 'asus_x670', brand: 'ASUS', model: 'X670', socket: 'AM5', ddr: 'DDR5', name: 'ASUS ROG Crosshair X670E Hero', img: 'resource/asus_x670.png', price: 21000 },
  { id: 'gigabyte_x670', brand: 'Gigabyte', model: 'X670', socket: 'AM5', ddr: 'DDR5', name: 'Gigabyte X670 AORUS Master', img: 'resource/gigabyte_x670.png', price: 20000 },


],




    // Add similar data for other components as needed
  };

  // Current build selections
  let build = {
    CPU: null,
    Motherboard: null,
    GPU: null,
    RAM: null,
    SSD: null,
    Case: null,
    PSU: null
  };

  // Popup state tracking
  let currentComponent = null;
  let currentStep = 0;
  let currentSelections = {};

  const popupOverlay = document.getElementById('popupOverlay');
  const popupTitle = document.getElementById('popupTitle');
  const questionList = document.getElementById('questionList');
  const buildTableBody = document.getElementById('buildTableBody');
  const subtotalEl = document.querySelector('.subtotal');

  // Open popup for given component
  function openPopup(component) {
    currentComponent = component;
    currentStep = 0;
    currentSelections = {};
    showStep();
    popupOverlay.classList.remove('hidden');
  }

  // Close popup and reset
  function closePopup() {
    popupOverlay.classList.add('hidden');
    questionList.innerHTML = '';
  }

  //----------------------------------------------------------------------//
  // Show current step of selection
  function showStep() {
    questionList.innerHTML = '';
    popupTitle.textContent = `Select ${currentComponent}`;

    if (currentComponent === 'CPU') {
      // Step 0: Select Brand
      if (currentStep === 0) {
        const brands = [...new Set(data.CPU.map(cpu => cpu.brand))];
        brands.forEach(brand => {
          const li = document.createElement('li');
          li.classList.add('question-item');
          li.textContent = brand;
          li.onclick = () => {
            currentSelections.brand = brand;
            currentStep++;
            showStep();
          };
          questionList.appendChild(li);
        });
      }
      // Step 1: Select Model (filter by brand)
      else if (currentStep === 1) {
        const models = [...new Set(data.CPU.filter(cpu => cpu.brand === currentSelections.brand).map(cpu => cpu.model))];
        models.forEach(model => {
          const li = document.createElement('li');
          li.classList.add('question-item');
          li.textContent = model;
          li.onclick = () => {
            currentSelections.model = model;
            currentStep++;
            showStep();
          };
          questionList.appendChild(li);
        });
      }
      // Step 2: Select Generation (filter by brand and model)
      else if (currentStep === 2) {
        const gens = [...new Set(data.CPU.filter(cpu => cpu.brand === currentSelections.brand && cpu.model === currentSelections.model).map(cpu => cpu.generation))];
        gens.forEach(gen => {
          const li = document.createElement('li');
          li.classList.add('question-item');
          li.textContent = gen;
          li.onclick = () => {
            currentSelections.generation = gen;
            currentStep++;
            showStep();
          };
          questionList.appendChild(li);
        });
      }
      // Step 3: Select Product (filter by brand, model, generation)
      else if (currentStep === 3) {
        const products = data.CPU.filter(cpu =>
          cpu.brand === currentSelections.brand &&
          cpu.model === currentSelections.model &&
          cpu.generation === currentSelections.generation
        );
        products.forEach(prod => {
          const li = document.createElement('li');
          li.classList.add('question-item');
          li.innerHTML = `
            <img src="${prod.img}" alt="${prod.name}">
            <strong>${prod.name}</strong>
            <span class="price">₱${prod.price.toLocaleString()}</span>
          `;
          li.onclick = () => {
            build.CPU = prod;
            updateBuildTable('CPU');
            closePopup();
          };
          questionList.appendChild(li);
        });
      }
    }


else if (currentComponent === 'Motherboard') {
  // Show all motherboards without filtering
  const motherboards = data.Motherboard;

  componentList.innerHTML = ''; // Clear existing list

  motherboards.forEach(mobo => {
    const li = document.createElement('li');
    li.classList.add('question-item');
    li.innerHTML = `
      <img src="${mobo.img}" alt="${mobo.name}">
      <strong>${mobo.name}</strong>
      <span class="price">₱${mobo.price.toLocaleString()}</span>
    `;
    li.onclick = () => {
      build.Motherboard = mobo;
      updateBuildTable('Motherboard');
      closePopup();
    };
    componentList.appendChild(li);
  });
}



    else {
      // Simple product add for components without complex steps
      questionList.innerHTML = '<li>Component selection not yet implemented.</li>';
    }
  }









  // Update the table row with selected product info
  function updateBuildTable(component) {
    const row = buildTableBody.querySelector(`tr[data-component="${component}"]`);
    if (!row) return;

    if (build[component]) {
      const prod = build[component];
      row.innerHTML = `
        <td><img src="resource/${component.toLowerCase()}.png" alt="${component} Icon" /> ${component}</td>
        <td class="product-name" colspan="1">${prod.name}</td>
        <td>Details here</td>
        <td>₱${prod.price.toLocaleString()}</td>
      `;
    } else {
      row.innerHTML = `
        <td><img src="resource/${component.toLowerCase()}.png" alt="${component} Icon" /> ${component}</td>
        <td class="product-name" colspan="3">
          <button class="add-button" onclick="openPopup('${component}')">+ ADD COMPONENT</button>
        </td>
      `;
    }

    updateSubtotal();
  }

  // Calculate and update subtotal price
  function updateSubtotal() {
    let sum = 0;
    for (const key in build) {
      if (build[key] && build[key].price) {
        sum += build[key].price;
      }
    }
    subtotalEl.textContent = `Subtotal: ₱${sum.toLocaleString()}.00`;
  }

  // Checkout function placeholder
  function checkout() {
    alert('Checkout clicked! Implement checkout logic here.');
  }
function updateBuildSummary() {
    const summary = document.getElementById('build-summary');
    let summaryText = '';

    const selectedCPU = document.getElementById('cpu-select').value;
    if (selectedCPU) {
        const cpuDetails = cpuData.find(cpu => cpu.name === selectedCPU);
        if (cpuDetails) {
            summaryText += `CPU: ${cpuDetails.name} (Socket: ${cpuDetails.socket})\n`;
        }
    }

    

   
    summary.value = summaryText.trim();
}






</script>

</body>
</html>
