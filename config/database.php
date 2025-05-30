<?php 
class Database {
    private $host = "localhost";
    private $db_name = "sarismart";
    private $username = "root";
    private $password = "";
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO(
                "mysql:host={$this->host};dbname={$this->db_name}",
                $this->username,
                $this->password
            );
            $this->conn->exec("set names utf8");
        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
        if ($this->conn === null) {
            echo "Failed to establish a database connection."; 
        }
        return $this->conn;
    }
}
?>
