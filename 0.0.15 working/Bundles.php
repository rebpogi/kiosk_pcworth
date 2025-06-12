<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Create Bundle Page</title>
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
</head>
<body>

<div id="mainContent">

  <div class="bundle-rectangle" onclick="createNewBundle()" style="cursor:pointer; padding: 20px; background:#d1e2ff; width: 200px; text-align:center; margin-bottom: 20px;">
    <div style="font-size: 28px; font-weight: bold;">+</div>
    <div style="font-weight: bold;">Create New Bundle</div>
  </div>


  <!-- Make the exsiting bundles clikable then go update them -->
<?php
require_once 'DB_connect.php';

$sql = "SELECT * FROM bundles ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result)) {
    $bundle_id = $row['id'];
    echo '<div class="bundle-rectangle" onclick="editBundle(' . $bundle_id . ')" style="cursor:pointer; padding: 20px; background:#f0f0f0; width: 200px; text-align:center; margin-bottom: 20px; display:inline-block; margin-right: 10px; border-radius:10px;">';
    echo '<img src="' . htmlspecialchars($row['bundle_image']) . '" style="width:100%; height:120px; object-fit:cover; border-radius:10px;"><br>';
    echo '<div style="font-weight: bold; margin-top: 8px;">' . htmlspecialchars($row['bundle_display_name']) . '</div>';
    echo '</div>';
}

?>
</div>

<div id="loadBundleForms" style="display: none;">
 <form action="save_bundle.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="bundle_id" id="bundle_id" value="">
    <button type="button" onclick="goBackToMain()" class="new-Product-update">&larr; Go Back To Bundles</button>

    <div class="input-group">
      <div class="input-field">
        <label>Bundle Display Name</label>
         <input type="text" name="bundle_display_name" id="bundle_display_name"><br>
      </div>
      <div class="input-field">
        <label>Bundle Quantity</label>
        <input id="bundle_quantity" name="bundle_quantity" type="number" min="0" max="5"placeholder="#" required />
      </div>
    </div>

    <div class="input-group">
      <div class="input-field">
        <label>Bundle UID</label>
        <input id="bundle_uid" name="bundle_uid" type="number" placeholder="#####" required />
      </div>
      <div class="input-field">
        <label>Bundle Price</label>
        <input id="bundle_price" name="bundle_price" type="number" step="0.01" placeholder="₱00.00" required />
      </div>
    </div>

    <div>
      <label>Bundle Description</label>
      <textarea class="style_box" id="bundle_description" name="bundle_description" placeholder="Product Description here." required></textarea>
    </div>

    <div>
  <br>
  <label>Bundle Image:</label>
  <?php if (!isset($_GET['id'])): ?>
    <!-- For new bundles - required -->
    <input type="file" name="bundle_image" accept=".png, .jpg, .jpeg" required>
  <?php else: ?>
    <!-- For existing bundles - optional -->
    <input type="file" name="bundle_image" accept=".png, .jpg, .jpeg">
  <?php endif; ?>
  <br><br>
  <input type="checkbox" id="status" name="status"> Hide product on kiosk
</div>


    <table>
      <thead>
        <tr>
          <th>Parts / Category</th>
          <th>Selected Part</th>
          <th>Quantity</th>
          <th>Stock Quantity</th>
          <th>Price (Unit)</th>
        </tr>
      </thead>
      <tbody id="partsTableBody"></tbody>
      <tfoot>
        <tr>
          <td colspan="4" style="text-align: right;"><strong>Total:</strong></td>
          <td id="totalPrice">₱0.00</td>
        </tr>
      </tfoot>
    </table>

    <button type="submit" style="margin-top:20px;">Save Bundle</button>
  </form>
</div>

<div id="bundleSearchResults" style="display: none;">
  <button type="button" onclick="goBackToBundleForm()" class="new-Product-update">&larr; Go Back To Bundle Form</button>
  <input type="text" id="bundleSearchInput" placeholder="Search for a part..." onkeyup="debouncedBundleSearch(this.value)" />
  <div id="bundleResultsArea"><p>Start typing to find parts...</p></div>
</div>

<script>
const categories = ["CPU", "GPU", "Motherboard", "RAM", "HDD", "SSD", "Power Supply", "Heat sink", "Case", "Case Fans", "Monitor", "Keyboard", "Mouse", "Accessories"];
let currentTargetCategory = "";

document.addEventListener("DOMContentLoaded", () => {
  const tbody = document.getElementById("partsTableBody");
  categories.forEach(cat => {
    const row = document.createElement("tr");
    row.dataset.category = cat;
    row.innerHTML = `
      <td>${cat}</td>
      <td class="part-cell">
        <button type="button" onclick="Load_Bundle_search_select('${cat}')">Select Part</button>
      </td>
      <td class="select-qty-cell">
        <button type="button" onclick="changeBundleQuantity(this, -1)">-</button>
        <span class="bundle-qty" style="margin: 0 8px;">0</span>
        <button type="button" onclick="changeBundleQuantity(this, 1)">+</button>
      </td>
      <td class="qty-cell">-</td>
      <td class="price-cell" data-price="0">-</td>
    `;
    tbody.appendChild(row);
  });
});


