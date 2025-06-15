<?php
// Database configuration (UPDATE THESE WITH YOUR CREDENTIALS)
$servername = "localhost";
$username = "zas";
$password = "group4";
$dbname = "testing_backend";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables
$bundle = [
    'bundle_display_name' => '',
    'bundle_quantity' => 1,
    'bundle_uid' => '',
    'bundle_price' => '',
    'status' => 1,
    'bundle_description' => '',
    'bundle_image' => ''
];

$bundleParts = [];
$categories = ["CPU", "GPU", "Motherboard", "RAM", "HDD", "SSD", "CPU Cooler", "Power Supply", "Case", "Case Fanns", "Monitor", "Mouse", "Keyboard"];

// Initialize empty parts for all categories
foreach ($categories as $category) {
    $bundleParts[$category] = null;
}

// If editing an existing bundle
if (isset($_GET['id'])) {
    $bundle_id = intval($_GET['id']);
    $bundle = [];
    $bundleParts = [];

    // 1. Fetch bundle info
    $stmt = $conn->prepare("SELECT * FROM bundles WHERE id = ?");
    $stmt->bind_param("i", $bundle_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $bundle = $result->fetch_assoc();
    } else {
        die("Bundle not found");
    }
    $stmt->close();

    // 2. Fetch bundle parts (JOIN with parts table)
    $stmt = $conn->prepare("
        SELECT bp.*, p.product_display_name AS part_name, p.immage AS part_image, p.price AS part_price 
        FROM bundle_parts bp
        JOIN products p ON bp.part_uid = p.UID
        WHERE bp.bundle_id = ?
    ");
    $stmt->bind_param("i", $bundle_id);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $category = $row['category'];
        $bundleParts[$category] = [
            'uid'      => $row['part_uid'],
            'name'     => $row['part_name'],
            'image'    => $row['part_image'],
            'price'    => $row['part_price'],
            'quantity' => $row['quantity']
        ];
    }
    $stmt->close();
}


// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= isset($_GET['id']) ? 'Edit' : 'Create' ?> Bundle</title>
  <link rel="stylesheet" href="Bundles/BundleForm.css">

