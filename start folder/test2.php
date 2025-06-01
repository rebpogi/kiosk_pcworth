<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Custom PC Build</title>
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
      padding: 10px 20px;
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
      height: 40px;
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
  </style>
</head>
<body>

  <!-- Header -->
  <header class="main-header">
    <img src="logo.png" alt="PC Worth Logo" class="logo" />
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
    </tbody>
  </table>

  <!-- Popup -->
  <div class="popup-overlay hidden" id="popupOverlay">
    <div class="popup-content">
      <div class="popup-header">
        <h3 id="popupTitle">Select Component</h3>
        <button class="popup-close-btn" onclick="closePopup()">×</button>
      </div>
      <ul class="question-list" id="questionList">
        <!-- Options injected dynamically here -->
      </ul>
    </div>
  </div>

  <!-- Checkout Footer -->
  <footer class="checkout-footer">
    <div class="subtotal">SUBTOTAL: <span id="subtotalPrice">₱0.00</span></div>
    <button class="checkout-btn" onclick="checkout()">Checkout</button>
  </footer>

  <script>
    // Data for all components and their selection flows
    const componentData = {
      CPU: {
        steps: [
          {
            question: "Select CPU Brand",
            key: "brand",
            options: [
              { id: "Intel", name: "Intel", img: "https://upload.wikimedia.org/wikipedia/commons/c/c9/Intel-logo.svg" },
              { id: "AMD", name: "AMD", img: "https://upload.wikimedia.org/wikipedia/commons/2/24/AMD_logo.svg" },
            ]
          },
          {
            question: "Select CPU Model",
            key: "model",
            Intel: [
              { id: "i3", name: "Intel Core i3", img: "https://via.placeholder.com/80?text=i3" },
              { id: "i5", name: "Intel Core i5", img: "https://via.placeholder.com/80?text=i5" },
              { id: "i7", name: "Intel Core i7", img: "https://via.placeholder.com/80?text=i7" },
              { id: "i9", name: "Intel Core i9", img: "https://via.placeholder.com/80?text=i9" },
            ],
            AMD: [
              { id: "Ryzen3", name: "Ryzen 3", img: "https://via.placeholder.com/80?text=R3" },
              { id: "Ryzen5", name: "Ryzen 5", img: "https://via.placeholder.com/80?text=R5" },
              { id: "Ryzen7", name: "Ryzen 7", img: "https://via.placeholder.com/80?text=R7" },
              { id: "Ryzen9", name: "Ryzen 9", img: "https://via.placeholder.com/80?text=R9" },
            ],
          },
          {
            question: "Select CPU Generation or Socket",
            key: "gen_socket",
            Intel: [
              { id: "10th Gen", name: "10th Generation", img: "https://via.placeholder.com/80?text=10thGen", priceBase: 6000 },
              { id: "11th Gen", name: "11th Generation", img: "https://via.placeholder.com/80?text=11thGen", priceBase: 6500 },
              { id: "12th Gen", name: "12th Generation", img: "https://via.placeholder.com/80?text=12thGen", priceBase: 7000 },
              { id: "13th Gen", name: "13th Generation", img: "https://via.placeholder.com/80?text=13thGen", priceBase: 7500 },
            ],
            AMD: [
              { id: "AM4", name: "AM4 Socket", img: "https://via.placeholder.com/80?text=AM4", priceBase: 6000 },
              { id: "AM5", name: "AM5 Socket", img: "https://via.placeholder.com/80?text=AM5", priceBase: 7000 },
            ],
          }
        ],
        priceModifier: 1500 // add to priceBase for final price calculation
      },
      Motherboard: {
        question: "Select Motherboard",
        options: [
          { id: "MB1", name: "ASUS Prime B550M-A", img: "https://via.placeholder.com/80?text=MB1", details:"Micro ATX, AM4", price: 4500 },
          { id: "MB2", name: "MSI MAG Z690 Tomahawk", img: "https://via.placeholder.com/80?text=MB2", details:"ATX, LGA1700", price: 10500 },
          { id: "MB3", name: "Gigabyte B660M DS3H", img: "https://via.placeholder.com/80?text=MB3", details:"Micro ATX, LGA1700", price: 5200 },
        ]
      },
      GPU: {
        question: "Select GPU",
        options: [
          { id: "GPU1", name: "NVIDIA RTX 3060", img: "https://via.placeholder.com/80?text=RTX3060", details:"12GB GDDR6", price: 14000 },
          { id: "GPU2", name: "AMD RX 6600 XT", img: "https://via.placeholder.com/80?text=RX6600XT", details:"8GB GDDR6", price: 13000 },
          { id: "GPU3", name: "NVIDIA RTX 3070", img: "https://via.placeholder.com/80?text=RTX3070", details:"8GB GDDR6", price: 22000 },
        ]
      },
      RAM: {
        question: "Select RAM",
        options: [
          { id: "RAM1", name: "Corsair Vengeance 16GB", img: "https://via.placeholder.com/80?text=16GB", details:"DDR4 3200MHz", price: 4200 },
          { id: "RAM2", name: "G.Skill Trident Z 32GB", img: "https://via.placeholder.com/80?text=32GB", details:"DDR4 3600MHz", price: 8200 },
        ]
      },
      SSD: {
        question: "Select SSD",
        options: [
          { id: "SSD1", name: "Samsung 970 EVO 500GB", img: "https://via.placeholder.com/80?text=500GB", details:"NVMe M.2", price: 4200 },
          { id: "SSD2", name: "WD Blue 1TB", img: "https://via.placeholder.com/80?text=1TB", details:"SATA 3", price: 4100 },
        ]
      },
      Case: {
        question: "Select Case",
        options: [
          { id: "Case1", name: "NZXT H510", img: "https://via.placeholder.com/80?text=H510", details:"Mid Tower", price: 4000 },
          { id: "Case2", name: "Corsair 4000D", img: "https://via.placeholder.com/80?text=4000D", details:"Mid Tower", price: 4300 },
        ]
      },
      PSU: {
        question: "Select PSU",
        options: [
          { id: "PSU1", name: "Corsair RM650x", img: "https://via.placeholder.com/80?text=650W", details:"80+ Gold", price: 6200 },
          { id: "PSU2", name: "EVGA 600 BR", img: "https://via.placeholder.com/80?text=600W", details:"80+ Bronze", price: 3900 },
        ]
      }
    };


