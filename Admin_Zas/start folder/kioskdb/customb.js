function openPopup(category) {
  // Redirect to another page instead of opening a popup
  window.location.href = `component_list.php?category=${encodeURIComponent(category)}`;
}

function updateSubtotal() {
  let subtotal = 0;
  document.querySelectorAll("tbody tr").forEach(row => {
    const priceCell = row.cells[3];
    if (priceCell && priceCell.textContent.startsWith('₱')) {
      const price = parseFloat(priceCell.textContent.replace(/[₱,]/g, ""));
      subtotal += price;
    }
  });
  document.querySelector(".subtotal").textContent = `Subtotal: ₱${subtotal.toLocaleString()}`;
}

function clearAllComponents() {
  document.querySelectorAll("tbody tr").forEach(row => {
    const component = row.dataset.component;
    if (component) {
      row.innerHTML = `
        <td><img src="resource/${component.toLowerCase()}.png" alt="${component}" /></td>
        <td class="product-name" colspan="3">
          <button class="add-button" onclick="openPopup('${component}')">+ ADD COMPONENT</button>
        </td>
      `;
    }
  });
  updateSubtotal();
}

// Load previously added components from sessionStorage
window.addEventListener('DOMContentLoaded', () => {
  const components = ['cpu', 'gpu', 'motherboard', 'ram', 'storage', 'psu', 'case', 'cpucooler', 'casefan', 'monitor', 'mouse', 'keyboard'];

  components.forEach(component => {
    const data = sessionStorage.getItem(component);
    if (data) {
      const item = JSON.parse(data);
      const row = document.querySelector(`tr[data-component="${capitalize(component)}"]`);
      if (row) {
        row.innerHTML = `
          <td><img src="resource/${component}.png" alt="${component}" /></td>
          <td>${item.product_display_name}</td>
          <td>${item.product_description}</td>
          <td>₱${parseFloat(item.price).toFixed(2)}</td>
        `;
      }
    }
  });

  updateSubtotal();
});

function capitalize(str) {
  return str.charAt(0).toUpperCase() + str.slice(1).toLowerCase();
}