//========== NEW BUNDLE =========
function createNewBundle() {
  document.getElementById('mainContent').style.display = 'none';
  document.getElementById('loadBundleForms').style.display = 'block';

  // Clear input fields manually
  document.getElementById('bundle_display_name').value = '';
  document.getElementById('bundle_quantity').value = '';
  document.getElementById('bundle_uid').value = '';
  document.getElementById('bundle_price').value = '';
  document.getElementById('bundle_description').value = '';  // Clear textarea explicitly
  document.getElementById('status').checked = false;

  // Reset parts table rows
  document.querySelectorAll('#partsTableBody tr').forEach(row => {
    const cat = row.dataset.category;
    row.querySelector('.part-cell').innerHTML = `<button type="button" onclick="Load_Bundle_search_select('${cat}')">Select Part</button>`;
    row.querySelector('.bundle-qty').textContent = '0';
    row.querySelector('.qty-cell').textContent = '-';
    row.querySelector('.price-cell').textContent = '-';
    row.querySelector('.price-cell').dataset.price = '0';
    row.querySelectorAll('input[type="hidden"]').forEach(el => el.remove());
  });

  updateTotal();
}


function goBackToMain() {
  document.getElementById('loadBundleForms').style.display = 'none';
  document.getElementById('bundleSearchResults').style.display = 'none';
  document.getElementById('mainContent').style.display = 'block';
}

function Load_Bundle_search_select(category) {
    currentTargetCategory = category;  // Make sure this line is present
    document.getElementById('loadBundleForms').style.display = 'none';
    document.getElementById('bundleSearchResults').style.display = 'block';
    document.getElementById('bundleSearchInput').value = "";
    document.getElementById('bundleResultsArea').innerHTML = "<p>Start typing to find parts...</p>";
    document.getElementById('bundleSearchInput').focus();
}

function fetchBundleResults(query) {
    if (!query.trim()) {
        document.getElementById("bundleResultsArea").innerHTML = "<p>Start typing to find parts...</p>";
        return;
    }

    fetch(`Bundles_Search_Logic.php?ajax=1&query=${encodeURIComponent(query)}`)
        .then(res => res.text())
        .then(html => {
            document.getElementById("bundleResultsArea").innerHTML = html;
        })
        .catch(error => {
            console.error("Search error:", error);
            document.getElementById("bundleResultsArea").innerHTML = "<p>Error fetching results.</p>";
        });
}

function goBackToBundleForm() {
  document.getElementById('bundleSearchResults').style.display = 'none';
  document.getElementById('loadBundleForms').style.display = 'block';
}

function changeBundleQuantity(button, delta) {
  const span = button.parentElement.querySelector('.bundle-qty');
  let quantity = parseInt(span.textContent);
  quantity += delta;
  if (quantity < 1) quantity = 1;
  if (quantity > 5) quantity = 5;
  span.textContent = quantity;

  const row = button.closest("tr");
  const qtyInput = row.querySelector(`input[name="part_${row.dataset.category}_qty"]`);
  if (qtyInput) qtyInput.value = quantity;

  updateTotal();
}

function updateTotal() {
    let total = 0;
    document.querySelectorAll("#partsTableBody tr").forEach(row => {
        const price = parseFloat(row.querySelector(".price-cell").dataset.price) || 0;
        const quantity = parseInt(row.querySelector('.bundle-qty').textContent) || 0;
        total += price * quantity;
    });
    document.getElementById('totalPrice').textContent = `₱${total.toFixed(2)}`;
}

// Update selectPart function to handle both search selections and existing data
function selectPart(name, uid, price, stockQty, category = null) {
    // If category is not provided, use currentTargetCategory (for search selections)
    const targetCategory = category || currentTargetCategory;
    
    const rows = document.querySelectorAll("#partsTableBody tr");
    rows.forEach(row => {
        if (row.dataset.category === targetCategory) {
            const quantity = parseInt(row.querySelector('.bundle-qty')?.textContent) || 1;
            
            // Update the display with part information
            row.querySelector(".part-cell").innerHTML = `
                ${name} 
                <button type="button" onclick="Load_Bundle_search_select('${targetCategory}')">Change</button>
            `;
            row.querySelector(".qty-cell").textContent = stockQty;
            row.querySelector('.bundle-qty').textContent = quantity;

            const unitPrice = parseFloat(price);
            row.querySelector(".price-cell").textContent = `₱${unitPrice.toFixed(2)}`;
            row.querySelector(".price-cell").dataset.price = unitPrice;

            // Remove any existing hidden inputs
            row.querySelectorAll("input[type='hidden']").forEach(el => el.remove());
            
            // Add new hidden inputs
            row.insertAdjacentHTML('beforeend', `
                <input type="hidden" name="part_${targetCategory}_uid" value="${uid}">
                <input type="hidden" name="part_${targetCategory}_category" value="${targetCategory}">
                <input type="hidden" name="part_${targetCategory}_name" value="${name}">
                <input type="hidden" name="part_${targetCategory}_qty" value="${quantity}">
                <input type="hidden" class="price-data" name="part_${targetCategory}_price" value="${unitPrice.toFixed(2)}">
            `);
        }
    });

    updateTotal();

    // If this was called from search (no category provided), go back to form
    if (!category) {
        goBackToBundleForm();
    }
}

