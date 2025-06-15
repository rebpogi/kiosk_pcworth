<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= isset($_GET['id']) ? 'Edit' : 'Create' ?> Bundle</title>
  <style>
    /* Scoped to this file only */
    .bundle-form-page {
      font-family: Arial, sans-serif;
      margin: 20px;
    }
    .bundle-form-page .form-group {
      margin-bottom: 15px;
    }
    .bundle-form-page label {
      display: block;
      margin-bottom: 5px;
      font-weight: bold;
    }
    .bundle-form-page input[type="text"],
    .bundle-form-page input[type="number"],
    .bundle-form-page textarea,
    .bundle-form-page select {
      width: 100%;
      padding: 8px;
      border: 1px solid #ddd;
      border-radius: 4px;
    }
    .bundle-form-page textarea {
      height: 100px;
    }
    .bundle-form-page .btn {
      padding: 8px 12px;
      cursor: pointer;
      border: none;
      border-radius: 4px;
    }
    .bundle-form-page .btn-primary {
      background-color: #5ca3ff;
      color: white;
    }
    .bundle-form-page .btn-secondary {
      background-color: #6c757d;
      color: white;
    }
    .bundle-form-page table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }
    .bundle-form-page th,
    .bundle-form-page td {
      padding: 12px;
      text-align: left;
      border: 1px solid #ddd;
    }
    .bundle-form-page th {
      background-color: #5ca3ff;
      color: white;
    }
    .bundle-form-page .part-img {
      width: 50px;
      height: 50px;
      object-fit: cover;
      border-radius: 4px;
    }
  </style>
