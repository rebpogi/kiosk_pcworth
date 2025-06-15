<?php
$host = "localhost";
$dbname = "testing_backend";
$username = "zas";
$password = "group4"; // Change if your MySQL has a password

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
