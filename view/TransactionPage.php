<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title>SARISMART MANAGEMENT SYSTEM</title>

	<!--JQUERY UI & JS -->
	<link rel="stylesheet" href="../assets/jquery/base/jquery-ui.css" />
	<script src="../assets/jquery/jquery.js"></script>
	<script src="../assets/jquery/jquery-ui.js"></script>

	<!-- Bootstrap 5 -->
	<link href="../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
	<script src="../assets/js/bootstrap.bundle.min.js"></script>

	<link href="../assets/Dashboard.css" rel="stylesheet" />
	<link href="../assets/Transaction.css" rel="stylesheet" />
	
</head>

<body>
	<?php include 'sidebar.php'; ?>

	<div class="Inventory">
		<div class="dashBoard-content py-3">
			<div
				class="header-content d-flex justify-content-between align-items-center rounded p-3"
				style="background-color: transparent;"
			>
				<h1
					class="ms-4 d-flex align-items-center fw-bold"
					style="color: #004aad; font-size: 2rem; font-weight: 600"
				>
					Transactions
				</h1>
				<h2
					id="currentDate"
					class="me-4 text-secondary fst-italic"
					style="font-weight: 400; font-size: 1.25rem"
				></h2>
			</div>
			<hr class="mt-1" style="border-top: 2px solid #004aad" />
		</div>

		<div class="main-content">
			<div class="flex-container collapsed">
				<!-- POS -->
				<div id="posContainer" class="panel-box col-md-7">
					<h2>Point of Sale</h2>
					<button
						class="btn btn-light text-primary mb-3"
						data-bs-toggle="modal"
						data-bs-target="#addItemModal"
					>
						Add Item
					</button>
					<table class="table table-bordered table-light">
						<thead>
							<tr>
								<th>Product</th>
								<th>Qty</th>
								<th>Price</th>
								<th>Subtotal</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
					<div class="d-flex justify-content-between align-items-center mt-auto">
						<div>
							<button class="btn btn-success" id="submitTransaction">
								Add Transaction
							</button>
							<button class="btn btn-danger" id="clearTransaction">
								Clear
							</button>
						</div>
						<div class="fs-4 fw-bold">
							Total: ₱<span id="totalAmount">0.00</span>
						</div>
					</div>
				</div>

				<!-- Toggle Button -->
				<div
					class="d-flex flex-column align-items-center justify-content-center"
					style="width: 60px"
				>
					<button id="toggleView" class="btn btn-outline-primary">→</button>
				</div>

				<!-- Sales Log -->
				<div id="salesLogContainer" class="panel-box col-md-5">
					<h2>Sales Log</h2>
					<table class="table table-striped">
						<thead>
							<tr>
								<th>ID</th>
								<th>Product</th>
								<th>Qty</th>
								<th>Total</th>
								<th>Date</th>
							</tr>
						</thead>
						<tbody id="salesLogBody"></tbody>
					</table>
				</div>
			</div>

			<!-- Add Item Modal -->
			<div class="modal fade" id="addItemModal" tabindex="-1">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">Add Item</h5>
							<button
								type="button"
								class="btn-close"
								data-bs-dismiss="modal"
							></button>
						</div>
						<div class="modal-body">
							<form id="addItemForm">
								<div class="mb-2">
									<label for="productSelect">Product</label>
									<select
										class="form-select"
										id="productSelect"
										required
									></select>
								</div>
								<div class="mb-2">
									<label for="productPrice">Price (₱)</label>
									<input
										type="text"
										class="form-control"
										id="productPrice"
										readonly
									/>
								</div>
								<div class="mb-2">
									<label for="productQty">Quantity</label>
									<input
										type="number"
										class="form-control"
										id="productQty"
										value="1"
										min="1"
										required
									/>
								</div>
								<div class="mb-2">
									<label for="productSubtotal">Subtotal (₱)</label>
									<input
										type="text"
										class="form-control"
										id="productSubtotal"
										readonly
									/>
								</div>
							</form>
						</div>
						<div class="modal-footer">
							<button
								type="button"
								class="btn btn-primary"
								id="confirmAddItem"
							>
								Add to Cart
							</button>
						</div>
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

		let products = [];
		function loadProducts() {
			$.getJSON("../controller/ProductController.php?action=getAll", function (data) {
				products = data;
				$("#productSelect").empty().append('<option value="">-- Select Product --</option>');
				data.forEach((product) => {
					$("#productSelect").append(
						`<option value="${product.product_id}" data-price="${product.price}">${product.product_name}</option>`
					);
				});
			});
		}

		$("#productSelect, #productQty").on("change keyup", function () {
			let price = parseFloat($("#productSelect option:selected").data("price")) || 0;
			let qty = parseInt($("#productQty").val()) || 1;
			$("#productPrice").val(price.toFixed(2));
			$("#productSubtotal").val((price * qty).toFixed(2));
		});

		$("#confirmAddItem").click(function () {
			let productId = $("#productSelect").val();
			let name = $("#productSelect option:selected").text();
			let price = parseFloat($("#productPrice").val());
			let qty = parseInt($("#productQty").val());
			let subtotal = parseFloat($("#productSubtotal").val());

			if (!productId || qty < 1) {
				alert("Please select a valid product and quantity.");
				return;
			}

			addItemToCart({ productId, name, price, qty, subtotal });
			$("#addItemModal").modal("hide");
		});

		let cartItems = [];

		function addItemToCart(item) {
			const existingIndex = cartItems.findIndex((ci) => ci.productId === item.productId);
			if (existingIndex >= 0) {
				// If already in cart, increase quantity and subtotal
				cartItems[existingIndex].qty += item.qty;
				cartItems[existingIndex].subtotal += item.subtotal;
			} else {
				cartItems.push(item);
			}
			renderCart();
		}

		function renderCart() {
			let tbody = $("table tbody").first();
			tbody.empty();

			let total = 0;
			cartItems.forEach((item, idx) => {
				total += item.subtotal;
				tbody.append(
					`<tr>
						<td>${item.name}</td>
						<td>${item.qty}</td>
						<td>₱${item.price.toFixed(2)}</td>
						<td>₱${item.subtotal.toFixed(2)}</td>
						<td><button class="btn btn-danger btn-sm remove-item" data-index="${idx}">X</button></td>
					</tr>`
				);
			});

			$("#totalAmount").text(total.toFixed(2));
		}

		$(document).on("click", ".remove-item", function () {
			const index = $(this).data("index");
			cartItems.splice(index, 1);
			renderCart();
		});

		$("#clearTransaction").click(function () {
			cartItems = [];
			renderCart();
		});

		$("#submitTransaction").click(function () {
    if (cartItems.length === 0) {
        alert("Please add items to the cart before submitting.");
        return;
    }

    $.ajax({
        url: "../controller/TransactionController.php?action=create",
        method: "POST",
        data: {
            items: JSON.stringify(cartItems)
        },
        dataType: "json",
        success: function (response) {
            if (response.success) {
                alert("Transaction submitted! Transaction ID: " + response.transaction_id);
                cartItems = [];
                renderCart();
                loadSalesLog();
            } else {
                alert("Failed to submit transaction: " + response.message);
            }
        },
        error: function () {
            alert("Error submitting transaction.");
        }
    });
});

		

		// Sales Log 
		function loadSalesLog() {
	$.ajax({
		url: "../controller/TransactionController.php?action=getSalesLog",
		method: "GET",
		dataType: "json",
		success: function (data) {
			let tbody = $("#salesLogBody");
			tbody.empty();
			data.forEach((log) => {
				tbody.append(`
					<tr>
						<td>${log.transaction_id}</td>
						<td>${log.product_name}</td>
						<td>${log.quantity}</td>
						<td>₱${parseFloat(log.total).toFixed(2)}</td>
						<td>${log.date_created}</td>
					</tr>
				`);
			});
		},
		error: function () {
			alert("Failed to load sales log.");
		}
	});
}


		$(document).ready(function () {
	loadProducts();
	loadSalesLog(); // load sales log on page load
});
		// Toggle button logic
		const flexContainer = document.querySelector(".flex-container");
		const toggleBtn = document.getElementById("toggleView");

		toggleBtn.addEventListener("click", () => {
			if (flexContainer.classList.contains("collapsed")) {
				// Expand sales log, hide POS
				flexContainer.classList.remove("collapsed");
				flexContainer.classList.add("expanded");
				toggleBtn.textContent = "←";
			} else {
				// Expand POS, hide sales log
				flexContainer.classList.remove("expanded");
				flexContainer.classList.add("collapsed");
				toggleBtn.textContent = "→";
			}
		});
	</script>
</body>
</html>
