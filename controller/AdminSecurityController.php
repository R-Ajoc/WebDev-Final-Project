<?php
session_start();
header('Content-Type: application/json');

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../model/AdminSecurity.php';

$db = new Database();
$conn = $db->getConnection();
$adminModel = new AdminSecurity($conn);

$action = $_GET['action'] ?? '';

switch ($action) {
    case 'login':
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['password'])) {
        $password = $_POST['password'];
        $hash = $adminModel->getPasswordHash();

        if ($hash && password_verify($password, $hash)) {
            $_SESSION['admin_logged_in'] = true;
            header('Location: ../view/dashboard.php');
            exit;
        } else {
            header('Location: ../view/EntryPage.php?error=1');
            exit;
        }
    }
    break;

    case 'updatePassword':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (empty($_SESSION['admin_logged_in'])) {
                http_response_code(403);
                echo json_encode(['success' => false, 'message' => 'Unauthorized']);
                exit;
            }

            $current_password = $_POST['current_password'] ?? '';
            $new_password = $_POST['new_password'] ?? '';

            if ($current_password === '' || $new_password === '') {
                echo json_encode(['success' => false, 'message' => 'Current and new passwords are required']);
                exit;
            }

            $hash = $adminModel->getPasswordHash();

            if (!$hash || !password_verify($current_password, $hash)) {
                echo json_encode(['success' => false, 'message' => 'Current password is incorrect']);
                exit;
            }

            $new_hash = password_hash($new_password, PASSWORD_DEFAULT);
            $updated = $adminModel->updatePassword($new_hash);

            echo json_encode(['success' => $updated, 'message' => $updated ? 'Password updated' : 'Failed to update password']);
        }
        exit;

    case 'logout':
        session_unset();
        session_destroy();
        echo json_encode(['success' => true, 'message' => 'Logged out']);
        exit;

    case 'check':
        echo json_encode(['logged_in' => !empty($_SESSION['admin_logged_in'])]);
        exit;

    default:
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
        exit;
}
?>
