<?php
include 'DB_connect.php';

// Handle AJAX actions (toggle/delete)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['action'])) {
    header('Content-Type: application/json');
    
    if (isset($_POST['id'])) {
        $id = intval($_POST['id']);
        
        if ($_POST['action'] === 'toggle') {
            $stmt = $conn->prepare("UPDATE bundles SET status = NOT status WHERE id = ?");
            $stmt->bind_param("i", $id);
            if ($stmt->execute()) {
                $res = $conn->query("SELECT status FROM bundles WHERE id = $id");
                $row = $res->fetch_assoc();
                echo json_encode([
                    'success' => true, 
                    'newStatus' => $row['status'],
                    'statusText' => $row['status'] ? 'Shown' : 'Hidden'
                ]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Toggle failed.']);
            }
            exit;
        }

        if ($_POST['action'] === 'delete') {
            // Start transaction for deleting bundle and its parts
            $conn->begin_transaction();
            try {
                // First delete bundle parts
                $deleteParts = $conn->prepare("DELETE FROM bundle_parts WHERE bundle_id = ?");
                $deleteParts->bind_param("i", $id);
                $deleteParts->execute();
                
                // Then delete the bundle
                $stmt = $conn->prepare("DELETE FROM bundles WHERE id = ?");
                $stmt->bind_param("i", $id);
                
                if ($stmt->execute()) {
                    $conn->commit();
                    echo json_encode(['success' => true, 'message' => 'Deleted.']);
                } else {
                    throw new Exception('Delete failed');
                }
            } catch (Exception $e) {
                $conn->rollback();
                echo json_encode(['success' => false, 'message' => 'Delete failed: ' . $e->getMessage()]);
            }
            exit;
        }
    }
    
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
    exit;
}

// Fetch bundle list for initial display
$sql = "SELECT id, bundle_display_name, bundle_quantity, bundle_price, status FROM bundles";
$result = $conn->query($sql);
?>

<div class="bundle-management">
  <h2>Bundle Management</h2>

    <div class="top-controls">
        <button class="btn-add" onclick="addNewBundle()">Add New Bundle</button>
    </div>

<!-- <input type="search" id="searchBar" name="search" placeholder="Search by name..." onkeyup="filterTableB()"> -->

  <table id="bundleTable">
    <thead>
      <tr>
        <th>Name</th>
        <th>Quantity</th>
        <th>Price</th>
        <th>Status</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($row = $result->fetch_assoc()): ?>
      <tr id="row-<?= $row['id'] ?>">
        <td><?= htmlspecialchars($row['bundle_display_name']) ?></td>
        <td><?= $row['bundle_quantity'] ?></td>
        <td>₱<?= number_format($row['bundle_price'], 2) ?></td>
        <td class="status">
          <span class="<?= $row['status'] ? 'shown' : 'hidden' ?>">
            <?= $row['status'] ? 'Shown' : 'Hidden' ?>
          </span>
        </td>
        <td>
          <button class="btn-edit" onclick="editBundle(<?= $row['id'] ?>)">Edit</button>
          <button class="btn-toggle" onclick="toggleBundleStatus(<?= $row['id'] ?>)">
            <?= $row['status'] ? 'Hide' : 'Show' ?>
          </button>
          <button class="btn-delete" onclick="deleteBundle(<?= $row['id'] ?>)">Delete</button>
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

<style>
.bundle-management { padding: 20px; }

#searchBar {
  width: 300px;
  padding: 8px;
  margin-bottom: 20px;
  border: 1px solid #ccc;
  border-radius: 4px;
}

#bundleTable { 
  width: 100%; 
  border-collapse: collapse; 
}

#bundleTable th, #bundleTable td { 
  border: 1px solid #ccc; 
  padding: 10px; 
  text-align: left;
}

#bundleTable th { 
  background-color:rgb(154, 218, 255); 
}

.shown { 
  color: #28a745 !important;; /* Green for shown */
  font-weight: bold; 
}

.hidden { 
  color: #dc3545 !important;; /* Red for hidden */
  font-weight: bold; 
}

.btn-edit {
  background-color: #ffc107;
  color: #000;
  border: none;
  padding: 6px 12px;
  border-radius: 4px;
  cursor: pointer;
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
<script src="ExistingBundleTable.js"></script>