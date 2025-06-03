<?php
require_once 'DB_connect.php';

if (!isset($_GET['id'])) {
    echo "<p style='color:red;'>No bundle ID provided.</p>";
    exit;
}

$bundle_id = intval($_GET['id']);

$sql = "SELECT * FROM bundles WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $bundle_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<p style='color:red;'>Bundle not found.</p>";
    exit;
}

$bundle = $result->fetch_assoc();

$parts_by_category = [];
$parts_sql = "SELECT * FROM bundle_parts WHERE bundle_id = ?";
$stmt_parts = $conn->prepare($parts_sql);
$stmt_parts->bind_param("i", $bundle_id);
$stmt_parts->execute();
$parts_result = $stmt_parts->get_result();
while ($part = $parts_result->fetch_assoc()) {
    $parts_by_category[$part['category']] = $part;
}

$categories = ["CPU", "GPU", "Motherboard", "RAM", "HDD", "SSD", "Power Supply", "Heat sink", "Case", "Case Fans", "Monitor", "Keyboard", "Mouse", "Accessories"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Edit Bundle - <?= htmlspecialchars($bundle['bundle_display_name']) ?></title>
  <style>
    /* Basic styles for layout */
    body {
      font-family: Arial, sans-serif;
      margin: 20px;
      background: #f9f9f9;
      color: #333;
    }
    a.new-Product-update {
      display: inline-block;
      margin-bottom: 10px;
      text-decoration: none;
      color: #007BFF;
      font-weight: bold;
    }
    a.new-Product-update:hover {
      text-decoration: underline;
    }
    form label {
      display: block;
      margin-top: 10px;
      font-weight: bold;
    }
    form input[type="text"],
    form input[type="number"],
    form textarea {
      width: 100%;
      max-width: 400px;
      padding: 6px;
      margin-top: 3px;
      box-sizing: border-box;
    }
    form textarea {
      resize: vertical;
      height: 80px;
    }
    form input[type="file"] {
      margin-top: 5px;
    }
    form input[type="checkbox"] {
      margin-top: 8px;
    }
    table {
      border-collapse: collapse;
      width: 100%;
      margin-top: 20px;
      background: #fff;
      box-shadow: 0 0 5px rgba(0,0,0,0.1);
    }
    table th, table td {
      border: 1px solid #ccc;
      padding: 8px 12px;
      text-align: left;
      vertical-align: middle;
    }
    table th {
      background-color: #eee;
    }
    table td.price-cell, table td.qty-cell, table td.select-qty-cell {
      text-align: center;
    }
    table tfoot td {
      font-weight: bold;
      background-color: #f0f0f0;
    }
    button {
      cursor: pointer;
      padding: 6px 12px;
      background-color: #007BFF;
      border: none;
      color: white;
      border-radius: 3px;
      font-size: 14px;
      margin: 2px;
    }
    button:hover {
      background-color: #0056b3;
    }
    .bundle-qty {
      font-weight: bold;
      min-width: 20px;
      display: inline-block;
      text-align: center;
    }
  </style>
</head>
<body>

<a href="javascript:history.back()" class="new-Product-update">&larr; Go Back</a>
<h2>Edit Bundle: <?= htmlspecialchars($bundle['bundle_display_name']) ?></h2>

<form action="update_bundle.php" method="POST" enctype="multipart/form-data" id="bundleFormContainer">
  <input type="hidden" name="bundle_id" value="<?= $bundle_id ?>">

  <label>Bundle Name:</label>
  <input type="text" name="bundle_display_name" value="<?= htmlspecialchars($bundle['bundle_display_name']) ?>" required>

  <label>Quantity:</label>
  <input type="number" name="bundle_quantity" value="<?= $bundle['bundle_quantity'] ?>">

  <label>UID:</label>
  <input type="text" name="bundle_uid" value="<?= $bundle['bundle_uid'] ?>" required>

  <label>Price:</label>
  <input type="number" step="0.01" name="bundle_price" value="<?= $bundle['bundle_price'] ?>">

  <label>Description:</label>
  <textarea name="bundle_description"><?= htmlspecialchars($bundle['bundle_description']) ?></textarea>

  <label>Status:</label>
  <input type="checkbox" name="status" <?= $bundle['status'] ? 'checked' : '' ?>>

  <label>Current Image:</label><br>
  <img src="<?= htmlspecialchars($bundle['bundle_image']) ?>" width="150" alt="Current bundle image"><br>

  <label>Change Image:</label>
  <input type="file" name="bundle_image"><br><br>

  <div id="bundleSearchResults" style="display: none;">
    <button type="button" onclick="goBackToBundleForm()" class="new-Product-update">&larr; Go Back To Bundle Form</button>
    <input type="text" id="bundleSearchInput" placeholder="Search for a part..." onkeyup="debouncedBundleSearch(this.value)" />
    <div id="bundleResultsArea"><p>Start typing to find parts...</p></div>
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
    <tbody id="partsTableBody">
      <?php foreach ($categories as $cat): ?>
        <?php
          $partData = $parts_by_category[$cat] ?? null;
          $part_uid = $partData['part_uid'] ?? '';
          $part_name = $partData['part_name'] ?? '';
          $quantity = $partData['quantity'] ?? 0;
          $unit_price = $partData['unit_price'] ?? 0;
          $stock_qty = $partData['stock_quantity'] ?? '-';
        ?>
        <tr data-category="<?= htmlspecialchars($cat) ?>">
          <td><?= htmlspecialchars($cat) ?></td>
          <td class="part-cell">
            <?php if ($part_uid): ?>
              <?= htmlspecialchars($part_name) ?>
              <input type="hidden" name="part_<?= $cat ?>_uid" value="<?= htmlspecialchars($part_uid) ?>">
              <input type="hidden" name="part_<?= $cat ?>_name" value="<?= htmlspecialchars($part_name) ?>">
            <?php else: ?>
              <button type="button" onclick="Load_Bundle_search_select('<?= $cat ?>')">Select Part</button>
            <?php endif; ?>
          </td>
          <td class="select-qty-cell">
            <button type="button" onclick="changeBundleQuantity(this, -1)">-</button>
            <span class="bundle-qty" style="margin: 0 8px;"><?= htmlspecialchars($quantity) ?></span>
            <input type="hidden" name="part_<?= $cat ?>_qty" value="<?= htmlspecialchars($quantity) ?>">
            <button type="button" onclick="changeBundleQuantity(this, 1)">+</button>
          </td>
          <td class="qty-cell"><?= $stock_qty ?></td>
          <td class="price-cell" data-price="<?= $unit_price ?>">
            <?= $unit_price ? '₱' . number_format($unit_price, 2) : '-' ?>
            <input type="hidden" name="part_<?= $cat ?>_price" value="<?= htmlspecialchars($unit_price) ?>">
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
    <tfoot>
      <tr>
        <td colspan="4" style="text-align: right;"><strong>Total:</strong></td>
        <td id="totalPrice">₱0.00</td>
      </tr>
    </tfoot>
  </table>

  <button type="submit" style="margin-top:20px;">Update Bundle</button>
</form>

<script>
const categories = ["CPU", "GPU", "Motherboard", "RAM", "HDD", "SSD", "Power Supply", "Heat sink", "Case", "Case Fans", "Monitor", "Keyboard", "Mouse",];

function Load_Bundle_search_select(category) {
  currentTargetCategory = category;
  document.getElementById("bundleSearchResults").style.display = "block";
  document.getElementById("bundleFormContainer").style.display = "none";
}

function goBackToBundleForm() {
  document.getElementById("bundleSearchResults").style.display = "none";
  document.getElementById("bundleFormContainer").style.display = "block";
}

function debouncedBundleSearch(query) {
  console.log("Searching for:", query);
  document.getElementById("bundleResultsArea").innerHTML = "<p>Search results for <b>" + query + "</b></p>";
}

function changeBundleQuantity(button, delta) {
  const qtySpan = button.parentElement.querySelector(".bundle-qty");
  let qty = parseInt(qtySpan.textContent);
  qty = Math.max(0, qty + delta);
  qtySpan.textContent = qty;

  // Also update the hidden input field value accordingly
  const hiddenInput = button.parentElement.querySelector('input[type="hidden"]');
  if (hiddenInput) {
    hiddenInput.value = qty;
  }
}
</script>

</body>
</html>
