<?php
class Menu {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Delete menu item by ID
    public function deleteMenuById($id) {
        $query = "DELETE FROM menu WHERE menu_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
?>
