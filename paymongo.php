<?php
session_start();
// Database connection details
$host = 'localhost'; // or your database server
$dbname = 'cake_db'; // your database name
$username = 'root';
$password = ''; 

// Create a new PDO instance (this should be the database connection object)
try {
    // Connect to the database
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception to handle errors
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // If connection fails, display error message
    echo "Database connection failed: " . $e->getMessage();
    exit; // Stop further execution
}



// PayMongo API Key (use an environment variable in production)
$api_key = 'sk_test_a1ZMzqyoDN52eagaxepwv6rm';

// Function to create a payment link
function createPaymentLink($api_key, $totalAmount, $description, $success_url, $cancel_url) {
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "https://api.paymongo.com/v1/links");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
        'data' => [
            'attributes' => [
                'amount' => $totalAmount, // Amount in cents
                'currency' => "PHP",
                'description' => $description,
                'payment_method_types' => ['gcash', 'paymaya', 'card'],
                'success_url' => $success_url,
                'cancel_url' => $cancel_url,
            ]
        ]
    ]));

    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Basic ' . base64_encode($api_key . ':'), // Adjust for authentication
        'Content-Type: application/json'
    ]);

    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        throw new Exception('cURL Error: ' . curl_error($ch));
    }
    curl_close($ch);

    return json_decode($response, true);
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize form data
    $firstName = htmlspecialchars($_POST['first_name'] ?? '');
    $lastName = htmlspecialchars($_POST['last_name'] ?? '');
    $address = htmlspecialchars($_POST['address'] ?? '');
    $city = htmlspecialchars($_POST['city'] ?? '');
    $items = json_decode($_POST['items'], true);
    $totalAmount = isset($_POST['total_amount']) ? (float)$_POST['total_amount'] : 0.00;

    // Validate necessary fields (checking for empty inputs)
    if (empty($firstName) || empty($lastName) || empty($address) || empty($city) || empty($items)) {
        echo "Please provide all required fields.";
        exit;
    }

    // Insert order into the database
    try {
        $stmt = $pdo->prepare("INSERT INTO reservation (first_name, last_name, address, city, items, total_amount) 
                               VALUES (:first_name, :last_name, :address, :city, :items, :total_amount)");

        $stmt->execute([
            ':first_name' => $firstName,
            ':last_name' => $lastName,
            ':address' => $address,
            ':city' => $city,
            ':items' => json_encode($items), // Convert items array to JSON
            ':total_amount' => $totalAmount
        ]);

        // Order successfully inserted, now create a PayMongo payment link
        $successUrl = "https://yourdomain.com/payment_success.php";  // Update with your actual success URL
        $cancelUrl = "https://yourdomain.com/payment_cancel.php";    // Update with your actual cancel URL

        $paymentLink = createPaymentLink($api_key, $totalAmount * 100, "Payment for Order", $successUrl, $cancelUrl);

        // Debugging: print the entire response to check the data
        echo "<pre>";
        print_r($paymentLink);
        echo "</pre>";

        // Check if the 'checkout_url' key exists in the response
        if (isset($paymentLink['data']['attributes']['checkout_url'])) {
            $paymentUrl = $paymentLink['data']['attributes']['checkout_url'];
            // Redirect user to the PayMongo payment page
            header("Location: $paymentUrl");
            exit;
        } else {
            // Handle the case where the URL is not found
            echo "Error: Payment link URL not found in the response.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid request method.";
}
?>
