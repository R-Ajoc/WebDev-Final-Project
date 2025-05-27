<?php
class Transaction {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Create a new transaction using the stored procedure
    public function create($items) {
        try {
            $this->conn->beginTransaction();

            $itemsJson = json_encode($items);

            // Prepare stored procedure call
            $stmt = $this->conn->prepare("CALL CreateTransaction(:p_items, @p_transaction_id)");
            $stmt->bindParam(':p_items', $itemsJson);
            $stmt->execute();
            $stmt->closeCursor();

            // Get the OUT parameter
            $result = $this->conn->query("SELECT @p_transaction_id AS transaction_id");
            $transaction_id = $result->fetch(PDO::FETCH_ASSOC)['transaction_id'];

            $this->conn->commit();
            return $transaction_id;
        } catch (Exception $e) {
            $this->conn->rollBack();
            throw $e;
        }
    }

    // Get all transactions
    public function getAll() {
    $stmt = $this->conn->prepare("CALL GetAllTransactions()");
    $stmt->execute();
    $transactions = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $transactions;
    }

    public function getMonthlySales($month, $year) {
    $stmt = $this->conn->prepare("SELECT SUM(total_amount) AS total_sales FROM transactions WHERE MONTH(transaction_date) = :month AND YEAR(transaction_date) = :year");
    $stmt->bindParam(':month', $month);
    $stmt->bindParam(':year', $year);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

}
?>