function editBundle(bundleId) {
    fetch(`get_bundle_data.php?id=${bundleId}`)
        .then(res => res.json())
        .then(data => {
            if (!data || data.error) {
                alert("Failed to load bundle: " + (data?.error || "Unknown error"));
                return;
            }

            // Hide bundles list
            document.getElementById('mainContent').style.display = 'none';

            // Show the form container
            const formContainer = document.getElementById('loadBundleForms');
            formContainer.style.display = 'block';

            // Set the bundle ID
            document.getElementById('bundle_id').value = bundleId;

            // Prefill the form fields
            document.getElementById('bundle_display_name').value = data.bundle_display_name;
            document.getElementById('bundle_quantity').value = data.bundle_quantity;
            document.getElementById('bundle_uid').value = data.bundle_uid;
            document.getElementById('bundle_price').value = data.bundle_price;
            document.getElementById('bundle_description').value = data.bundle_description;
            document.getElementById('status').checked = data.status === "1";

            // Clear current parts selection
            document.querySelectorAll('#partsTableBody tr').forEach(row => {
                const cat = row.dataset.category;
                row.querySelector('.part-cell').innerHTML = `<button type="button" onclick="Load_Bundle_search_select('${cat}')">Select Part</button>`;
                row.querySelector('.bundle-qty').textContent = '0';
                row.querySelector('.qty-cell').textContent = '-';
                row.querySelector('.price-cell').textContent = '-';
                row.querySelector('.price-cell').dataset.price = '0';
                row.querySelectorAll('input[type="hidden"]').forEach(el => el.remove());
            });

            // Fill in the parts data
            if (data.parts && Array.isArray(data.parts)) {
                data.parts.forEach(part => {
                    // Call selectPart with the part's category
                    selectPart(
                        part.part_name || part.name,
                        part.part_uid || part.uid,
                        part.unit_price || part.price,
                        part.stock_qty,
                        part.category
                    );
                    
                    // Update quantity after selecting part
                    const row = document.querySelector(`#partsTableBody tr[data-category="${part.category}"]`);
                    if (row) {
                        const quantity = parseInt(part.quantity) || 1;
                        row.querySelector('.bundle-qty').textContent = quantity;
                        const qtyInput = row.querySelector(`input[name="part_${part.category}_qty"]`);
                        if (qtyInput) qtyInput.value = quantity;
                    }
                });
            }

            updateTotal();
        })
        .catch(err => {
            console.error("Failed to load bundle:", err);
            alert("Error loading bundle data. Check console.");
        });
}

// Make sure the debounce function is still present
const debounce = (func, delay) => {
    let timeout;
    return (...args) => {
        clearTimeout(timeout);
        timeout = setTimeout(() => func(...args), delay);
    };
};

const debouncedBundleSearch = debounce(fetchBundleResults, 300);

// Add event listener for search input
document.getElementById('bundleSearchInput')?.addEventListener('keyup', function() {
    debouncedBundleSearch(this.value);
});

function goBackToMain() {
  document.getElementById('loadBundleForms').style.display = 'none';
  document.getElementById('mainContent').style.display = 'block';
}


document.getElementById("bundleForm").addEventListener("submit", function (e) {
    let valid = true;

    // Clear previous errors
    document.querySelectorAll('.error').forEach(el => el.innerText = '');

    // Get form values
    const name = document.getElementById("bundle_display_name").value.trim();
    const uid = document.getElementById("bundle_uid").value.trim();
    const price = document.getElementById("bundle_price").value.trim();

    // Validate fields
    if (name === "") {
        document.getElementById("error_name").innerText = "Bundle name is required.";
        valid = false;
    }

    if (uid === "" || isNaN(uid) || parseInt(uid) <= 0) {
        document.getElementById("error_uid").innerText = "Valid UID is required.";
        valid = false;
    }

    if (price === "" || isNaN(price) || parseFloat(price) <= 0) {
        document.getElementById("error_price").innerText = "Valid price is required.";
        valid = false;
    }

    // Prevent form if not valid
    if (!valid) {
        e.preventDefault();
    }
});

</script>

</body>
</html>