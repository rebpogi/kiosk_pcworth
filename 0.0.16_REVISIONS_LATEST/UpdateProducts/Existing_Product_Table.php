  <?php
  include 'DB_connect.php';

  // Handle AJAX actions (toggle/delete)
  if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['action'])) {
      header('Content-Type: application/json');
      
      if (isset($_POST['id'])) {
          $id = intval($_POST['id']);
          
          if ($_POST['action'] === 'toggle') {
              $stmt = $conn->prepare("UPDATE products SET status = NOT status WHERE id = ?");
              $stmt->bind_param("i", $id);
              if ($stmt->execute()) {
                  $res = $conn->query("SELECT status FROM products WHERE id = $id");
                  $row = $res->fetch_assoc();
                  echo json_encode(['success' => true, 'newStatus' => $row['status']]);
              } else {
                  echo json_encode(['success' => false, 'message' => 'Toggle failed.']);
              }
              exit;
          }

          if ($_POST['action'] === 'delete') {
              $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
              $stmt->bind_param("i", $id);
              if ($stmt->execute()) {
                  echo json_encode(['success' => true, 'message' => 'Deleted.']);
              } else {
                  echo json_encode(['success' => false, 'message' => 'Delete failed.']);
              }
              exit;
          }
      }
      
      echo json_encode(['success' => false, 'message' => 'Invalid request.']);
      exit;
  }

  // Fetch product list for initial display
  $sql = "SELECT id, product_display_name, category, quantity, status FROM products ORDER BY created_at DESC";
  $result = $conn->query($sql);
  ?>

  <div class="product-management">
    <h2>Product Management</h2>

    <div class="search-container">
      <input type="search" id="searchBar" name="search" placeholder="Search by name or category..." onkeyup="filterTable()">
    </div>

    <table id="productTable">
      <thead>
        <tr>
          <th>Name</th>
          <th>Category</th>
          <th>Quantity</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr id="row-<?= $row['id'] ?>">
          <td><?= htmlspecialchars($row['product_display_name']) ?></td>
          <td><?= htmlspecialchars($row['category']) ?></td>
          <td><?= $row['quantity'] ?></td>
          <td class="status">
            <span class="<?= $row['status'] ? 'shown' : 'hidden' ?>">
              <?= $row['status'] ? 'Shown' : 'Hidden' ?>
            </span>
          </td>
          <td>
            <button class="btn-edit" onclick="editProduct(<?= $row['id'] ?>)">Edit</button>
            <button class="btn-toggle" onclick="toggleStatus(<?= $row['id'] ?>)">Toggle Visibility</button>
            <button class="btn-delete"onclick="deleteProduct(<?= $row['id'] ?>)">Delete</button>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>

  <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->

  <style>
  .product-management { padding: 20px; }

  #searchBar {
    width: 300px;
    padding: 8px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 4px;
  }

  #productTable { 
    width: 100%; 
    border-collapse: collapse; 
  }

  #productTable th, #productTable td { 
    border: 1px solid #ccc; 
    padding: 10px; 
  }

  #productTable th { 
    background-color:rgb(174, 236, 255); 
  }

  .shown { 
    color: green; 
    font-weight: bold; 
  }

  .hidden { 
    color: red; 
    font-weight: bold; 
  }

  #productTable button { 
    padding: 6px 10px; 
    margin-right: 5px; 
  }

  .btn-toggle {
  background-color: #17a2b8;
  color: #fff;
  border: none;
  padding: 6px 12px;
  border-radius: 4px;
  cursor: pointer;
  margin-right: 5px;
}

.btn-delete {
  background-color: #dc3545;
  color: #fff;
  border: none;
  padding: 6px 12px;
  border-radius: 4px;
  cursor: pointer;
}

.btn-add {
  background-color: #28a745; /* Green */
  color: white;
  border: none;
  padding: 8px 16px;
  margin-bottom: 15px;
  border-radius: 4px;
  cursor: pointer;
  font-weight: bold;
}
  </style>
