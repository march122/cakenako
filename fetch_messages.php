<?php
// Drift API Token (replace with your actual API token)
$api_token = "your_api_token";

// Drift API endpoint to fetch conversations
$url = "https://driftapi.com/api/v1/conversations";

// Set the cURL options
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Bearer $api_token"
]);

$response = curl_exec($ch);
curl_close($ch);

// Decode the JSON response
$conversations = json_decode($response, true);

// Check if conversations are returned
if (isset($conversations['data'])) {
    $messages = [];

    // Loop through conversations and extract messages
    foreach ($conversations['data'] as $conversation) {
        foreach ($conversation['messages'] as $message) {
            $messages[] = [
                'author_name' => $message['author']['name'],
                'text' => $message['text'],
                'timestamp' => $message['created_at']
            ];
        }
    }
} else {
    $messages = [];
}

// Return messages as JSON
header('Content-Type: application/json');
echo json_encode(['messages' => $messages]);
?>