let currentComponent = null;
let currentStepIndex = 0;
let currentSelections = {};
const selectedProducts = {}; // Store final selection by component

const popupOverlay = document.getElementById('popupOverlay');
const questionList = document.getElementById('questionList');
const popupTitle = document.getElementById('popupTitle');
const subtotalPriceEl = document.getElementById('subtotalPrice');

function openPopup(component) {
  currentComponent = component;
  currentStepIndex = 0;
  currentSelections = {};
  popupOverlay.classList.remove('hidden');
  loadStep();
}

function closePopup() {
  popupOverlay.classList.add('hidden');
  questionList.innerHTML = '';
  popupTitle.textContent = 'Select Component';
}

// Load current step's options into popup
function loadStep() {
  questionList.innerHTML = '';
  const component = componentData[currentComponent];
  
  // Special case for CPU multi-step flow
  if (currentComponent === 'CPU') {
    const step = component.steps[currentStepIndex];
    popupTitle.textContent = step.question;

    let options = [];

    if (step.key === 'model') {
      // Depends on brand selected
      options = step[currentSelections.brand] || [];
    } else if (step.key === 'gen_socket') {
      options = step[currentSelections.brand] || [];
    } else {
      options = step.options || [];
    }

    options.forEach(opt => {
      const li = document.createElement('li');
      li.className = 'question-item';
      li.innerHTML = `
        <img src="${opt.img}" alt="${opt.name}" />
        <strong>${opt.name}</strong>
      `;
      li.onclick = () => {
        currentSelections[step.key] = opt.id;
        currentStepIndex++;
        if (currentStepIndex >= component.steps.length) {
          // Final selection done, calculate price and save
          saveCPUSelection();
          closePopup();
        } else {
          loadStep();
        }
      };
      questionList.appendChild(li);
    });

  } else {
    // Single step for other components
    popupTitle.textContent = component.question;
    component.options.forEach(opt => {
      const li = document.createElement('li');
      li.className = 'question-item';
      li.innerHTML = `
        <img src="${opt.img}" alt="${opt.name}" />
        <strong>${opt.name}</strong>
        <span class="price">₱${opt.price.toLocaleString()}</span>
      `;
      li.onclick = () => {
        selectedProducts[currentComponent] = opt;
        updateTableRow(currentComponent, opt);
        updateSubtotal();
        closePopup();
      };
      questionList.appendChild(li);
    });
  }
}

function saveCPUSelection() {
  const comp = componentData.CPU;
  // Calculate price based on selected gen/socket and priceModifier
  const genOptions = comp.steps[2][currentSelections.brand];
  const genSelection = genOptions.find(o => o.id === currentSelections.gen_socket);
  if (!genSelection) {
    alert('Invalid CPU generation/socket selection.');
    return;
  }

  // Base price + modifier
  const price = (genSelection.priceBase || 0) + comp.priceModifier;

  // Build product object with details summary
  const product = {
    id: `${currentSelections.brand}-${currentSelections.model}-${currentSelections.gen_socket}`,
    name: `${currentSelections.brand} ${currentSelections.model} ${currentSelections.gen_socket}`,
    img: genSelection.img,
    details: `CPU Brand: ${currentSelections.brand}, Model: ${currentSelections.model}, Gen/Socket: ${currentSelections.gen_socket}`,
    price: price
  };
  selectedProducts.CPU = product;
  updateTableRow('CPU', product);
  updateSubtotal();
}

function updateTableRow(component, product) {
  const row = document.querySelector(`tr[data-component="${component}"]`);
  if (!row) return;
  row.innerHTML = `
    <td><img src="${component.toLowerCase()}-icon.png" alt="${component} Icon" /> ${component}</td>
    <td class="product-name"><img src="${product.img}" alt="${product.name}" /> ${product.name}</td>
    <td>${product.details || ''}</td>
    <td>₱${product.price.toLocaleString()}</td>
  `;
}

function updateSubtotal() {
  let total = 0;
  for (const comp in selectedProducts) {
    total += selectedProducts[comp].price || 0;
  }
  subtotalPriceEl.textContent = `₱${total.toLocaleString()}.00`;
}

function checkout() {
  if (Object.keys(selectedProducts).length === 0) {
    alert("Please add at least one component before checking out.");
    return;
  }
  let summary = "Your build summary:\n\n";
  for (const comp in selectedProducts) {
    const p = selectedProducts[comp];
    summary += `${comp}: ${p.name} - ₱${p.price.toLocaleString()}\n`;
  }
  summary += `\nTotal: ${subtotalPriceEl.textContent}`;
  alert(summary);
}

// Close popup when clicking outside content
popupOverlay.addEventListener('click', (e) => {
  if (e.target === popupOverlay) closePopup();
});
  </script>

</body>
</html>
