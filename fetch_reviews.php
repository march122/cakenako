<?php
header('Content-Type: application/json');

include('db/config.php');

// Get the offset from the URL parameter
$offset = isset($_GET['offset']) ? (int)$_GET['offset'] : 0;
$reviews_per_page = 5; // Number of reviews to load per request

// SQL query to fetch reviews based on offset, limit, and status 'Active'
$sql = "SELECT name, email, message, rating, user_image_url, created_at 
        FROM reviews 
        WHERE status = 'Approve' 
        ORDER BY created_at DESC 
        LIMIT $reviews_per_page OFFSET $offset";

$result = $conn->query($sql);

// To calculate overall rating
$totalRatings = 0; // Sum of ratings
$ratingCount = 0;  // Total number of ratings
$reviews = [];

// Process each review
while ($row = $result->fetch_assoc()) {
    $totalRatings += $row['rating']; // Sum the ratings
    $ratingCount++; // Count the ratings
    $reviews[] = $row;
}

// Calculate the overall rating (average)
$overallRating = $ratingCount > 0 ? round($totalRatings / $ratingCount, 1) : 0;

$conn->close();

// Return reviews, total ratings, rating count, and overall rating as JSON
echo json_encode([
    "reviews" => $reviews,
    "overallRating" => $overallRating,
    "ratingCount" => $ratingCount,
    "totalRatings" => $totalRatings
]);
?>
