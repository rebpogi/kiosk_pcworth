<?php
// Suppress error display to avoid HTML output
ini_set('display_errors', 0);
error_reporting(E_ALL);

$localhost = "localhost";      
$zas = "root";                  // DB username
$group4 = "";                   // DB password
$testing_backend = "testing_backend"; // DB name

$conn = mysqli_connect($localhost, $zas, $group4, $testing_backend);

// Check connection
if (!$conn) {
    // Return proper JSON if included via AJAX endpoint
    header('Content-Type: application/json');
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed']);
    exit();
}
?>
