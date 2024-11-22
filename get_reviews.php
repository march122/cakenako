<?php
require_once 'config.php';

if (isset($_GET['menu_id'])) {
    $menu_id = $_GET['menu_id'];
    $query = "SELECT * FROM reviews WHERE menu_id = ? ORDER BY created_at DESC";

    if ($stmt = $mysqli->prepare($query)) {
        $stmt->bind_param('i', $menu_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            echo '<table class="table table-bordered">';
            echo '<thead><tr><th>Name</th><th>Rating</th><th>Review</th><th>Date</th></tr></thead>';
            echo '<tbody>';
            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($row['name']) . '</td>';
                echo '<td>' . $row['rating'] . ' / 5</td>';
                echo '<td>' . htmlspecialchars($row['message']) . '</td>';
                echo '<td>' . $row['created_at'] . '</td>';
                echo '</tr>';
            }
            echo '</tbody>';
            echo '</table>';
        } else {
            echo '<p>No reviews yet.</p>';
        }

        $stmt->close();
    }
}
?>
