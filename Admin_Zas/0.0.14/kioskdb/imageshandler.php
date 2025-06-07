<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $productName = $_POST['product_display_name'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $status = 'Shown'; // or from input

    $image = $_FILES['immage'];
    $imageName = basename($image['name']);
    $targetDir = "uploads/";
    $targetFile = $targetDir . $imageName;

    if (move_uploaded_file($image['tmp_name'], $targetFile)) {
        // Save image filename in DB
        $conn = new mysqli('localhost', 'zas', 'group4', 'testing_backend');
        $stmt = $conn->prepare("INSERT INTO products (product_display_name, price, category, status, immage) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sdsss", $productName, $price, $category, $status, $imageName);
        $stmt->execute();
        echo "Product uploaded!";
    } else {
        echo "Upload failed.";
    }
}
?>
