<?php
$connect = mysqli_connect("localhost", "zas", "group4", "testing_backend");
if (!$connect) {
    echo '<p class="message">Connection failed: ' . htmlspecialchars(mysqli_connect_error()) . '</p>';
    exit;
}

if (isset($_GET['ajax']) && $_GET['ajax'] == 1 && isset($_GET['query'])) {
    $query = mysqli_real_escape_string($connect, $_GET['query']);
    if (strlen($query) < 1) {
        exit;
    }

    $sql = "SELECT product_display_name, price, UID, immage, quantity 
            FROM products 
            WHERE product_display_name LIKE '%$query%' 
            ORDER BY product_display_name ASC 
            LIMIT 50";

    $result = mysqli_query($connect, $sql);

    if (!$result) {
        echo '<p>Error with query.</p>';
        exit;
    }

    if (mysqli_num_rows($result) == 0) {
        echo '<p>No parts found matching "' . htmlspecialchars($query) . '".</p>';
        exit;
    }

    echo '<table style="width:100%; border-collapse: collapse; font-family: Arial, sans-serif;">';
    echo '<thead><tr style="background-color:#5ca3ff; color:white;">
          <th>Image</th>
          <th>Name</th>
          <th>Price</th>
          <th>Available Qty</th>
          <th>Action</th></tr></thead><tbody>';

    while ($row = mysqli_fetch_assoc($result)) {
        $safeName = htmlspecialchars($row['product_display_name']);
        $safeUid = htmlspecialchars($row['UID']);
        $safePrice = htmlspecialchars($row['price']);
        $safeQty = intval($row['quantity'] ?? 0);  // fallback to 0 if null
        $img = !empty($row['immage']) ? htmlspecialchars($row['immage']) : 'placeholder.png';

        echo '<tr style="border: 1px solid #ddd;">';
        echo '<td style="padding: 8px; text-align:center;">
                <img src="' . $img . '" alt="' . $safeName . '" style="width:50px; height:auto;">
              </td>';
        echo '<td style="padding: 8px;">' . $safeName . '</td>';
        echo '<td style="padding: 8px;">₱' . number_format(floatval($safePrice), 2) . '</td>';
        echo '<td style="padding: 8px; text-align:center;">' . $safeQty . '</td>';
        echo '<td style="padding: 8px; text-align:center;">
                <button type="button" onclick="selectPart(
                    \'' . addslashes($safeName) . '\',
                    \'' . addslashes($safeUid) . '\',
                    \'' . addslashes($safePrice) . '\',
                    \'' . addslashes($img) . '\',
                    ' . $safeQty . '
                )">Select</button>
              </td>';
        echo '</tr>';
    }
    echo '</tbody></table>';
    exit;
}
?>
