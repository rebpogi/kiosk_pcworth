<?php
include 'db.php'; // Your DB connection file

    $sql = "SELECT * FROM products";
    $result = $conn->query($sql);

    $products = [];

    while ($row = $result->fetch_assoc()) {
        $products[] = [
            'name' => $row['product_display_name'],
            'image' => $row['immage'], // spelling as per your DB column
            'price' => $row['price']
        ];
    }

header('Content-Type: application/json');
echo json_encode($products);
?>