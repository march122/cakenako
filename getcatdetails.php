<?php
// Include your database config
include 'db/config.php';

// Get the category ID from the URL
$c_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($c_id <= 0) {
    echo json_encode(['error' => 'Invalid category ID.']);
    exit;
}

// Query to fetch category details
$query = "SELECT * FROM categories WHERE c_id = $c_id";
$result = mysqli_query($conn, $query);

// Check if the category exists
if (mysqli_num_rows($result) > 0) {
    // Fetch the category data
    $category = mysqli_fetch_assoc($result);
    echo json_encode($category); // Return the category details as JSON
} else {
    echo json_encode(['error' => 'Category not found.']);
}
?>
