<?php
session_start();

$redirect = isset($_SESSION['return_to']) ? $_SESSION['return_to'] : 'partsout.php';
unset($_SESSION['return_to']); // Optional: clean up

header("Location: $redirect");
exit;