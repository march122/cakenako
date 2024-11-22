<?php
include 'db/config.php';   // Database configuration
include 'functions.php';         // Include the Menu class

// Initialize database connection and Menu class
$menu = new Menu($conn);

if (isset($_POST['id'])) {
    $menu_id = (int)$_POST['id'];

    if ($menu->deleteMenuById($menu_id)) {
        echo 'success';
    } else {
        echo 'error';
    }
} else {
    echo 'error';
}

$conn->close();
?>
