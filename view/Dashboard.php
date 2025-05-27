<?php
session_start();
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../model/Product.php';
require_once __DIR__ . '/../model/Transaction.php';

$database = new Database();
$conn = $database->getConnection();

if ($conn === null) {
    die("Database connection is not set.");
}

$product = new Product($conn);
$transaction = new Transaction($conn);

// Fetch data
$totalProducts = $product->getTotalProducts();
$monthlySales = $transaction->getMonthlySales(date('m'), date('Y'));
$topSelling = $product->getTopSelling(date('Y-m'));
$lowStockProducts = $product->getLowStockProducts(5);  
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>SARISMART MANAGEMENT SYSTEM</title>
    <link href="../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/jQuery/jquery-ui.css">
    <link href="../assets/DataTables/datatables.min.css" rel="stylesheet">
    <link href="../assets/Dashboard.css" rel="stylesheet">
</head>
<body>
    <?php include 'sidebar.php'; ?>

    <div class="Inventory">
        <div class="dashBoard-content py-3">
            <div class="header-content d-flex justify-content-between align-items-center rounded p-3" style="background-color: transparent;">
                <h1 class="ms-4 d-flex align-items-center fw-bold" style="color: #004aad; font-size: 2rem; font-weight: 600;">
                    Dashboard
                </h1>
                <h2 id="currentDate" class="me-4 text-secondary fst-italic" style="font-weight: 400; font-size: 1.25rem;"></h2>
            </div>
            <hr class="mt-1" style="border-top: 2px solid #004aad;">
        </div>

        <div class="main-content">

            <!-- Stock Alert, mostly suwat ra, wala pakoy idea unsaon jud -->
             <!-- Stock Alert, updated -->
            <div class="mb-4">
                <div class="low-stock-alert">
                    <h4 class="mb-0">Stock Alert: Check low inventory levels regularly!</h4>
                    <br>
                    <?php if (!empty($lowStockProducts)): ?>
                        <p class="mb-0" style="color:rgb(233, 28, 13)">WARNING! LOW STOCK ON SOME ITEMS!</p>
                        
                        <table>
                            <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>Category</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($lowStockProducts as $item): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($item['product_name']) ?></td>
                                        <td><?= htmlspecialchars($item['category']) ?></td>
                                        <td><?= number_format($item['price'], 2) ?></td>
                                        <td><?= intval($item['quantity']) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p>No low stock items found.</p>
                    <?php endif; ?>
                </div>
            </div>

            
            <div class="row g-4">
                <!-- Total No. of Products -->
                <div class="col-md-4 col-sm-12">
                    <div class="rounded p-4 text-white text-center" style="background-color: #004aad;">
                        <h5>Total No. of Products</h5>
                        <h3><?= htmlspecialchars($totalProducts['total'] ?? '0') ?></h3>
                    </div>
                </div>

                <!-- Monthly Sales -->
                <div class="col-md-4 col-sm-12">
                    <div class="rounded p-4 text-white text-center" style="background-color: #004aad;">
                        <h5>Total Monthly Sales</h5>
                        <h3>₱<?= number_format($monthlySales['total_sales'] ?? 0, 2) ?></h3>
                    </div>
                </div>

                <!-- Top-selling Product -->
                <div class="col-md-4 col-sm-12">
                    <div class="rounded p-4 text-white text-center" style="background-color: #004aad;">
                        <h5>Top-selling Product</h5>
                        <h3><?= htmlspecialchars($topSelling[0]['product_name'] ?? 'N/A') ?></h3>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="../assets/jQuery/jquery.js"></script>
    <script src="../assets/jQuery/jquery-ui.js"></script>
    <script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/DataTables/datatables.min.js"></script>

    <script>
        function updateTime() {
            const now = new Date();
            const date = now.toLocaleDateString();
            const time = now.toLocaleTimeString();
            document.getElementById("currentDate").textContent = `${date} ${time}`;
        }

        updateTime();
        setInterval(updateTime, 1000);
    </script>
</body>
</html>
