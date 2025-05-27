<?php
require_once 'model/TransactionItem.php';
require_once 'config/Database.php';

class TransactionItemController {
    private $transactionItemModel;

    public function __construct() {
        $db = (new Database())->connect();
        $this->transactionItemModel = new TransactionItem($db);
    }

    public function getItemsByTransaction() {
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['transaction_id'])) {
            $transaction_id = $_GET['transaction_id'];

            try {
                $items = $this->transactionItemModel->getItemsByTransaction($transaction_id);
                echo json_encode([
                    'success' => true,
                    'data' => $items
                ]);
            } catch (Exception $e) {
                http_response_code(500);
                echo json_encode([
                    'success' => false,
                    'message' => 'Failed to fetch items.',
                    'error' => $e->getMessage()
                ]);
            }
        } else {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => 'Missing or invalid transaction ID.'
            ]);
        }
    }

    
    public function deleteItemsByTransaction() {
        if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && isset($_GET['transaction_id'])) {
            $transaction_id = $_GET['transaction_id'];

            try {
                $success = $this->transactionItemModel->deleteByTransaction($transaction_id);
                echo json_encode([
                    'success' => $success,
                    'message' => $success ? 'Items deleted successfully.' : 'Failed to delete items.'
                ]);
            } catch (Exception $e) {
                http_response_code(500);
                echo json_encode([
                    'success' => false,
                    'message' => 'Error deleting items.',
                    'error' => $e->getMessage()
                ]);
            }
        } else {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => 'Missing or invalid transaction ID.'
            ]);
        }
    }
}
