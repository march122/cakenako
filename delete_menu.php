<?php
include 'db/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the IDs from POST data
    $menu_id = isset($_POST['menu_id']) ? intval($_POST['menu_id']) : 0; // Menu ID
    $c_id = isset($_POST['c_id']) ? intval($_POST['c_id']) : 0; // Category ID
    $user_id = isset($_POST['user_id']) ? intval($_POST['user_id']) : 0; // User ID

    $response = ['success' => false, 'message' => 'Invalid ID.'];

    try {
        // Begin transaction
        $conn->begin_transaction();

        if ($menu_id > 0) {
            // Prepare and execute delete statement for menu items
            $sql = "DELETE FROM menu WHERE menu_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('i', $menu_id);

            if ($stmt->execute()) {
                $response = ['success' => true, 'message' => 'Menu item deleted successfully.'];
            } else {
                throw new Exception('Failed to delete menu item.');
            }

            $stmt->close();
        } elseif ($c_id > 0) {
            // Prepare and execute delete statement for categories
            $sql = "DELETE FROM categories WHERE c_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('i', $c_id);

            if ($stmt->execute()) {
                $response = ['success' => true, 'message' => 'Category deleted successfully.'];
            } else {
                throw new Exception('Failed to delete category.');
            }

            $stmt->close();
        } elseif ($user_id > 0) {
            // Prepare and execute delete statement for users
            $sql = "DELETE FROM users WHERE user_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('i', $user_id);

            if ($stmt->execute()) {
                $response = ['success' => true, 'message' => 'User deleted successfully.'];
            } else {
                throw new Exception('Failed to delete user.');
            }

            $stmt->close();
        }

        // Commit the transaction if successful
        $conn->commit();

    } catch (Exception $e) {
        // Rollback transaction on error
        $conn->rollback();
        $response = ['success' => false, 'message' => $e->getMessage()];
    }

    // Return the response as JSON
    echo json_encode($response);
}

// Close the database connection
$conn->close();
?>
