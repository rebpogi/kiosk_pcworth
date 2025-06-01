<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Create Bundle Page</title>
  <link rel="stylesheet" href="admin.css" />
  <style>
    table {
      width: 100%;
      border-collapse: collapse;
      font-family: Arial, sans-serif;
    }
    th, td {
      padding: 12px;
      text-align: left;
      border: 3px solid rgb(109, 109, 109);
    }
    th {
      background-color: rgb(92, 163, 255);
      font-weight: bold;
    }
    tr:nth-child(even) {
      background-color: rgb(209, 229, 255);
    }
    tr:hover {
      background-color: rgb(119, 142, 255);
    }
    button.new-Product-update {
      margin-bottom: 10px;
      padding: 6px 10px;
      font-size: 14px;
      cursor: pointer;
    }
  </style>
  <script src="admin.js" defer></script>
</head>
<body>

<div id="mainContent">
  <div class="bundle-rectangle" onclick="createNewBundle()">
    <div class="plus-sign">+</div>
    <div class="bundle-header-text">Create New Bundle</div>
  </div>
</div>

<div id="loadBundleForms" style="display: none;">
  <form id="bundleForm">
    <button type="button" onclick="goBackToMain()" class="new-Product-update">&larr; Go Back To Bundles</button>

    <div class="input-group">
      <div class="input-field">
        <p>Bundle Display Name</p>
        <input id="bundle_display_name" name="bundle_display_name" type="text" required>
      </div>
      <div class="input-field">
        <p>Bundle Quantity</p>
        <input id="bundle_quantity" name="bundle_quantity" type="number" min="0" required>
      </div>
    </div>

    <p>Bundle Description</p>
    <input id="bundle_description" name="bundle_description" type="text" required>

    <p>Bundle UID</p>
    <input id="bundle_uid" name="bundle_uid" type="number" required>

    <p>
      <input type="checkbox" id="status" name="status">
      <label for="status">Hide product on kiosk (check to hide)</label>
    </p>

    <table>
      <thead>
        <tr>
          <th>Parts / Category</th>
          <th>Image</th>
          <th>Selected Part</th>
          <th>Stock Quantity</th>
          <th>Price</th>
        </tr>
      </thead>
      <tbody>
        <!-- This gets filled dynamically -->
        <script>
          const categories = ["CPU", "GPU", "Motherboard", "RAM", "HDD", "SSD", "Power Supply", "Heat sink", "Case", "Case Fans", "Monitor", "Keyboard", "Mouse", "Accessories"];
          window.addEventListener("DOMContentLoaded", () => {
            const tbody = document.querySelector("table tbody");
            categories.forEach(cat => {
              const row = document.createElement("tr");
              row.dataset.category = cat;
              row.innerHTML = `
                <td>${cat}</td>
                <td class="img-cell"></td>
                <td class="part-cell"><button type="button" onclick="Load_Bundle_search_select('${cat}')">Select Part</button></td>
                <td class="qty-cell">-</td>
                <td class="price-cell">-</td>
              `;
              tbody.appendChild(row);
            });
          });
        </script>
      </tbody>
      <tfoot>
        <tr>
          <td colspan="4" style="text-align: right;"><strong>Total:</strong></td>
          <td id="totalPrice">$0.00</td>
        </tr>
      </tfoot>
    </table>

    <br><br>
    <button type="submit" class="new-Product-update">Save</button>
    <br><br>
  </form>
</div>

<div id="bundleSearchResults" style="display: none;">
  <button type="button" onclick="goBackToBundleForm()" class="new-Product-update">&larr; Go Back To Bundle Form</button>
  <input type="text" id="bundleSearchInput" placeholder="Search for a part..." onkeyup="debouncedBundleSearch(this.value)" />
  <div id="bundleResultsArea"><p>Start typing to find parts...</p></div>
</div>

<script>
  let currentTargetCategory = "";

  function createNewBundle() {
    document.getElementById('mainContent').style.display = 'none';
    document.getElementById('loadBundleForms').style.display = 'block';
  }

  function goBackToMain() {
    document.getElementById('loadBundleForms').style.display = 'none';
    document.getElementById('bundleSearchResults').style.display = 'none';
    document.getElementById('mainContent').style.display = 'block';
  }

  function Load_Bundle_search_select(category) {
    currentTargetCategory = category;
    document.getElementById('loadBundleForms').style.display = 'none';
    document.getElementById('bundleSearchResults').style.display = 'block';
    document.getElementById('bundleSearchInput').value = "";
    document.getElementById('bundleResultsArea').innerHTML = "<p>Start typing to find parts...</p>";
    document.getElementById('bundleSearchInput').focus();
  }

  function goBackToBundleForm() {
    document.getElementById('bundleSearchResults').style.display = 'none';
    document.getElementById('loadBundleForms').style.display = 'block';
  }

  function fetchBundleResults(query) {
    if (!query.trim()) {
      document.getElementById("bundleResultsArea").innerHTML = "<p>Start typing to find parts...</p>";
      return;
    }

    fetch(`Bundles_Search_Logic.php?ajax=1&query=${encodeURIComponent(query)}`)
      .then(res => res.text())
      .then(html => document.getElementById("bundleResultsArea").innerHTML = html)
      .catch(() => document.getElementById("bundleResultsArea").innerHTML = "<p>Error fetching results.</p>");
  }

  const debounce = (func, delay) => {
    let timeout;
    return function(...args) {
      clearTimeout(timeout);
      timeout = setTimeout(() => func.apply(this, args), delay);
    };
  };

  const debouncedBundleSearch = debounce(fetchBundleResults, 300);

  function selectPart(name, uid, price, image, qty) {
    const rows = document.querySelectorAll("#bundleForm tbody tr");
    rows.forEach(row => {
      if (row.dataset.category === currentTargetCategory) {
        row.querySelector(".img-cell").innerHTML = `<img src="${image}" width="50">`;
        row.querySelector(".part-cell").innerHTML = `${name} <button onclick=\"Load_Bundle_search_select('${currentTargetCategory}')\">Change</button>`;
        row.querySelector(".qty-cell").textContent = qty;
        row.querySelector(".price-cell").textContent = `$${(parseFloat(price) * parseInt(qty)).toFixed(2)}`;

        // Add hidden inputs for submission
        row.innerHTML += `<input type="hidden" name="part_${currentTargetCategory}_uid" value="${uid}">
                          <input type="hidden" class="price-data" value="${parseFloat(price) * parseInt(qty)}">`;
      }
    });
    updateTotal();
    goBackToBundleForm();
  }

  function updateTotal() {
    let total = 0;
    document.querySelectorAll(".price-data").forEach(input => {
      total += parseFloat(input.value);
    });
    document.getElementById("totalPrice").textContent = `$${total.toFixed(2)}`;
  }
</script>

</body>
</html>
