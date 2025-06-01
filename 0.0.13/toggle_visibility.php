<?php
$connect = new mysqli("localhost", "zas", "group4", "testing_backend");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);

    // Get current status
    $sql = "SELECT status FROM products WHERE ID = $id LIMIT 1";
    $result = $connect->query($sql);

    if ($result && $row = $result->fetch_assoc()) {
        $current_status = $row['status'];
        // Toggle status (assuming status is 1 or 0)
        $new_status = $current_status ? 0 : 1;

        $update_sql = "UPDATE products SET status = $new_status WHERE ID = $id";
        if ($connect->query($update_sql) === TRUE) {
            echo $new_status ? "Product is now visible." : "Product is now hidden.";
        } else {
            echo "Failed to update status: " . $connect->error;
        }
    } else {
        echo "Product not found.";
    }

    $connect->close();
} else {
    echo "Invalid request.";
}
?>
