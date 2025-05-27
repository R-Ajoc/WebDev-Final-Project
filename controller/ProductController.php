<?php
class ProductController {
    private $productModel;

    public function __construct($db) {
        $this->productModel = new Product($db);
    }

    // Add a product
    public function addProduct() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['product_name'];
            $category = $_POST['category'];
            $price = $_POST['price'];
            $quantity = $_POST['quantity'];

            $success = $this->productModel->add($name, $category, $price, $quantity);

            echo json_encode(['success' => $success]);
        }
    }

    // Update a product
    public function updateProduct() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['product_id'];
            $name = $_POST['product_name'];
            $category = $_POST['category'];
            $price = $_POST['price'];
            $quantity = $_POST['quantity'];

            $success = $this->productModel->update($id, $name, $category, $price, $quantity);

            echo json_encode(['success' => $success]);
        }
    }

    // Delete a product
    public function deleteProduct() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['product_id'];
            $success = $this->productModel->delete($id);
            echo json_encode(['success' => $success]);
        }
    }

    // Get all products
    public function getAllProducts() {
        $products = $this->productModel->getAll();
        echo json_encode($products);
    }

    // Get top-selling product (for a given month)
    public function getTopSellingProduct() {
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['month'])) {
            $month = $_GET['month']; // format: YYYY-MM
            $stmt = $this->productModel->conn->prepare("CALL TopSelling(:target_month)");
            $stmt->bindParam(':target_month', $month);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            echo json_encode($result);
        }
    }
}
?>
