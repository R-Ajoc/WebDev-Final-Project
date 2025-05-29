<?php
session_start();
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../model/Product.php';
require_once __DIR__ . '/../model/Transaction.php';

$database = new Database();
$conn = $database->getConnection();

$product = new Product($conn);
$transaction = new Transaction($conn);

// AJAX request
if (isset($_GET['ajax']) && $_GET['ajax'] === '1' && isset($_GET['month'])) {
    $month = str_pad($_GET['month'], 2, '0', STR_PAD_LEFT); // gi two digits
    $year = date('Y');

    $totalSalesAmount = $transaction->getMonthlySales($month, $year)['total_sales'] ?? 0;
    $totalTransactions = $transaction->getMonthlyTransactionCount($month, $year) ?? 0;
    $bestSeller = $product->getTopSelling("$year-$month")[0]['product_name'] ?? null;

    echo json_encode([
        'total_sales' => $totalSalesAmount,
        'total_transactions' => $totalTransactions,
        'best_seller' => $bestSeller
    ]);
    exit; 
}
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
    <link href="../assets/inventory.css" rel="stylesheet">
</head>
<body>
    <?php include 'sidebar.php'; ?>

    <div class="Inventory">
        <div class="dashBoard-content py-3">
            <div class="header-content d-flex justify-content-between align-items-center rounded p-3" style="background-color: transparent;">
                <h1 class="ms-4 d-flex align-items-center fw-bold" style="color: #004aad; font-size: 2rem; font-weight: 600;">
                    Sales Report
                </h1>
                <h2 id="currentDate" class="me-4 text-secondary fst-italic" style="font-weight: 400; font-size: 1.25rem;"></h2>
            </div>
            <hr class="mt-1" style="border-top: 2px solid #004aad;">
        </div>

        <section class="container">
            <div class="bg-primary text-white py-5 px-4 rounded-4" style="background-color: #004aad !important;">
                
                <!-- Pick Month Dropdown inside container -->
                <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
                    <h5 class="mb-2 fw-bold">Pick Month</h5>
                    <select class="form-select w-auto bg-white text-dark" aria-label="Select Month" id="monthSelector">
                        <option selected disabled>Select Month</option>
                        <option value="1">January</option>
                        <option value="2">February</option>
                        <option value="3">March</option>
                        <option value="4">April</option>
                        <option value="5">May</option>
                        <option value="6">June</option>
                        <option value="7">July</option>
                        <option value="8">August</option>
                        <option value="9">September</option>
                        <option value="10">October</option>
                        <option value="11">November</option>
                        <option value="12">December</option>
                    </select>
                </div>

                <!-- Main Sales Boxes -->
                <div class="row g-4">
                    <!-- Total Sales Amount - Large Container -->
                    <div class="col-lg-9">
                        <div class="border border-white p-5 rounded-4 h-100 text-center d-flex flex-column justify-content-center">
                            <h3>Total Sales Amount</h3>
                            <h1 class="fw-bold display-4" id="totalSales">₱0.00</h1>
                        </div>
                    </div>

                    <!-- Side Boxes -->
                    <div class="col-lg-3 d-flex flex-column gap-4">
                        <div class="border border-white p-4 rounded-4 text-center">
                            <h6 class="mb-1">No. of Transactions</h6>
                            <h3 class="fw-bold" id="totalTransactions">0</h3>
                        </div>
                        <div class="border border-white p-4 rounded-4 text-center">
                            <h6 class="mb-1">Best-selling Product</h6>
                            <h3 class="fw-bold" id="bestSeller">N/A</h3>
                        </div>
                    </div>
                </div>
            </div>
        </section>
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

        document.getElementById('monthSelector').addEventListener('change', function() {
            const selectedMonth = this.value;

            fetch('SalesReport.php?ajax=1&month=' + selectedMonth)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('totalSales').textContent = '₱' + parseFloat(data.total_sales).toFixed(2);
                    document.getElementById('totalTransactions').textContent = data.total_transactions;
                    document.getElementById('bestSeller').textContent = data.best_seller || 'N/A';
                })
                .catch(error => console.error('Error fetching sales data:', error));
        });
    </script>
</body>
</html>
