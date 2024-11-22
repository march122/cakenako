<?php
$connection = new mysqli('localhost', 'username', 'password', 'database');

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

$reservationId = $_GET['reservationId'];

// Fetch reservation details
$reservationQuery = "SELECT * FROM Reservations WHERE id = $reservationId";
$reservationResult = $connection->query($reservationQuery);
$reservation = $reservationResult->fetch_assoc();

// Fetch associated menu items
$menuQuery = "SELECT * FROM reservationMenu WHERE ReservationID = $reservationId";
$menuResult = $connection->query($menuQuery);
$menuItems = [];
while ($row = $menuResult->fetch_assoc()) {
    $menuItems[] = $row;
}

// Return data as JSON
echo json_encode(['reservation' => $reservation, 'menuItems' => $menuItems]);

$connection->close();
?>
