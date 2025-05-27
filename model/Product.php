<?php 
class Product {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Add a new product
    public function add($product_name, $category, $price, $quantity) {
        $stmt = $this->conn->prepare("CALL AddProduct(:p_product_name, :p_category, :p_price, :p_quantity)");
        $stmt->bindParam(':p_product_name', $product_name);
        $stmt->bindParam(':p_category', $category);
        $stmt->bindParam(':p_price', $price);
        $stmt->bindParam(':p_quantity', $quantity);
        return $stmt->execute();
    }

    // Update an existing product
    public function update($product_id, $product_name, $category, $price, $quantity) {
        $stmt = $this->conn->prepare("CALL UpdateProduct(:p_product_id, :p_product_name, :p_category, :p_price, :p_quantity)");
        $stmt->bindParam(':p_product_id', $product_id);
        $stmt->bindParam(':p_product_name', $product_name);
        $stmt->bindParam(':p_category', $category);
        $stmt->bindParam(':p_price', $price);
        $stmt->bindParam(':p_quantity', $quantity);
        return $stmt->execute();
    }

    // Delete a product
    public function delete($product_id) {
        $stmt = $this->conn->prepare("CALL DeleteProduct(:p_product_id)");
        $stmt->bindParam(':p_product_id', $product_id);
        return $stmt->execute();
    }

    // Get all products
    public function getAll() {
        $stmt = $this->conn->prepare("SELECT * FROM products");
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $products;
    }

    public function getTopSelling() {
        $stmt = $this->conn->prepare("CALL TopSelling()");
        $stmt->execute();
        $topProducts = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $topProducts;
    }
}
?>
