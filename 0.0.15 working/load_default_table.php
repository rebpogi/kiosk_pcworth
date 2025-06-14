<?php
$connect = mysqli_connect("localhost", "zas", "group4", "testing_backend");

if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}

$search = '';
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["query"])) {
    $search = mysqli_real_escape_string($connect, $_POST["query"]);
}

$query = "SELECT * FROM products";
if (!empty($search)) {
    $query .= " WHERE 
        product_display_name LIKE '%$search%' OR
        category LIKE '%$search%' OR
        manufacturer LIKE '%$search%' OR
        UID LIKE '%$search%'";
}

$result = mysqli_query($connect, $query);

if (mysqli_num_rows($result) > 0) {
    echo '<table border="1" cellpadding="10" cellspacing="0" style="border-collapse: collapse; width: 100%;">';
    echo '<thead>
            <tr>
                <th>Product Name</th>
                <th>Category</th>
                <th>UID</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Status</th>
            </tr>
          </thead><tbody>';

  while ($row = mysqli_fetch_assoc($result)) {
    echo '<tr id="row-' . htmlspecialchars($row['ID']) . '">';
    echo '<td>' . htmlspecialchars($row['product_display_name']) . '</td>';
    echo '<td>' . htmlspecialchars($row['category']) . '</td>';
    echo '<td>' . htmlspecialchars($row['UID']) . '</td>';
    echo '<td>₱' . htmlspecialchars($row['price']) . '</td>';
    echo '<td>' . htmlspecialchars($row['quantity']) . '</td>';
    $statusText = ($row['status'] == 1) ? 'Visible' : 'Hidden';
    $buttonText = ($row['status'] == 1) ? 'Hide' : 'Unhide';
    echo '<td>' . $statusText . '</td>';
    echo '</tr>';
}


    echo '</tbody></table>';
} else {
    echo 'No products found.';
}

mysqli_close($connect);
?>
<script>

// function refreshDefaultTable() {
//   fetch('load_default_table.php')  // or the PHP file that outputs your default table HTML
//     .then(res => res.text())
//     .then(html => {
//       document.getElementById('default-table').innerHTML = html;
//     });
// }

// function deleteProduct(id) {
//   if (confirm("Delete this product?")) {
//     fetch('delete_product.php', {
//       method: 'POST',
//       headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
//       body: 'id=' + encodeURIComponent(id)
//     })
//     .then(response => response.text())
//     .then(data => {
//       alert(data);
//       refreshDefaultTable();  // refresh div instead of clicking search button
//     });
//   }
// }

// function toggleVisibility(id) {
//   fetch('toggle_visibility.php', {
//     method: 'POST',
//     headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
//     body: 'id=' + encodeURIComponent(id)
//   })
//   .then(response => response.text())
//   .then(data => {
//     alert(data);
//     refreshDefaultTable();  // refresh div instead of clicking search button
//   });
// }


</script>
