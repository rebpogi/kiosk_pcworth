<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Bundle Management</title>
  <style>
    /* Main bundles listing styles */
    .bundles-scope {
      font-family: Arial, sans-serif;
      margin: 20px;
      overflow-x: auto;
    }

    .bundles-scope .btn {
      padding: 8px 12px;
      cursor: pointer;
      border: none;
      border-radius: 4px;
    }

    .bundles-scope .btn-primary {
      background-color: #5ca3ff;
      color: white;
    }

    .bundles-scope .btn-danger {
      background-color: #ff5c5c;
      color: white;
    }

    .bundles-scope .btn-warning {
      background-color: #ffc107;
      color: black;
    }

    .bundles-scope .btn-success {
      background-color: #28a745;
      color: white;
    }

    .bundles-scope .btn-sm {
      padding: 5px 10px;
      font-size: 14px;
    }

    .bundles-scope table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
      table-layout: fixed;
    }

    .bundles-scope th,
    .bundles-scope td {
      padding: 12px;
      text-align: left;
      border: 1px solid #ddd;
      word-break: break-word;
      vertical-align: middle;
    }

    .bundles-scope th {
      background-color: #5ca3ff;
      color: white;
    }

    .bundles-scope tr:nth-child(even) {
      background-color: #f2f2f2;
    }

    .bundles-scope tr:hover {
      background-color: #e9e9e9;
    }

    .bundles-scope .status-hidden {
      color: #ff5c5c;
      font-weight: bold;
    }

    .bundles-scope .status-shown {
      color: #28a745;
      font-weight: bold;
    }

    .bundles-scope .action-btns {
      display: flex;
      gap: 5px;
      flex-wrap: wrap;
    }

    .bundles-scope .bundle-img {
      width: 200px;
      height: 200px;
      object-fit: cover;
      border-radius: 4px;
    }

    /* Bundle form styles */
    /* .bundle-form-container {
      display: none;
      margin-top: 30px;
      padding: 20px;
      border: 1px solid #ddd;
      border-radius: 5px;
      background-color: #f9f9f9;
    } */

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

    @media screen and (max-width: 768px) {
      .bundles-scope .bundle-img {
        width: 100px;
        height: 100px;
      }

      .bundles-scope th,
      .bundles-scope td {
        font-size: 14px;
        padding: 8px;
      }
    }
  </style>
</head>
<body>
  <div class="bundles-scope">
    <button class="btn btn-primary" id="createBundleBtn">Create New Bundle</button>

    <div id="bundlesTable">
      <table>
        <thead>
          <tr>
            <th>Image</th>
            <th>Name</th>
            <th>Quantity</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php
          require_once 'DB_connect.php';
          $result = mysqli_query($conn, "SELECT * FROM bundles ORDER BY created_at DESC");
          while ($row = mysqli_fetch_assoc($result)) {
            $statusClass = $row['status'] == 1 ? 'status-shown' : 'status-hidden';
            $statusText = $row['status'] == 1 ? 'Shown' : 'Hidden';
            echo '<tr>
                    <td><img class="bundle-img" src="' . htmlspecialchars($row['bundle_image']) . '"></td>
                    <td>' . htmlspecialchars($row['bundle_display_name']) . '</td>
                    <td>' . htmlspecialchars($row['bundle_quantity']) . '</td>
                    <td class="' . $statusClass . '">' . $statusText . '</td>
                    <td>
                      <div class="action-btns">
                        <button class="btn btn-sm btn-warning" onclick="editBundle(' . $row['id'] . ')">EDIT</button>
                        <button class="btn btn-sm ' . ($row['status'] == 1 ? 'btn-danger' : 'btn-success') . '" 
                                onclick="toggleBundleStatus(' . $row['id'] . ', ' . $row['status'] . ')">
                          ' . ($row['status'] == 1 ? 'HIDE' : 'SHOW') . '
                        </button>
                        <button class="btn btn-sm btn-danger" onclick="deleteBundle(' . $row['id'] . ')">DELETE</button>
                      </div>
                    </td>
                  </tr>';
          }
          ?>
        </tbody>
      </table>
    </div>

    <!-- Bundle Form Container (hidden by default) -->
    <!-- <div class="bundle-form-container" id="bundleFormContainer">
      <h1 id="formTitle">Create New Bundle</h1>

      <form id="bundleForm" action="save_bundle.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="bundle_id" id="bundle_id" value="">
        
        <button type="button" class="btn btn-secondary" id="cancelFormBtn">Go Back</button>
        <button type="submit" class="btn btn-primary" style="float: right;">Save Bundle</button>
        
        <div style="clear: both; margin-top: 20px;"></div>
        
        <div class="form-group">
          <label>Bundle Display Name</label>
          <input type="text" name="bundle_display_name" id="bundle_display_name" required>
        </div>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
          <div class="form-group">
            <label>Bundle Quantity</label>
            <input type="number" name="bundle_quantity" id="bundle_quantity" min="1" max="5" value="1" required>
          </div>
          <div class="form-group">
            <label>Bundle UID</label>
            <input type="number" name="bundle_uid" id="bundle_uid" required>
          </div>
          <div class="form-group">
            <label>Bundle Price</label>
            <input type="number" name="bundle_price" id="bundle_price" step="0.01" required>
          </div>
          <div class="form-group">
            <label>Status</label>
            <select name="status" id="status">
              <option value="1">Shown</option>
              <option value="0">Hidden</option>
            </select>
          </div>
        </div>
        
        <div class="form-group">
          <label>Bundle Description</label>
          <textarea name="bundle_description" id="bundle_description" required></textarea>
        </div>
        
        <div class="form-group">
          <label>Bundle Image</label>
          <input type="file" name="bundle_image" accept=".jpg,.jpeg,.png" id="bundle_image">
          <span id="imageError" style="color: red; font-size: 14px;"></span>
          <div id="imagePreview" style="margin-top: 10px;"></div>
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
          <tbody id="componentsTableBody">
            <?php
            $categories = ["CPU", "GPU", "Motherboard", "RAM", "HDD", "SSD","CPU Cooler", "Power Supply", "Case", "Case Fanns", "Monitor", "Mouse","Keyboard"];
            foreach ($categories as $category): 
            ?>
              <tr>
                <td><?= $category ?></td>
                <td>
                  <button type="button" class="btn btn-sm" onclick="selectPart('<?= $category ?>')">Select Part</button>
                  <input type="hidden" name="part_<?= $category ?>_uid" id="part_<?= $category ?>_uid" value="">
                </td>
                <td>
                  <input type="number" name="part_<?= $category ?>_qty" id="part_<?= $category ?>_qty" min="0" max="10" value="0" style="width: 60px;">
                </td>
                <td id="part_<?= $category ?>_price">₱0.00</td>
                <td>
                  <button type="button" class="btn btn-sm btn-danger" onclick="removePart('<?= $category ?>')" style="display: none;">Remove</button>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </form>
    </div> -->
  </div>
  <script src="BundleStart.js"></script>
</body>
</html>