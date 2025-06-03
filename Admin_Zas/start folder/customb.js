// Sample product data
  const products = {
    
    CPU: [
      { name: "AMD Ryzen 7 5700X", price: 11999, img: "resource/ryzen7.png", socket: "AM4" },
      { name: "Intel Core i5-12400F", price: 7999, img: "resource/i5-12400f.png", socket: "LGA1700" },
      { name: "Intel Core i7-12700K", price: 16500, img: "resource/i7-12700k.png", socket: "LGA1700" },
    ],
    Motherboard: [
      { name: "ASUS PRIME B550M-A", price: 6099, img: "resource/b550m-a.png", socket: "AM4", size: "Micro-ATX", ddr: "DDR4" },
      { name: "MSI MAG B660 TOMAHAWK", price: 8999, img: "resource/b660-tomahawk.png", socket: "LGA1700", size: "ATX", ddr: "DDR5" },
      { name: "Gigabyte Z690 AORUS PRO", price: 12999, img: "resource/z690-aorus.png", socket: "LGA1700", size: "ATX", ddr: "DDR5" },
    ],
    GPU: [
      { name: "NVIDIA RTX 3060 Ti", price: 19999, img: "resource/rtx3060ti.png", tier: "mid" },
      { name: "NVIDIA RTX 4070", price: 34999, img: "resource/rtx4070.png", tier: "high" },
      { name: "AMD RX 6600 XT", price: 13999, img: "resource/rx6600xt.png", tier: "budget" },
    ],
    RAM: [
      { name: "Corsair Vengeance 16GB DDR4", price: 4599, img: "resource/vengeance16.png", ddr: "DDR4" },
      { name: "G.SKILL Trident Z 32GB DDR5", price: 8999, img: "resource/tridentz32.png", ddr: "DDR5" },
      { name: "Kingston Fury 16GB DDR4", price: 4200, img: "resource/kingstonfury.png", ddr: "DDR4" },
    ],
    Storage: [
      {name: "Samsung 970 EVO 1TB",price: 5500,img: "resource/samsung970.png", gen: "Gen3",socket: "M.2 NVMe"},
      {name: "Crucial P3 2TB",price: 8500, img: "resource/crucialp3.png", gen: "Gen3", socket: "M.2 NVMe"},
      {name: "WD Blue SN570 1TB",price: 4500,img: "resource/wdblue.png",gen: "Gen3 x4",socket: "M.2 NVMe"}
    ],
    Case: [
      { name: "NZXT H510", price: 4999, img: "resource/nzxt-h510.png", size: "ATX" },
      { name: "Cooler Master MasterBox Q300L", price: 3199, img: "resource/coolermaster-q300l.png", size: "Micro-ATX" },
      { name: "Corsair 4000D Airflow", price: 6500, img: "resource/corsair-4000d.png", size: "ATX" },
    ],
    PSU: [
      { name: "Corsair RM750x 750W", price: 7000, img: "resource/rm750x.png", wattage: 750 },
      { name: "EVGA 600 BR 600W", price: 3200, img: "resource/evga600w.png", wattage: 600 },
      { name: "Seasonic Focus GX-850 850W", price: 9500, img: "resource/seasonic850w.png", wattage: 850 },
    ],
    CPUCooler: [
      { name: "Cooler Master Hyper 212", price: 2500, img: "resource/cooler_hyper212.png", sockets: ["LGA1700", "AM4", "AM5"], size: "120mm" },
      { name: "Noctua NH-D15", price: 4500, img: "resource/cooler_noctua_nh_d15.png", sockets: ["LGA1700", "AM4", "AM5"], size: "165mm" },
      { name: "be quiet! Dark Rock Pro 4", price: 4300, img: "resource/cooler_darkrockpro4.png", sockets: ["LGA1700", "AM4"], size: "135mm" },
      { name: "DeepCool AK620", price: 3200, img: "resource/cooler_deepcool_ak620.png", sockets: ["LGA1700", "AM4", "AM5"], size: "120mm" },
      { name: "Arctic Freezer 34 eSports DUO", price: 2800, img: "resource/cooler_arctic34.png", sockets: ["LGA1700", "AM4", "AM5"], size: "120mm" }
    ],
    Casefan: [
      { name: "Cooler Master SickleFlow 120 ARGB", price: 599, img: "resource/sickleflow120.png", size: "120mm", type: "Single Fan" },
      { name: "Noctua NF-A12x25 PWM", price: 1399, img: "resource/noctua-a12.png", size: "120mm", type: "Single Fan" },
      { name: "ARCTIC F14 Silent", price: 499, img: "resource/arctic-f14.png", size: "140mm", type: "Single Fan" },
      { name: "Cooler Master SickleFlow 120", price: 500, img: "resource/sickleflow.png", type: "Single Fan", size: "120mm" },
      { name: "Lian Li UNI FAN SL120 3in1", price: 2500, img: "resource/unifan3in1.png", type: "3in1", size: "120mm" } 
    ],

    Monitor: [
      { name: "AOC 24G2 24'' 144Hz IPS", price: 8999, img: "resource/aoc-24g2.png", size: "24\"", refreshRate: "144Hz" },
      { name: "ASUS TUF VG27AQ 27'' 165Hz", price: 15999, img: "resource/asus-vg27aq.png", size: "27\"", refreshRate: "165Hz" },
      { name: "Samsung Odyssey G5 32'' 144Hz", price: 17999, img: "resource/odyssey-g5.png", size: "32\"", refreshRate: "144Hz" },
    ],
    Mouse: [
      { name: "Logitech G502 HERO", price: 2799, img: "resource/g502hero.png", type: "Wired" },
      { name: "Razer DeathAdder V2", price: 2499, img: "resource/deathadderv2.png", type: "Wired" },
      { name: "Logitech G Pro Wireless", price: 5999, img: "resource/gprowireless.png", type: "Wireless" },
    ],

    Keyboard: [
      { name: "Redragon K552 Kumara", price: 1899, img: "resource/k552kumara.png", type: "Mechanical", switch: "Red" },
      { name: "Razer BlackWidow V3", price: 4999, img: "resource/blackwidowv3.png", type: "Mechanical", switch: "Green" },
      { name: "Logitech G213 Prodigy", price: 2999, img: "resource/g213.png", type: "Membrane", switch: "Membrane" },
    ],



  };

  // Selected components stored here
  const selectedComponents = {
    CPU: null,
    Motherboard: null,
    GPU: null,
    RAM: null,
    Storage: null,
    Case: null,
    PSU: null,
    CPUCooler: null,
    Casefan: null,
    Monitor: null,
    Mouse: null,
    Keyboard: null,

  };

  let currentComponent = null;

  // Open Popup and load component options
  function openPopup(component) {
    currentComponent = component;
    const popup = document.getElementById("componentPopup");
    const title = document.getElementById("popupTitle");
    const list = document.getElementById("questionList");
    list.innerHTML = ""; // clear previous

    title.textContent = `Select ${component}`;

    // Filter options if needed for compatibility
    let filteredProducts = products[component] || [];

    // Example: Filter Motherboard by CPU socket if CPU selected
    if (component === "Motherboard" && selectedComponents.CPU) {
      const cpuSocket = selectedComponents.CPU.socket;
      filteredProducts = filteredProducts.filter(p => p.socket === cpuSocket);
    }
    // Example: Filter RAM by motherboard DDR type
    if (component === "RAM" && selectedComponents.Motherboard) {
      const mbDDR = selectedComponents.Motherboard.ddr;
      filteredProducts = filteredProducts.filter(p => p.ddr === mbDDR);
    }

    // Create list items for options
    if (filteredProducts.length === 0) {
      const li = document.createElement("li");
      li.textContent = "No compatible options available.";
      list.appendChild(li);
    } else {
      filteredProducts.forEach(product => {
        const li = document.createElement("li");
        li.className = "question-item";
        li.tabIndex = 0;
        li.setAttribute("role", "button");
        li.setAttribute("aria-pressed", "false");

        li.innerHTML = `
          <img src="${product.img}" alt="${product.name}" />
          <strong>${product.name}</strong>
          <span class="price">₱${product.price.toLocaleString()}</span>
        `;

        li.onclick = () => {
          selectComponent(component, product);
          closePopup();
        };
        li.onkeydown = (e) => {
          if (e.key === "Enter" || e.key === " ") {
            e.preventDefault();
            selectComponent(component, product);
            closePopup();
          }
        };

        list.appendChild(li);
      });
    }

    popup.classList.remove("hidden");
    list.focus();
  }

  function closePopup() {
    const popup = document.getElementById("componentPopup");
    popup.classList.add("hidden");
  }

  // Update build table with selected component
  function selectComponent(component, product) {
    selectedComponents[component] = product;

    // Find table row
    const table = document.querySelector(".build-table");
    const row = table.querySelector(`tbody tr[data-component="${component}"]`);
    if (!row) return;

    // Update row with product info and price
    row.innerHTML = `
      <td><img src="resource/${component.toLowerCase()}.png" alt="${component} Icon" /> </td>
      <td class="product-name">${product.name}</td>
      <td class="product-details">
        ${getComponentDetails(component, product)}
      </td>
      <td class="product-price">₱${product.price.toLocaleString()}</td>
    `;










    
    // Add a "Change" button for replacing the component
const changeBtn = document.createElement("button");
changeBtn.title = "Change";
changeBtn.classList.remove("add-button"); // remove old style
changeBtn.classList.add("change-button"); // new style if needed

// Style the button itself
changeBtn.style.height = "40px";
changeBtn.style.width = "40px";
changeBtn.style.margin = "10px";
changeBtn.style.padding = "0";
changeBtn.style.border = "none";
changeBtn.style.backgroundColor = "transparent";
changeBtn.style.cursor = "pointer";
changeBtn.style.display = "inline";
changeBtn.style.alignItems = "left";
changeBtn.style.justifyContent = "left";

// Add and style the image
const img = document.createElement("img");
img.src = "resource/recycle.png";
img.alt = "Change";
img.style.width = "38px";
img.style.height = "38px";
img.style.margin = "0"; // Corrected the typo and adjusted layout

changeBtn.appendChild(img);

// Handle click
changeBtn.onclick = () => openPopup(component);

// Add to DOM
const tdPrice = row.querySelector(".product-price");
tdPrice.appendChild(changeBtn);


// Add Remove button
const removeBtn = document.createElement("button");
removeBtn.title = "Remove";
removeBtn.classList.add("remove-button");

removeBtn.textContent = "Remove";

removeBtn.style.height = "40px";
removeBtn.style.width = "100px";
removeBtn.style.margin = "10px";
removeBtn.style.color = "white";
removeBtn.style.backgroundColor = "rgb(223, 14, 14)";
removeBtn.style.fontSize = "20px";
removeBtn.style.border = "none";
removeBtn.style.cursor = "pointer";
removeBtn.style.display = "inline";
removeBtn.style.alignItems = "right";
removeBtn.style.justifyContent = "right";
removeBtn.onclick = () => {
  selectedComponents[component] = null;
  row.innerHTML = `
    <td><img src="resource/${component.toLowerCase()}.png" alt="${component} Icon" /></td>
    <td colspan="3"><button class="add-button" onclick="openPopup('${component}')">Add ${component}</button></td>
  `;
  updateSubtotal();
};

tdPrice.appendChild(removeBtn);
updateSubtotal();
  }

