<?php
require_once '../config/Database.php';
require_once '../model/Transaction.php';

$db = new Database();
$conn = $db->getConnection();

$transaction = new Transaction($conn);

// Determine which action to take
if (isset($_GET['action'])) {
    $action = $_GET['action'];

    switch ($action) {
        case 'getAll':
            $result = $transaction->getAll();
            echo json_encode($result);
            break;

        case 'getMonthlySales':
            $month = isset($_GET['month']) ? $_GET['month'] : date('m');
            $year = isset($_GET['year']) ? $_GET['year'] : date('Y');
            $result = $transaction->getMonthlySales($month, $year);
            echo json_encode($result);
            break;

        case 'create':
            if (isset($_POST['items'])) {
                $items = json_decode($_POST['items'], true);

                // Basic validation
                $valid = is_array($items);
                foreach ($items as $item) {
                    if (!isset($item['product_id']) || !isset($item['quantity'])) {
                        $valid = false;
                        break;
                    }
                }

                if (!$valid) {
                    echo json_encode(['success' => false, 'message' => 'Invalid item format.']);
                    break;
                }

                try {
                    $transaction_result = $transaction->create($items);
                    echo json_encode([
                        'success' => true,
                        'transaction_id' => $transaction_result['transaction_id'],
                        'items' => $transaction_result['items']
                    ]);
                } catch (Exception $e) {
                    error_log($e->getMessage()); // Don't expose to frontend
                    echo json_encode(['success' => false, 'message' => 'Transaction failed.']);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Missing items.']);
            }
            break;


        case 'getTotalTransactions':
            $result = $transaction->getTotalTransactions();
            echo json_encode($result);
            break;

        case 'getMonthlyTransactionCount':
            $month = isset($_GET['month']) ? $_GET['month'] : date('m');
            $year = isset($_GET['year']) ? $_GET['year'] : date('Y');
            $result = $transaction->getMonthlyTransactionCount($month, $year);
            echo json_encode($result);
            break;

        default:
            echo json_encode(['error' => 'Unknown action']);
    }
} else {
    echo json_encode(['error' => 'No action specified']);
}
?>
