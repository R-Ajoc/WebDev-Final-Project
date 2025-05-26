<?php
class AdminSecurity {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Get the stored password hash
    public function getPasswordHash() {
        $stmt = $this->conn->prepare("CALL GetAdminPassword()");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        return $result ? $result['password_hash'] : null;
    }

    // Update the password hash
    public function updatePassword($new_password_hash) {
        $stmt = $this->conn->prepare("CALL UpdateAdminPassword(:p_new_password_hash)");
        $stmt->bindParam(':p_new_password_hash', $new_password_hash);
        return $stmt->execute();
    }
}
?>
