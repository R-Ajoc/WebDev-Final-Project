<?php
session_start();
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../model/Product.php';

$db = new Database();
$conn = $db->getConnection();
$product = new Product($conn);

// Fetch all products for display
$products = $product->getAll();
$categories = ['Drinks', 'Snacks', 'Canned Goods', 'Others'];

// Handle potential success/error messages (optional)
$successMsg = $_SESSION['success'] ?? null;
$errorMsg = $_SESSION['error'] ?? null;
unset($_SESSION['success'], $_SESSION['error']);
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
                <h1 class="ms-4 d-flex align-items-center fw-bold" style="color: #004aad;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" class="bi bi-box-seam me-2" viewBox="0 0 16 16">
                        <path d="M9.828.122a.5.5 0 0 1 .344 0l5 2a.5.5 0 0 1 .328.47v9.416a.5.5 0 0 1-.328.47l-5 2a.5.5 0 0 1-.344 0l-5-2a.5.5 0 0 1-.328-.47V2.592a.5.5 0 0 1 .328-.47l5-2zM10 1.203 6 2.57v9.118l4 1.856V1.203z"/>
                    </svg>
                    Inventory
                </h1>
                <h2 id="currentDate" class="me-4 text-secondary fst-italic" style="font-weight: 400; font-size: 1.25rem;"></h2>
            </div>
            <hr class="mt-3" style="border-top: 2px solid #004aad;">
        </div>
        <div class="container">
            <?php if ($successMsg): ?>
                <div id="success-alert" class="alert alert-success ms-4"><?= htmlspecialchars($successMsg) ?></div>
            <?php endif; ?>
            <?php if ($errorMsg): ?>
                <div class="alert alert-danger ms-4"><?= htmlspecialchars($errorMsg) ?></div>
            <?php endif; ?>

            <button type="button" class="ms-4 mb-3 btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                Add Product
            </button>

            <div class="col rounded ms-3 p-3 inventory-Item text-white">
                <div class="table-header d-flex justify-content-between align-items-center">
                    <div class="lowerDiv">Product List Table</div>
                </div>

                <div class="table-responsive">
                    <table id="productTable" class="display table table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Product ID</th>
                                <th>Product Name</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($products)): ?>
                                <?php foreach ($products as $p): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($p['product_id']) ?></td>
                                        <td><?= htmlspecialchars($p['product_name']) ?></td>
                                        <td><?= htmlspecialchars($p['category']) ?></td>
                                        <td><?= number_format($p['price'], 2) ?></td>
                                        <td><?= htmlspecialchars($p['quantity']) ?></td>
                                        <td>
                                            <div class="actionButton d-flex justify-content-evenly">
                                                <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#editModal<?= $p['product_id'] ?>">
                                                    Edit
                                                </button>
                                                <a href="../controller/ProductController.php?action=delete&id=<?= $p['product_id'] ?>"
                                                   class="btn btn-danger btn-sm"
                                                   onclick="return confirm('Are you sure you want to delete this product?');">
                                                    Delete
                                                </a>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Modal: Edit Product -->
                                    <div class="modal fade" id="editModal<?= $p['product_id'] ?>" tabindex="-1" aria-labelledby="editModalLabel<?= $p['product_id'] ?>" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form action="../controller/ProductController.php?action=update" method="post">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editModalLabel<?= $p['product_id'] ?>">Edit Product</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <input type="hidden" name="product_id" value="<?= $p['product_id'] ?>">
                                                        <div class="mb-3">
                                                            <label>Product Name</label>
                                                            <input type="text" class="form-control" name="product_name" value="<?= $p['product_name'] ?>" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label>Category</label>
                                                            <input type="text" class="form-control" name="category" value="<?= $p['category'] ?>" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label>Price</label>
                                                            <input type="number" class="form-control" name="price" value="<?= $p['price'] ?>" step="0.01" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label>Quantity</label>
                                                            <input type="number" class="form-control" name="quantity" value="<?= $p['quantity'] ?>" required>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-primary">Update</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="6" class="text-center">No products found.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal: Add Product -->
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form action="../controller/ProductController.php?action=add" method="POST" id="addProductForm">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addProductModalLabel">Add Item to Inventory</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="input-group mb-3">
                                <span class="input-group-text">Product Name</span>
                                <input type="text" class="form-control" name="product_name" required>
                            </div>
                            <div class="input-group mb-3">
                                <label class="input-group-text" for="categoryProd">Category</label>
                                <select class="form-select" id="categoryProd" name="category" required>
                                    <option value="" selected disabled>Choose...</option>
                                    <?php foreach ($categories as $cat): ?>
                                        <option value="<?= htmlspecialchars($cat) ?>"><?= htmlspecialchars($cat) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text">Price</span>
                                <input type="number" step="0.01" min="0" class="form-control" name="price" required>
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text">Quantity</span>
                                <input type="number" min="0" class="form-control" name="quantity" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>    
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
    $(document).ready(function () {
        $('#productTable').DataTable({
            pageLength: 5,
            scrollX: true,
            scrollCollapse: true,
            paging: true,
            lengthChange: false
        });
    });

    document.addEventListener("DOMContentLoaded", () => {
        const dtFilter = document.querySelector('.dataTables_filter');
        const headerDiv = document.querySelector('.table-header');
        if (dtFilter && headerDiv) {
            headerDiv.appendChild(dtFilter);
        }

        function updateTime() {
            const now = new Date();
            const date = now.toLocaleDateString();
            const time = now.toLocaleTimeString();
            document.getElementById("currentDate").textContent = `${date} ${time}`;
        }

        updateTime();
        setInterval(updateTime, 1000);
    });

    document.addEventListener("DOMContentLoaded", function () {
        const successAlert = document.getElementById("success-alert");
        if (successAlert) {
            setTimeout(() => {
               
                successAlert.classList.add("fade");
                successAlert.classList.remove("show");

               
                setTimeout(() => {
                    successAlert.style.display = "none";
                }, 500); // Matches Bootstrap's fade transition duration
            }, 1000); // Delay before starting fade-out (1 second)
        }
    });
</script>
</body>
</html>
