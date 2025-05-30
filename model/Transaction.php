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

        
        foreach ($items as $item) {
            if (!isset($item['product_id']) || !isset($item['quantity'])) {
                throw new Exception('Invalid item structure. Each item must have product_id and quantity.');
            }
        }

       
        $itemsJson = json_encode($items);

        
        $stmt = $this->conn->prepare("CALL createTransaction(:p_items, @p_transaction_id)");
        $stmt->bindParam(':p_items', $itemsJson);
        $stmt->execute();
        $stmt->closeCursor();


        $result = $this->conn->query("SELECT @p_transaction_id AS transaction_id");
        $transaction_id = $result->fetch(PDO::FETCH_ASSOC)['transaction_id'];

        $this->conn->commit();

       
        return [
            'transaction_id' => $transaction_id,
            'items' => $items
        ];
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

    //new
    public function getTotalTransactions() {
    $stmt = $this->conn->prepare("SELECT COUNT(*) AS total_transactions FROM transactions");
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    //new
    public function getMonthlyTransactionCount($month, $year) {
    $stmt = $this->conn->prepare("SELECT COUNT(*) AS total_transactions FROM transactions WHERE MONTH(transaction_date) = :month AND YEAR(transaction_date) = :year");
    $stmt->bindParam(':month', $month, PDO::PARAM_INT);
    $stmt->bindParam(':year', $year, PDO::PARAM_INT);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row['total_transactions'] ?? 0;
    }
    

    //new - getSalesLog
    public function getSalesLog() {
    $stmt = $this->conn->prepare("
        SELECT 
            t.transaction_id, 
            p.product_name, 
            ti.quantity, 
            ti.subtotal AS total, 
            t.transaction_date AS date_created
        FROM transactions t
        JOIN transaction_items ti ON t.transaction_id = ti.transaction_id
        JOIN products p ON ti.product_id = p.product_id
        ORDER BY t.transaction_date DESC
    ");
    $stmt->execute();
    $salesLog = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $salesLog;
}
    public function checkStock($product_id) {
        $stmt = $this->conn->prepare("SELECT quantity FROM products WHERE product_id = :prod_id");
        $stmt->bindParam(':prod_id', $product_id, PDO::PARAM_INT);
        $stmt->execute();
        $stock = $stmt->fetch(PDO::FETCH_ASSOC);

        return $stock ? (int)$stock['quantity'] : null;
    }

}
?>