</head>
<body class="bundle-form-page">
  <h1><?= isset($_GET['id']) ? 'Edit Bundle' : 'Create New Bundle' ?></h1>

  <form action="save_bundle.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="bundle_id" value="<?= $_GET['id'] ?? '' ?>">
    
    <button type="button" class="btn btn-back" onclick="goBackBundle()">← Back</button>
    <button type="submit" class="btn btn-primary" style="float: right;">Save Bundle</button>
    
    <div style="clear: both; margin-top: 20px;"></div>
    
    <div class="form-group">
      <label>Bundle Display Name</label>
      <input type="text" name="bundle_display_name" value="<?= htmlspecialchars($bundle['bundle_display_name']) ?>" required>
    </div>
    
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
      <div class="form-group">
        <label>Bundle Quantity</label>
        <input type="number" name="bundle_quantity" min="1" max="5" value="<?= $bundle['bundle_quantity'] ?>" required>
      </div>
      <div class="form-group">
        <label>Bundle UID</label>
        <input type="number" name="bundle_uid" value="<?= $bundle['bundle_uid'] ?>" required>
      </div>
      <div class="form-group">
        <label>Bundle Price</label>
        <input type="number" name="bundle_price" step="0.01" value="<?= $bundle['bundle_price'] ?>" required>
      </div>
      <div class="form-group">
        <label>Status</label>
        <select name="status">
          <option value="1" <?= $bundle['status'] == 1 ? 'selected' : '' ?>>Shown</option>
          <option value="0" <?= $bundle['status'] == 0 ? 'selected' : '' ?>>Hidden</option>
        </select>
      </div>
    </div>
    
    <div class="form-group">
      <label>Bundle Description</label>
      <textarea name="bundle_description" required><?= htmlspecialchars($bundle['bundle_description']) ?></textarea>
    </div>
    
    <div class="form-group">
      <label>Bundle Image</label>
      <input type="file" name="bundle_image" accept=".jpg,.jpeg,.png" id="bundle_image" <?= !isset($_GET['id']) ? 'required' : '' ?>>
      <span id="imageError" style="color: red; font-size: 14px;"></span>
      <?php if (!empty($bundle['bundle_image'])): ?>
        <div style="margin-top: 10px;">
          <img src="<?= htmlspecialchars($bundle['bundle_image']) ?>" class="image-preview" id="existingImage">
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
        <?php foreach ($categories as $category): ?>
          <tr>
            <td><?= $category ?></td>
            <td>
              <?php if (!empty($bundleParts[$category])): ?>
                <div style="display: flex; align-items: center; gap: 10px;">
                  <img src="<?= htmlspecialchars($bundleParts[$category]['image']) ?>" class="part-img">
                  <div><?= htmlspecialchars($bundleParts[$category]['name']) ?></div>
                </div>
                <input type="hidden" name="part_<?= $category ?>_uid" value="<?= $bundleParts[$category]['uid'] ?>">
              <?php else: ?>
                <button type="button" class="btn btn-sm" onclick="selectPart('<?= $category ?>')">Select Part</button>
              <?php endif; ?>
            </td>
            <td>
              <input type="number" name="part_<?= $category ?>_qty" min="0" max="10" 
                     value="<?= !empty($bundleParts[$category]) ? $bundleParts[$category]['quantity'] : 0 ?>" style="width: 60px;">
            </td>
            <td>₱<?= !empty($bundleParts[$category]) ? number_format($bundleParts[$category]['price'], 2) : '0.00' ?></td>
            <td>
              <?php if (!empty($bundleParts[$category])): ?>
                <button type="button" class="btn btn-sm btn-secondary" onclick="removePart('<?= $category ?>')">Remove</button>
              <?php endif; ?>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </form>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Image preview functionality
      const imageInput = document.getElementById('bundle_image');
      const errorSpan = document.getElementById('imageError');
      
      imageInput?.addEventListener('change', function() {
        const file = this.files[0];
        if (!file) return;
        
        // Validate file type
        const validTypes = ['image/jpeg', 'image/png'];
        if (!validTypes.includes(file.type)) {
          errorSpan.textContent = 'Only JPG/JPEG and PNG files are allowed';
          this.value = '';
          return;
        }
        
        // Validate file size (max 2MB)
        if (file.size > 2 * 1024 * 1024) {
          errorSpan.textContent = 'Image must be less than 2MB';
          this.value = '';
          return;
        }
        
        errorSpan.textContent = '';
        
        // Show preview
        const reader = new FileReader();
        reader.onload = function(e) {
          let imgPreview = document.querySelector('.image-preview');
          if (!imgPreview) {
            imgPreview = document.createElement('img');
            imgPreview.className = 'image-preview';
            imageInput.parentNode.appendChild(imgPreview);
          }
          imgPreview.src = e.target.result;
          
          // Hide existing image if editing
          const existingImg = document.getElementById('existingImage');
          if (existingImg) existingImg.style.display = 'none';
        };
        reader.readAsDataURL(file);
      });
      
      // Form validation
      const form = document.querySelector('form');
      form.addEventListener('submit', function(e) {
        let isValid = true;
        const errors = [];
        
        // Validate UID (6 digits)
        const uid = document.querySelector('input[name="bundle_uid"]').value;
        if (!/^\d{6}$/.test(uid)) {
          errors.push("Bundle UID must be exactly 6 digits");
          isValid = false;
        }
        
        // Validate price (positive number)
        const price = parseFloat(document.querySelector('input[name="bundle_price"]').value);
        if (isNaN(price) || price <= 0) {
          errors.push("Bundle price must be a positive number");
          isValid = false;
        }
        
        // Validate at least one part is selected
        let hasParts = false;
        <?php foreach ($categories as $category): ?>
          if (document.querySelector('input[name="part_<?= $category ?>_uid"]')?.value) {
            hasParts = true;
          }
        <?php endforeach; ?>
        
        if (!hasParts) {
          errors.push("You must select at least one part for the bundle");
          isValid = false;
        }
        
        if (!isValid) {
          e.preventDefault();
          alert("Please fix the following errors:\n\n" + errors.join("\n"));
        }
      });
    });
    
    function selectPart(category) {
      // This would open a modal or new window to select parts
      // Implementation depends on your parts selection UI
      alert(`Implement part selection for ${category}`);
    }
    
    function removePart(category) {
      if (confirm(`Remove ${category} from bundle?`)) {
        // This would need to be handled in save_bundle.php
        document.querySelector(`input[name="part_${category}_uid"]`).value = '';
        document.querySelector(`input[name="part_${category}_qty"]`).value = 0;
      }
    }
  </script>
</body>
</html>