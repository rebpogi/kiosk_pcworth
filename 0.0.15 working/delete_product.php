<?php
$connect = new mysqli("localhost", "zas", "group4", "testing_backend");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);

    $sql = "DELETE FROM products WHERE ID = $id";
    if ($connect->query($sql) === TRUE) {
        echo "Deleted successfully.";
    } else {
        echo "Failed to delete: " . $connect->error;
    }

    $connect->close();
} else {
    echo "Invalid request.";
}
?>