</head>
<body class="bundle-form-page">
  <h1><?= isset($_GET['id']) ? 'Edit Bundle' : 'Create New Bundle' ?></h1>

  <form action="save_bundle.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="bundle_id" value="<?= $_GET['id'] ?? '' ?>">
    
    <button type="button" onclick="goBackBundle()">← Back</button>
    <button type="submit" class="btn btn-primary" style="float: right;">Save Bundle</button>
    
    <div style="clear: both; margin-top: 20px;"></div>
    
    <div class="form-group">
      <label>Bundle Display Name</label>
      <input type="text" name="bundle_display_name" value="<?= $bundle['bundle_display_name'] ?? '' ?>" required>
    </div>
    
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
      <div class="form-group">
        <label>Bundle Quantity</label>
        <input type="number" name="bundle_quantity" min="1" max="5" value="<?= $bundle['bundle_quantity'] ?? 1 ?>" required>
      </div>
      <div class="form-group">
        <label>Bundle UID</label>
        <input type="number" name="bundle_uid" value="<?= $bundle['bundle_uid'] ?? '' ?>" required>
      </div>
      <div class="form-group">
        <label>Bundle Price</label>
        <input type="number" name="bundle_price" step="0.01" value="<?= $bundle['bundle_price'] ?? '' ?>" required>
      </div>
      <div class="form-group">
        <label>Status</label>
        <select name="status">
          <option value="1" <?= isset($bundle['status']) && $bundle['status'] == 1 ? 'selected' : '' ?>>Shown</option>
          <option value="0" <?= isset($bundle['status']) && $bundle['status'] == 0 ? 'selected' : '' ?>>Hidden</option>
        </select>
      </div>
    </div>
    
    <div class="form-group">
      <label>Bundle Description</label>
      <textarea name="bundle_description" required><?= $bundle['bundle_description'] ?? '' ?></textarea>
    </div>
    
    <div class="form-group">
        <label>Bundle Image</label>
        <input type="file" name="bundle_image" accept=".jpg,.jpeg,.png" id="bundle_image" <?= !isset($_GET['id']) ? 'required' : '' ?>>
        <span id="imageError" style="color: red; font-size: 14px;"></span>
        <?php if (isset($bundle['bundle_image'])): ?>
            <div style="margin-top: 10px;">
            <img src="<?= $bundle['bundle_image'] ?>" style="max-width: 200px; max-height: 150px;">
            </div>
        <?php endif; ?>
        </div>

    
    
    <h2>Bundle Components</h2>
    <table>
      <thead>
        <tr>
          <th>Category</th>
          <th>Part</th>
          <th>Quantity</th>
          <th>Price</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $categories = ["CPU", "GPU", "Motherboard", "RAM", "HDD", "SSD","CPU Cooler", "Power Supply", "Case", "Case Fanns", "Monitor", "Mouse","Keyboard"];
        foreach ($categories as $category): 
          $part = $bundleParts[$category] ?? null;
        ?>
          <tr>
            <td><?= $category ?></td>
            <td>
              <?php if ($part): ?>
                <div style="display: flex; align-items: center; gap: 10px;">
                  <img src="<?= $part['image'] ?>" class="part-img">
                  <div><?= $part['name'] ?></div>
                </div>
                <input type="hidden" name="part_<?= $category ?>_uid" value="<?= $part['uid'] ?>">
              <?php else: ?>
                <button type="button" class="btn btn-sm" onclick="selectPart('<?= $category ?>')">Select Part</button>
              <?php endif; ?>
            </td>
            <td>
              <input type="number" name="part_<?= $category ?>_qty" min="0" max="10 " 
                     value="<?= $part['quantity'] ?? 0 ?>" style="width: 60px;">
            </td>
            <td>₱<?= $part['price'] ?? '0.00' ?></td>
            <td>
              <?php if ($part): ?>
                <button type="button" class="btn btn-sm btn-danger" onclick="removePart('<?= $category ?>')">Remove</button>
              <?php endif; ?>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </form>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const uidInput = document.querySelector('input[name="bundle_uid"]');
  const priceInput = document.querySelector('input[name="bundle_price"]');
  const quantityInput = document.querySelector('input[name="bundle_quantity"]');
  const nameInput = document.querySelector('input[name="bundle_display_name"]');
  const form = document.querySelector('form');
  const imageInput = document.getElementById('bundle_image');
  const errorSpan = document.getElementById('imageError');

  // Live image preview
  imageInput?.addEventListener('change', function () {
    const file = this.files[0];
    if (file) {
      const imgPreview = document.createElement('img');
      imgPreview.style.maxWidth = '200px';
      imgPreview.style.maxHeight = '150px';
      imgPreview.style.marginTop = '10px';

      const reader = new FileReader();
      reader.onload = function (e) {
        imgPreview.src = e.target.result;
        const existingImg = imageInput.parentNode.querySelector('img');
        if (!existingImg) {
          imageInput.parentNode.appendChild(imgPreview);
        } else {
          existingImg.src = e.target.result;
        }
      };
      reader.readAsDataURL(file);
    }
  });

  form.addEventListener('submit', function (e) {
    let isValid = true;
    let errors = [];
    errorSpan.textContent = ''; // Reset image error message

    // Validate UID
    if (!/^\d{6}$/.test(uidInput.value)) {
      isValid = false;
      errors.push("Bundle UID must be exactly 6 digits.");
    }

    // Validate price
    const price = parseFloat(priceInput.value);
    if (isNaN(price) || price < 2000 || price > 500000) {
      isValid = false;
      errors.push("Bundle price must be between ₱2000 and ₱500000.");
    }

    // Validate quantity (0 to 10 as per your earlier instruction)
    const qty = parseInt(quantityInput.value, 10);
    if (isNaN(qty) || qty < 0 || qty > 10) {
      isValid = false;
      errors.push("Bundle quantity must be between 0 and 10.");
    }

    // Validate display name
    const name = nameInput.value;
    if (/\${1,}/.test(name) || /\s{3,}/.test(name)) {
      isValid = false;
      errors.push("Display name cannot contain dollar signs or more than two consecutive spaces.");
    }

    // Validate image file
    if (imageInput && imageInput.files.length > 0) {
      const file = imageInput.files[0];
      const validTypes = ['image/jpeg', 'image/png', 'image/jpg'];
      const maxSize = 20 * 1024 * 1024; // 20MB

      if (!validTypes.includes(file.type)) {
        isValid = false;
        errorSpan.textContent = 'Only JPG, JPEG, and PNG files are allowed.';
      }

      if (file.size > maxSize) {
        isValid = false;
        errorSpan.textContent = 'Image must be 20MB or smaller.';
      }
    }

    if (!isValid) {
      e.preventDefault();
      alert("Please fix the following errors:\n\n" + errors.join("\n"));
    }
  });
});
</script>


</body>
</html>