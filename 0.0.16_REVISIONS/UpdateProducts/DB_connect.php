<?php
// DB_connect.php

$localhost = "localhost";      
$zas = "root";                  // DB username
$group4 = "";                   // DB password
$testing_backend = "testing_backend"; // DB name

$conn = mysqli_connect($localhost, $zas, $group4, $testing_backend);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
