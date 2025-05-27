<?php
session_start();

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../model/Product.php';

$db = new Database();
$conn = $db->getConnection();
$product = new Product($conn);

$action = $_GET['action'] ?? '';

switch ($action) {
    case 'add':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $product_name = trim($_POST['product_name'] ?? '');
            $category = trim($_POST['category'] ?? '');
            $price = filter_var($_POST['price'] ?? '', FILTER_VALIDATE_FLOAT);
            $quantity = filter_var($_POST['quantity'] ?? '', FILTER_VALIDATE_INT);

            // Validate inputs; redirect back on failure
            if ($product_name === '' || $category === '' || $price === false || $quantity === false) {
                $_SESSION['error'] = "Invalid input data. Please try again.";
                header("Location: ../view/InventoryPage.php");
                exit();
            }

            $product->add($product_name, $category, $price, $quantity);
            $_SESSION['success'] = "Product added successfully.";
            header("Location: ../view/InventoryPage.php");
            exit();
        }
        break;

    case 'update':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = filter_var($_POST['product_id'] ?? '', FILTER_VALIDATE_INT);
            $product_name = trim($_POST['product_name'] ?? '');
            $category = trim($_POST['category'] ?? '');
            $price = filter_var($_POST['price'] ?? '', FILTER_VALIDATE_FLOAT);
            $quantity = filter_var($_POST['quantity'] ?? '', FILTER_VALIDATE_INT);

            if ($id === false || $product_name === '' || $category === '' || $price === false || $quantity === false) {
                $_SESSION['error'] = "Invalid input data. Please try again.";
                header("Location: ../view/InventoryPage.php");
                exit();
            }

            $product->update($id, $product_name, $category, $price, $quantity);
            $_SESSION['success'] = "Product updated successfully.";
            header("Location: ../view/InventoryPage.php");
            exit();
        }
        break;

    case 'delete':
        if (isset($_GET['id'])) {
            $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
            if ($id !== false) {
                $product->delete($id);
                $_SESSION['success'] = "Product deleted successfully.";
            } else {
                $_SESSION['error'] = "Invalid product ID.";
            }
            header("Location: ../view/InventoryPage.php");
            exit();
        }
        break;

    case 'getTotalProducts':
            $result = $product->getTotalProducts();
            echo json_encode($result);
            break;

    //new
    case 'getLowStockProducts':
        $threshold = isset($_GET['threshold']) ? intval($_GET['threshold']) : 5;
        $result = $product->getLowStockProducts($threshold);
        echo json_encode($result);
        break;

    default:
        header("Location: ../view/InventoryPage.php");
        exit();
}
?>
