<?php
require_once 'model/Transaction.php'; 
require_once 'config/Database.php';  // may need adjustment since db is not created yet at this point

class TransactionController {
    private $transactionModel;

    public function __construct() {
        $db = (new Database())->connect(); 
        $this->transactionModel = new Transaction($db);
    }

    // create Transactions
    public function createTransaction() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $items = $_POST['items'] ?? [];

            if (!empty($items)) {
                try {
                    $transactionId = $this->transactionModel->create($items);
                    echo json_encode([
                        'success' => true,
                        'message' => 'Transaction created successfully.',
                        'transaction_id' => $transactionId
                    ]);
                } catch (Exception $e) {
                    http_response_code(500);
                    echo json_encode([
                        'success' => false,
                        'message' => 'Failed to create transaction.',
                        'error' => $e->getMessage()
                    ]);
                }
            } else {
                http_response_code(400);
                echo json_encode([
                    'success' => false,
                    'message' => 'No items provided.'
                ]);
            }
        }
    }

    // get transactions
    public function getAllTransactions() {
        try {
            $transactions = $this->transactionModel->getAll();
            echo json_encode([
                'success' => true,
                'data' => $transactions
            ]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Failed to retrieve transactions.',
                'error' => $e->getMessage()
            ]);
        }
    }
}
