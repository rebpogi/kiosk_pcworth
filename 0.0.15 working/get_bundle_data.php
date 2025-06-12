<?php
require_once 'DB_connect.php';

if (!isset($_GET['id'])) {
    echo json_encode(['error' => 'No bundle ID provided']);
    exit;
}

$bundle_id = mysqli_real_escape_string($conn, $_GET['id']);

// Get bundle details
$sql = "SELECT * FROM bundles WHERE id = '$bundle_id'";
$result = mysqli_query($conn, $sql);

if ($bundle = mysqli_fetch_assoc($result)) {
    // Get bundle parts
    $parts_sql = "SELECT * FROM bundle_parts WHERE bundle_id = '$bundle_id'";
    $parts_result = mysqli_query($conn, $parts_sql);
    
    $parts = [];
    while ($part = mysqli_fetch_assoc($parts_result)) {
        $parts[] = $part;
    }
    
    $bundle['parts'] = $parts;
    echo json_encode($bundle);
} else {
    echo json_encode(['error' => 'Bundle not found']);
}
?>
