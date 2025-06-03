<?php
$host = 'localhost';
$user = 'zas';
$password = 'group4';
$database = 'testing_backend';

$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$sql = "SELECT * FROM products ORDER BY id DESC";
$result = $conn->query($sql);
?>
 <!-- products are shown by default code wise -->
<!--USE THE CODE BELLOW FOR KIOSK USER ONLY-->
<!--$sql = "SELECT * FROM products WHERE status = 'Available' ORDER BY id DESC";-->

<!DOCTYPE html>
<html>
<head>
  <title>Product List</title>
  <style>
    body { font-family: Arial, sans-serif; padding: 20px; }
    table { border-collapse: collapse; width: 100%; margin-top: 20px; }
    th, td { padding: 10px; border: 1px solid #ccc; text-align: left; vertical-align: top; }
    img { width: 120px; height: auto; }
  </style>
</head>
<body>

<h2>Visible Products</h2>

<?php if ($result && $result->num_rows > 0): ?>
  <table>
    <tr>
      <th>Display Name</th>
      <th>Price</th>
      <th>Category</th>
      <th>Manufacturer</th>
      <th>Specs</th>
      <th>Description</th>
      <th>Status</th>
      <th>Warranty</th>
      <th>UID</th>
      <th>Stock</th>
      <th>Image</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
      <tr>
        <td><?= htmlspecialchars($row['product_display_name']) ?></td>
        <td>$<?= number_format($row['price'], 2) ?></td>
        <td><?= htmlspecialchars($row['category']) ?></td>
        <td><?= htmlspecialchars($row['manufacturer']) ?></td>
        <td><?= nl2br(htmlspecialchars($row['product_specifications'])) ?></td>
        <td><?= nl2br(htmlspecialchars($row['product_description'])) ?></td>
        <td><?= htmlspecialchars($row['status']) ?></td>
        <td><?= htmlspecialchars($row['warranty_duration']) ?></td>
        <td><?= htmlspecialchars($row['UID']) ?></td>
        <td><?= htmlspecialchars($row['quantity']) ?></td>
        <td>
          <?php if (!empty($row['immage'])): ?>
            <img src="<?= $row['immage'] ?>" alt="Product Image">
          <?php else: ?>
            No image
          <?php endif; ?>
        </td>
      </tr>
    <?php endwhile; ?>
  </table>
<?php else: ?>
  <p>No visible products found.</p>
<?php endif; ?>

</body>
</html>
