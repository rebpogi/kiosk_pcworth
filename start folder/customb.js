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
      { name: "Cooler Master Hyper 212", price: 2500, img: "resource/cooler_hyper212.png", sockets: ["LGA1700", "AM4", "AM5"] },
      { name: "Noctua NH-D15", price: 4500, img: "resource/cooler_noctua_nh_d15.png", sockets: ["LGA1700", "AM4", "AM5"] },
      { name: "be quiet! Dark Rock Pro 4", price: 4300, img: "resource/cooler_darkrockpro4.png", sockets: ["LGA1700", "AM4"] },
      { name: "DeepCool AK620", price: 3200, img: "resource/cooler_deepcool_ak620.png", sockets: ["LGA1700", "AM4", "AM5"] },
      { name: "Arctic Freezer 34 eSports DUO", price: 2800, img: "resource/cooler_arctic34.png", sockets: ["LGA1700", "AM4", "AM5"] }
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

const img = document.createElement("img");
img.src = "resource/recycle.png";
img.alt = "Change";
img.style.width = "38px";
img.style.height = "38px";
img.style.margin = "10ox";

changeBtn.appendChild(img);
changeBtn.onclick = () => openPopup(component);

const tdPrice = row.querySelector(".product-price");
tdPrice.appendChild(changeBtn);
    updateSubtotal();
  }
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
      return `Sockets: ${product.sockets}`;
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
    const selectedCount = Object.values(selectedComponents).filter(c => c !== null).length;
    if (selectedCount === 0) {
      alert("Please select at least one component before checkout.");
      return;
    }
    alert("Checkout successful! Total: " + document.querySelector(".subtotal").textContent);
  }

  // Close popup if clicked outside content
  document.getElementById("componentPopup").addEventListener("click", (e) => {
    if (e.target.id === "componentPopup") {
      closePopup();
    }
  });
//custom component //
function openAllItemsPopup() {
  const popup = document.getElementById("popup");
  const popupTitle = document.getElementById("popupTitle");
  const popupItems = document.getElementById("popupItems");

  popupTitle.textContent = "Select Any Component";
  popupItems.innerHTML = "";

  // Display all items from all categories
  for (const category in components) {
    components[category].forEach((product, index) => {
      const itemDiv = document.createElement("div");
      itemDiv.className = "popup-item";
      itemDiv.innerHTML = `
        <img src="${product.img}" alt="${product.name}">
        <div>
          <strong>${product.name}</strong><br>
          Price: ₱${product.price.toLocaleString()}<br>
          <small>${getComponentDetails(category, product)}</small>
        </div>
        <button onclick="selectCustomComponent('${category}', ${index})">Select</button>
      `;
      popupItems.appendChild(itemDiv);
    });
  }

  popup.style.display = "block";
}
function selectCustomComponent(component, index) {
  const product = components[component][index];
  selectedComponents[component] = product;

  updateTableRow(component, product);  // make sure this creates the row if it doesn't exist
  updateSubtotal();
  closePopup();
}

