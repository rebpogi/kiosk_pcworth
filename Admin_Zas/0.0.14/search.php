<script src="admin.js"></script>
<?php
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["query"])) {
    $connect = mysqli_connect("localhost", "zas", "group4", "testing_backend");

    if (!$connect) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $search = mysqli_real_escape_string($connect, $_POST["query"]);

    $query = "
        SELECT * FROM products
        WHERE 
            product_display_name LIKE '%$search%' OR
            category LIKE '%$search%' OR
            manufacturer LIKE '%$search%' OR
            UID LIKE '%$search%'
    ";

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
                <th>Action</th>
            </tr>
          </thead><tbody>';

    while ($row = mysqli_fetch_assoc($result)) {
        echo '<tr id="row-' . $row['ID'] . '">';
        echo '<td><a href="#" onclick="loadUpdateForm(' . $row['ID'] . '); return false;">' . 
             htmlspecialchars($row['product_display_name']) . 
             '</a></td>';
        echo '<td>' . htmlspecialchars($row['category']) . '</td>';
        echo '<td>' . htmlspecialchars($row['UID']) . '</td>';
        echo '<td>₱' . htmlspecialchars($row['price']) . '</td>';
        echo '<td>' . htmlspecialchars($row['quantity']) . '</td>';
        echo '<td>' . ($row['status'] ? 'Visible' : 'Hidden') . '</td>';
        echo '<td>
                <button onclick="deleteProduct(' . $row['ID'] . ')" style="margin-right:5px;">Delete</button>
                <button onclick="toggleVisibility(' . $row['ID'] . ')" 
                        id="toggle-' . $row['ID'] . '" 
                        style="background-color:#ffc107;">' . 
                    ($row['status'] ? 'Hide' : 'Unhide') . 
                '</button>
              </td>';
        echo '</tr>';
    }

    echo '</tbody></table>';
} else {
    echo 'No matching products found.';
}

mysqli_close($connect);
}
?>

<script>
function deleteProduct(id) {
  if (confirm("Delete this product?")) {
    fetch('delete_product.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: 'id=' + encodeURIComponent(id)
    })
    .then(response => response.text())
    .then(data => {
      alert(data);
      document.getElementById('search-btn').click(); 
    })
  }
}

function toggleVisibility(id) {
  fetch('toggle_visibility.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: 'id=' + encodeURIComponent(id)
  })
  .then(response => response.text())
  .then(data => {
    alert(data);
    document.getElementById('search-btn').click(); 
  });
}





//reload when delte / hide button is cliked
function reloadTable() {
    const query = document.getElementById('searchBox').value;

    fetch('search_products.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'query=' + encodeURIComponent(query)
    })
    .then(res => res.text())
    .then(html => {
        document.getElementById('tableContainer').innerHTML = html;
    });
}
</script>
