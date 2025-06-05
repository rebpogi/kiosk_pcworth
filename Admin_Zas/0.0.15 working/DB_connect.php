<?php
// DB_connect.php

ini_set('display_errors', 0);   // Prevent HTML error output
ini_set('log_errors', 1);       // Log errors to error log file
error_reporting(E_ALL);         // Report all errors

$localhost = "localhost";       // Or "127.0.0.1"
$zas = "root";                  // DB username
$group4 = "";                   // DB password
$testing_backend = "testing_backend"; // DB name

$conn = mysqli_connect($localhost, $zas, $group4, $testing_backend);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
