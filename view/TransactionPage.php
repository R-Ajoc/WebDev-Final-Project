<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>SARISMART MANAGEMENT SYSTEM</title>
    <link href="../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/jQuery/jquery-ui.css">
    <link href="../assets/DataTables/datatables.min.css" rel="stylesheet">
    <link href="../assets/Transaction.css" rel="stylesheet">
    <link href="../assets/inventory.css" rel="stylesheet">

<!--     Used for generating a downloadable Sales Report PDF format, needed for online -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.28/jspdf.plugin.autotable.min.js"></script>
</head>
<body>
    <?php include 'sidebar.php'; ?>

    <div class="Inventory">
        <div class="dashBoard-content py-3">
            <div class="header-content d-flex justify-content-between align-items-center rounded p-3" style="background-color: transparent;">
                <h1 class="ms-4 d-flex align-items-center fw-bold" style="color: #004aad; font-size: 2rem; font-weight: 600;">
                    Transactions
                </h1>
                <h2 id="currentDate" class="me-4 text-secondary fst-italic" style="font-weight: 400; font-size: 1.25rem;"></h2>
            </div>
            <hr class="mt-1" style="border-top: 2px solid #004aad;">
        </div>

        <!-- POS Section -->
        <div class="container-fluid py-3">
            <div class="row gy-4 gx-3">

                <!-- POS Container -->
                <div class="col-md-6">
                    <div class="p-3 rounded shadow-sm" style="background-color: #004aad; color: white;">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="mb-0">POS</h4>
                            <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#addItemModal">
                                Add Item
                            </button>
                        </div>

                        <div class="table-responsive bg-white rounded p-2" style="max-height: 400px; overflow-y: auto;">
                            <table id="posTable" class="table table-bordered text-center align-middle mb-0 small">
                                <thead style="background-color: #e9ecef;">
                                    <tr>
                                        <th style="display:none;">Product ID</th>
                                        <th>Product Name</th>
                                        <th>Qty</th>
                                        <th>Price</th>
                                        <th>Subtotal</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Dynamic rows -->
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap">
                            <div class="d-flex align-items-center mb-2 mb-md-0">
                                <label for="totalAmount" class="me-2 mb-0">Total</label>
                                <input type="text" id="totalAmount" class="form-control form-control-sm" style="width: 150px;" readonly />
                            </div>
                            <div>
                                <button class="btn btn-sm btn-success me-2" id="recordTransaction">Record</button>
                                <button class="btn btn-sm btn-danger" id="clearTransaction">Clear</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sales Log Section -->
                <div class="col-md-6 p-3 rounded" style="background-color: #004aad; color: white;">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="mb-0">Sales Log</h4>
                        <button class="btn btn-primary btn-sm" id="printSalesLog">Print</button>
                    </div>
                    <div class="table-responsive bg-white rounded p-2" style="max-height: 400px; overflow-y: auto;">
                        <table id="salesLogTable" class="table table-bordered text-center align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Product Name</th>
                                    <th>Quantity</th>
                                    <th>Total Amt</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody id="salesLogBody">
                                <!-- data inserted dynamically -->
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Add Item Modal -->
    <div class="modal fade" id="addItemModal" tabindex="-1" aria-labelledby="addItemModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0">
                <div class="modal-header">
                    <h5 class="modal-title" id="addItemModalLabel">Add Item to Transaction Table</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addItemForm">
                        <div class="mb-3">
                            <label for="productSelect" class="form-label">Item Name</label>
                            <select id="productSelect" class="form-select" required>
                                <option value="">-- Select Product --</option>
                                <!-- Dynamically loaded from ProductController.php -->
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="productQty" class="form-label">Quantity</label>
                            <input type="number" id="productQty" class="form-control" min="1" required />
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary" id="confirmAddItem">Confirm</button>
                </div>
            </div>
        </div>
    </div>


    <script src="../assets/jQuery/jquery.js"></script>
    <script src="../assets/jQuery/jquery-ui.js"></script>
    <script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/DataTables/datatables.min.js"></script>

    <script>
        //Button "Print" generates downloadable pdf format of the Sales Log
        document.getElementById('printSalesLog').addEventListener('click', function () {
            const { jsPDF } = window.jspdf;
            var doc = new jsPDF();

            doc.setFontSize(18);
            doc.text("Sales Log Report", 14, 22);

            doc.autoTable({
                startY: 30,
                html: '#salesLogTable',
                styles: { fontSize: 8 },
                headStyles: { fillColor: [0, 64, 173] },
                alternateRowStyles: { fillColor: [240, 240, 240] },
                margin: { left: 14, right: 14 },
            });

            doc.save('SalesLog.pdf');
        });
        
        function updateTime() {
            const now = new Date();
            const date = now.toLocaleDateString();
            const time = now.toLocaleTimeString();
            document.getElementById("currentDate").textContent = `${date} ${time}`;
        }

        updateTime();
        setInterval(updateTime, 1000);

        $(document).ready(function () {
            // Initialize DataTables on POS and Sales Log tables
            var posTable = $('#posTable').DataTable({
                paging: false,
                searching: false,
                info: false,
                columnDefs: [
                    { orderable: false, targets: 5 }, // Remove button
                    { visible: false, targets: 0 }    // Hide Product ID (column 0)
                ]
            });

            var salesLogTable = $('#salesLogTable').DataTable({
                paging: false,
                searching: false,
                info: false,
                order: [[4, 'desc']]
            });

            // Load products into dropdown
            $.getJSON("../controller/ProductController.php?action=getAll", function (data) {
                var select = $('#productSelect');
                select.empty().append('<option value="">-- Select Product --</option>');
                data.forEach(product => {
                    select.append(`<option value="${product.product_id}" data-price="${product.price}">${product.product_name}</option>`);
                });
            });


            $.ajax({
                    url: "../controller/TransactionController.php",
                    method: "GET",
                    data: {
                        action: "checkStock",
                        product_id: productId
                    },
                    dataType: "json",
                    success: function (response) {
                        if (response.success) {
                            var availableStock = parseInt(response.stock_quantity);

                            if (qty > availableStock) {
                                alert('Not enough stock. Available quantity: ' + availableStock);
                                return;
                            }

                            // Proceed to add item to POS table
                            var subtotal = price * qty;

                            var rowIndex = -1;
                            posTable.rows().every(function (rowIdx) {
                                var data = this.data();
                                if (data[0] === productId) {
                                    rowIndex = rowIdx;
                                }
                            });

                            if (rowIndex > -1) {
                                // Update existing row
                                var rowData = posTable.row(rowIndex).data();
                                var newQty = parseInt(rowData[2]) + qty;

                                if (newQty > availableStock) {
                                    alert('Total quantity exceeds available stock. Max: ' + availableStock);
                                    return;
                                }

                                var newSubtotal = price * newQty;
                                posTable.row(rowIndex).data([
                                    productId,
                                    productName,
                                    newQty,
                                    `₱${price.toFixed(2)}`,
                                    `₱${newSubtotal.toFixed(2)}`,
                                    `<button class="btn btn-danger btn-sm remove-item">X</button>`
                                ]).draw(false);
                            } else {
                                // Add new row
                                posTable.row.add([
                                    productId,
                                    productName,
                                    qty,
                                    `₱${price.toFixed(2)}`,
                                    `₱${subtotal.toFixed(2)}`,
                                    `<button class="btn btn-danger btn-sm remove-item">X</button>`
                                ]).draw(false);
                            }

                            updateTotalAmount();
                            $('#addItemModal').modal('hide');
                        } else {
                            alert("Failed to check stock: " + response.message);
                        }
                    },
                    error: function () {
                        alert("Error checking stock.");
                    }
                });
            });

            

            $('#posTable tbody').on('click', '.remove-item', function () {
                posTable.row($(this).parents('tr')).remove().draw();
                updateTotalAmount();
            });

            // Clear transaction
            $('#clearTransaction').click(function () {
                posTable.clear().draw();
                updateTotalAmount();
            });

            // Update total amount field
            function updateTotalAmount() {
                var total = 0;
                posTable.rows().every(function () {
                    var data = this.data();
                    var subtotal = parseFloat(data[4].replace('₱', '')) || 0;
                    total += subtotal;
                });
                $('#totalAmount').val('₱' + total.toFixed(2));
            }

            // Record transaction button 
            $('#recordTransaction').click(function () {
                var transactionItems = [];

                posTable.rows().every(function () {
                    var data = this.data();
                    transactionItems.push({
                        product_id: data[0], //hidden id
                        quantity: parseInt(data[2]), //quantity kay naa na sa index 2 to accomodate hidden id
                        price: parseFloat(data[3].replace('₱', '')),
                        subtotal: parseFloat(data[4].replace('₱', ''))
                    });
                });

                if (transactionItems.length === 0) {
                    alert('No items to record.');
                    return;
                }

                $.ajax({
                    url: "../controller/TransactionController.php?action=create",
                    method: "POST",
                    data: { items: JSON.stringify(transactionItems) },
                    dataType: "json",
                    success: function (response) {
                        if (response.success) {
                            alert("Transaction recorded! ID: " + response.transaction_id);
                            posTable.clear().draw();
                            updateTotalAmount();
                            loadSalesLog();
                        } else {
                            alert("Failed to record transaction: " + response.message);
                        }
                    },
                    error: function () {
                        alert("Error recording transaction.");
                    }
                });
            });

            // Load sales log from backend into DataTable
            function loadSalesLog() {
                $.ajax({
                    url: "../controller/TransactionController.php?action=getSalesLog",
                    method: "GET",
                    dataType: "json",
                    success: function (data) {
                        salesLogTable.clear();
                        data.forEach(log => {
                            salesLogTable.row.add([
                                log.transaction_id,
                                log.product_name,
                                log.quantity,
                                '₱' + parseFloat(log.total).toFixed(2),
                                log.date_created
                            ]);
                        });
                        salesLogTable.draw();
                    },
                    error: function () {
                        alert("Failed to load sales log.");
                    }
                });
            }

            loadSalesLog();
        });
    </script>
</body>
</html>
