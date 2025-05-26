<?php
class TransactionItem {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Get all items of a transaction
    public function getItemsByTransaction($transaction_id) {
        $stmt = $this->conn->prepare("CALL GetTransactionItems(:p_transaction_id)");
        $stmt->bindParam(':p_transaction_id', $transaction_id);
        $stmt->execute();
        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $items;
    }

    // Delete all items for a transaction (optional, for clearing)
    public function deleteByTransaction($transaction_id) {
        $stmt = $this->conn->prepare("CALL DeleteTransactionItems(:p_transaction_id)");
        $stmt->bindParam(':p_transaction_id', $transaction_id);
        return $stmt->execute();
    }
}
?>
