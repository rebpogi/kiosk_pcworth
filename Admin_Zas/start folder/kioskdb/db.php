<?php
$host = "localhost";     // or your host
$username = "zas";      // your DB username
$password = "group4";          // your DB password
$dbname = "testing_backend";     // your database name

$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>