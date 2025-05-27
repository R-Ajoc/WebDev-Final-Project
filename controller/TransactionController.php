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
                try {
                    $transaction_id = $transaction->create($items);
                    echo json_encode(['success' => true, 'transaction_id' => $transaction_id]);
                } catch (Exception $e) {
                    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Missing items']);
            }
            break;

        default:
            echo json_encode(['error' => 'Unknown action']);
    }
} else {
    echo json_encode(['error' => 'No action specified']);
}
?>