// CLEAR ALL FUNCTION
function clearAllComponents() {
  for (const key in selectedComponents) {
    selectedComponents[key] = null;

    const row = document.querySelector(`tr[data-component="${key}"]`);
    if (row) {
      row.innerHTML = `
        <td><img src="resource/${key.toLowerCase()}.png" alt="${key} Icon" /></td>
        <td colspan="3">
          <button class="add-button" onclick="openPopup('${key}')">Add ${key}</button>
        </td>
      `;
    }
  }
  updateSubtotal();
}
// get component details//

function getComponentDetails(component, product) {
  switch (component) {
    case "CPU":
      return `Socket: ${product.socket}`;
    case "Motherboard":
      return `Socket: ${product.socket}, Size: ${product.size}, DDR: ${product.ddr}`;
    case "Storage":
      return `Socket: ${product.socket}, Gen: ${product.gen}`;
    case "RAM":
      return `Type: ${product.ddr}`;
    case "GPU":
      return `Tier: ${product.tier}`;
    case "Case":
      return `Size: ${product.size}`;
    case "PSU":
      return `Wattage: ${product.wattage}`;
    case "CPUCooler":
      return `Sockets: ${product.sockets.join(", ")}, Size: ${product.size}`;
    case "Casefan":
      return `Type: ${product.type}, Size: ${product.size}`;
    case "Monitor":
      return `Size: ${product.size}, Refresh Rate: ${product.refreshRate}`;
    case "Mouse":
      return `Type: ${product.type}`;
    case "Keyboard":
      return `Type: ${product.type}, Switch: ${product.switch}`;
    default:
      return "";
  }


    
  }

  // Calculate subtotal from selected components
  function updateSubtotal() {
    const subtotal = Object.values(selectedComponents)
      .filter(c => c !== null)
      .reduce((sum, item) => sum + item.price, 0);
    document.querySelector(".subtotal").textContent = `Subtotal: ₱${subtotal.toLocaleString()}`;
  }

  // Dummy checkout action
 function checkout() {
  const selectedItems = Object.entries(selectedComponents)
    .filter(([key, val]) => val !== null)
    .map(([key, val]) => ({
      component: key,
      name: val.name,
      price: val.price
    }));

  if (selectedItems.length === 0) {
    alert("Please select at least one component before checkout.");
    return;
  }

  const subtotal = selectedItems.reduce((sum, item) => sum + item.price, 0);

  // ✅ Option 1: Save to localStorage (frontend-only solution)
  localStorage.setItem('cart', JSON.stringify({
    items: selectedItems,
    subtotal: subtotal
  }));

  // ✅ Optional: Send to backend (requires server-side endpoint)
  
  fetch('/add-to-cart', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({
      items: selectedItems,
      subtotal: subtotal
    })
  })
  .then(response => response.json())
  .then(data => {
    alert("Items successfully sent to cart!");
  })
  .catch(error => {
    console.error('Error:', error);
    alert("Failed to send items to cart.");
  });
  

  // ✅ User feedback
  alert("Items sent to cart!\n" +
    selectedItems.map(i => `${i.component}: ${i.name}`).join("\n") +
    `\nSubtotal: ₱${subtotal.toLocaleString()}`);
}


  // Close popup if clicked outside content
  document.getElementById("componentPopup").addEventListener("click", (e) => {
    if (e.target.id === "componentPopup") {
      closePopup();
    }
  });

