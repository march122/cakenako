<?php

// Fetch filtered discounts
function get_filtered_discounts($filter)
{
    global $conn;
    $discounts = [];

    // Base query
    $query = "SELECT discount_id, discount_value, discount_name, discount_code, start_date, end_date, status FROM discounts";
    $params = [];
    $types = '';

    // Add filtering by status if provided
    if (!empty($filter['status'])) {
        $query .= " WHERE status = ?";
        $params[] = $filter['status'];
        $types .= 's';
    }

    // Prepare and execute the query
    $stmt = $conn->prepare($query);
    if ($stmt) {
        if ($params) {
            $stmt->bind_param($types, ...$params); // Bind params dynamically
        }
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $discounts[] = $row; // Populate discounts array
        }
        $stmt->close();
    } else {
        error_log("Query preparation failed: " . $conn->error); // Log error if the query preparation fails
    }

    return $discounts;
}

// Fetch discount details for view/edit
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'get_discount') {
    $discount_id = $_POST['discount_id'];

    $query = "SELECT * FROM discounts WHERE discount_id = ?";
    $stmt = $conn->prepare($query);
    if ($stmt) {
        $stmt->bind_param('i', $discount_id); // Bind the discount_id to the query
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $discount = $result->fetch_assoc();
            echo json_encode($discount); // Return the discount data as JSON
        } else {
            echo json_encode(['error' => 'Discount not found']); // Handle case if discount is not found
        }

        $stmt->close();
    } else {
        echo json_encode(['error' => 'Query preparation failed']); // Error if SQL query fails
    }
    exit();
}

// Save discount changes (edit functionality)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'save_discount') {
    $discount_id = $_POST['discount_id'];
    $discount_name = $_POST['discount_name'];
    $discount_code = $_POST['discount_code'];
    $discount_value = $_POST['discount_value'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $status = $_POST['status'];

    $query = "UPDATE discounts SET discount_name = ?, discount_code = ?, discount_value = ?, start_date = ?, end_date = ?, status = ? WHERE discount_id = ?";
    $stmt = $conn->prepare($query);
    if ($stmt) {
        $stmt->bind_param('ssisssi', $discount_name, $discount_code, $discount_value, $start_date, $end_date, $status, $discount_id);
        if ($stmt->execute()) {
            echo 'success'; // Return success response if execution is successful
        } else {
            echo 'error'; // Return error response if the update fails
        }
        $stmt->close();
    } else {
        echo 'error'; // Handle query preparation error
    }
    exit();
}

// Delete discount functionality
if (isset($_GET['action']) && $_GET['action'] == 'delete_discount' && isset($_GET['discount_id'])) {
    $discount_id = $_GET['discount_id'];

    // SQL query to delete the discount
    $query = "DELETE FROM discounts WHERE discount_id = ?";
    $stmt = $conn->prepare($query);

    if ($stmt) {
        $stmt->bind_param('i', $discount_id); // Bind the discount_id to the query
        if ($stmt->execute()) {
            echo 'success'; // Return success response for Ajax if deletion is successful
        } else {
            echo 'error'; // Return error response if deletion fails
        }
        $stmt->close();
    } else {
        echo 'error'; // Return error if query preparation failed
    }
    exit();
}

?>
