<?php
header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);

include('db/config.php');

// Check connection
if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

$name = $conn->real_escape_string($input['name']);
$email = $conn->real_escape_string($input['email']);
$message = $conn->real_escape_string($input['message']);
$rating = $input['rating'];
$userImageUrl = $conn->real_escape_string($input['userImageUrl']);

$sql = "INSERT INTO reviews (name, email, message, rating, user_image_url) 
        VALUES ('$name', '$email', '$message', $rating, '$userImageUrl')";

if ($conn->query($sql) === TRUE) {
    echo json_encode(["success" => "Review submitted successfully"]);
} else {
    echo json_encode(["error" => "Error: " . $conn->error]);
}

$conn->close();
?>
