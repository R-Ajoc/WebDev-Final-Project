<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>SARISMART MANAGEMENT SYSTEM</title>

	<!--JQUERY UI & JS -->
	<link rel="stylesheet" href="../assets/jquery/base/jquery-ui.css">
	<script src="../assets/jquery/jquery.js"></script>
	<script src="../assets/jquery/jquery-ui.js"></script>

	<!-- Bootstrap 5 -->
	<link href="../assets/css/bootstrap.min.css" rel="stylesheet">
	<script src="../assets/js/bootstrap.bundle.min.js"></script>

	<link rel="stylesheet" type="text/css" href="../assets/style.css">

</head>

<body>

	<div class="container-body d-flex">
		<div class="sideBar">
			<div class="sideBar-content">
				<div class="sideBarlogo d-flex">
					<img src="../assets/images/store.svg">
					<div class="logoContent disp-5 text-center text-white">
						<p class="plogo">
							STORE MANAGEMENT SYSTEM
						</p>
					</div>
				</div>

				<div class="sideBar-menu">
					<div class="sideBar-menuContent">
						<div class="menu-items-top d-block">
							<a href="Dashboard.php" class="menu-btn btn d-block ms-2"><img src="../assets/images/home.svg" class="menu-logo me-3">Dashboard</a>
						</div>
						<div class="menu-items d-block">
							<a href="InventoryPage.php" class="menu-btn btn d-block ms-2"><img src="../assets/images/inventory.svg" class="menu-logo me-3">Inventory</a>
						</div>
						<div class="menu-items d-block">
							<a href="TransactionPage.php" class="menu-btn btn d-block ms-2"><img src="../assets/images/transaction.svg" class="menu-logo me-3">Transactions</a>
						</div>
						<div class="menu-items d-block">
							<a href="SalesReport.php" class="menu-btn btn d-block ms-2"><img src="../assets/images/sales.svg" class="menu-logo me-3">Sales</a>
						</div>
					</div>
				</div>
				<div class="sideBar-Exit">
					<div class="menu-items d-block">
						<a href="EntryPage.html" class="menu-btn btn d-block ms-2"><img src="../assets/images/logout.svg" class="menu-logo me-3">Logout</a>
					</div>
				</div>
			</div>	
		</div>

		<div class="dashBoard">
			<div class="container dashBoard-content">
				<div class="header-content d-flex justify-content-between">
				  <h1 class="ms-4">Transaction</h1>
				  <h2 id="currentDate"></h2>
				</div>
				<hr>

				<div class="container">
					<div class="row">
						<div class="col-7 rounded p-3 transaction-POS text-white">
							<div class="d-flex justify-content-between">
								<h3>POS</h3>
								<button type="button" class="ms-4 mb-3 btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
									Add Product
								</button>
							</div>						
							<!-- This Modal Popup form will serves as for adding Items to Transaction Table -->
							<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
								<div class="modal-dialog modal-dialog-centered">
									<div class="modal-content">
										<form action=""method="POST">
											<div class="modal-header">
												<h5 class="modal-title" id="staticBackdropLabel">Add Item to Transaction Table</h5>
												<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
											</div>
											<div class="modal-body">
												<div class="input-group mb-3">
													<span class="input-group-text" id="pName">Product Name</span>
													<input type="text" class="form-control" name="prodName" aria-label="prodName" aria-describedby="pName">
												</div>
												<div class="input-group mb-3">
													<label class="input-group-text" for="categoryProd">Category</label>
													<select class="form-select" id="categoryProd">
														<option selected>Choose...</option>
														<option value="1">One</option> <!-- implement here for reloading choices for Category -->
														<option value="2">Two</option>
														<option value="3">Three</option>
													</select>
												</div>
												<div class="input-group mb-3">
													<span class="input-group-text" id="price">Price</span>
													<input type="text" class="form-control" name="prodPrice" aria-label="prodPrice" aria-describedby="price" disabled>
												</div>
												<div class="input-group mb-3">
													<span class="input-group-text" id="price">Quantity</span>
													<input type="text" class="form-control" name="pQuantity" aria-label="pQuantity" aria-describedby="quantity">
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
							
							<div class="table-responsive">
								<table class="table table-bordered transactTable text-center">
								<thead>
									<tr>
										<th>Product Name</th>
										<th>Qty</th>
										<th>Price</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>123</td>
										<td>Melona</td>
										<td>50</td>
									</tr>
									<tr>
										<td>123</td>
										<td>Melona</td>
										<td>50</td>
									</tr>
									<tr>
										<td>123</td>
										<td>Melona</td>
										<td>50</td>
									</tr>
									<tr>
										<td>123</td>
										<td>Melona</td>
										<td>50</td>
									</tr>
									<tr>
										<td>123</td>
										<td>Melona</td>
										<td>50</td>
									</tr>
									<tr>
										<td>123</td>
										<td>Melona</td>
										<td>50</td>
									</tr>
									<tr>
										<td>123</td>
										<td>Melona</td>
										<td>50</td>
									</tr>
									<tr>
										<td>123</td>
										<td>Melona</td>
										<td>50</td>
									</tr>
									<tr>
										<td>123</td>
										<td>Melona</td>
										<td>50</td>
									</tr>
									<tr>
										<td>123</td>
										<td>Melona</td>
										<td>50</td>
									</tr>
									<tr>
										<td>123</td>
										<td>Melona</td>
										<td>50</td>
									</tr>
									<tr>
										<td>123</td>
										<td>Melona</td>
										<td>50</td>
									</tr>
									<tr>
										<td>123</td>
										<td>Melona</td>
										<td>50</td>
									</tr>
									<tr>
										<td>123</td>
										<td>Melona</td>
										<td>50</td>
									</tr>
									<tr>
										<td>123</td>
										<td>Melona</td>
										<td>50</td>
									</tr>
									<tr>
										<td>123</td>
										<td>Melona</td>
										<td>50</td>
									</tr>
									<tr>
										<td>123</td>
										<td>Melona</td>
										<td>50</td>
									</tr>
									<tr>
										<td>123</td>
										<td>Melona</td>
										<td>50</td>
									</tr>
									<tr>
										<td>123</td>
										<td>Melona</td>
										<td>50</td>
									</tr>
									<tr>
										<td>123</td>
										<td>Melona</td>
										<td>50</td>
									</tr>
									<tr>
										<td>123</td>
										<td>Melona</td>
										<td>50</td>
									</tr>
									<tr>
										<td>123</td>
										<td>Melona</td>
										<td>50</td>
									</tr>
									<tr>
										<td>123</td>
										<td>Melona</td>
										<td>50</td>
									</tr>
									<tr>
										<td>123</td>
										<td>Melona</td>
										<td>50</td>
									</tr>
									<tr>
										<td>123</td>
										<td>Melona</td>
										<td>50</td>
									</tr>
									<tr>
										<td>123</td>
										<td>Melona</td>
										<td>50</td>
									</tr>
									<tr>
										<td>123</td>
										<td>Melona</td>
										<td>50</td>
									</tr>
									<tr>
										<td>123</td>
										<td>Melona</td>
										<td>50</td>
									</tr>
									<tr>
										<td>123</td>
										<td>Melona</td>
										<td>50</td>
									</tr>
									<tr>
										<td>123</td>
										<td>Melona</td>
										<td>50</td>
									</tr>
									<tr>
										<td>123</td>
										<td>Melona</td>
										<td>50</td>
									</tr>
									<tr>
										<td>123</td>
										<td>Melona</td>
										<td>50</td>
									</tr>
									<tr>
										<td>123</td>
										<td>Melona</td>
										<td>50</td>
									</tr>
									<tr>
										<td>123</td>
										<td>Melona</td>
										<td>50</td>
									</tr>
									<tr>
										<td>123</td>
										<td>Melona</td>
										<td>50</td>
									</tr>
									<tr>
										<td>123</td>
										<td>Melona</td>
										<td>50</td>
									</tr>
									<tr>
										<td>123</td>
										<td>Melona</td>
										<td>50</td>
									</tr>
									<tr>
										<td>123</td>
										<td>Melona</td>
										<td>50</td>
									</tr>
									<tr>
										<td>123</td>
										<td>Melona</td>
										<td>50</td>
									</tr>
									<tr>
										<td>123</td>
										<td>Melona</td>
										<td>50</td>
									</tr>
									<tr>
										<td>123</td>
										<td>Melona</td>
										<td>50</td>
									</tr>
									<tr>
										<td>123</td>
										<td>Melona</td>
										<td>50</td>
									</tr>
									<tr>
										<td>123</td>
										<td>Melona</td>
										<td>50</td>
									</tr>
									<tr>
										<td>123</td>
										<td>Melona</td>
										<td>50</td>
									</tr>
									<tr>
										<td>123</td>
										<td>Melona</td>
										<td>50</td>
									</tr>
									<tr>
										<td>123</td>
										<td>Melona</td>
										<td>50</td>
									</tr>
									<tr>
										<td>123</td>
										<td>Melona</td>
										<td>50</td>
									</tr>
									<tr>
										<td>123</td>
										<td>Melona</td>
										<td>50</td>
									</tr>
								</tbody>
							</table>
							</div>
							
							<div class="transactOutput mt-2">
								<div class="calcOut d-flex p-2">
									<div class="totalAmt">
										<h5>Total Amount</h5>
										<div class="resultTotal p-2 mt-2">
											<h2 id="totalAmountResult">Sample Result</h2> <!-- Every after adding item, SQL Procedure result will dislay here -->
										</div>
									</div>
									<div class="actionTransact">
										<button class="buttonTransact fw-bolder btn mt-2 btn-success">Record Transaction</button>
										<button class="buttonTransact fw-bolder btn mt-2 btn-danger">Clear Transaction</button>
									</div>
								</div>
							</div>
						</div>
						<div class="col rounded ms-2 p-3 transaction-Sales text-white">
							<h3>Total Monthly Sales</h3>
							<div class="table-responsive salesTB">
								<table class="table table-bordered mt-2 salesTable text-center">
									<thead>
										<tr>
											<th>ID</th>
											<th>Product Name</th>
											<th>Qty</th>
											<th>Total Amt</th>
											<th>Date</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>123</td>
											<td>Melona</td>
											<td>25</td>
											<td>54</td>
											<td>5/27/2025</td>
										</tr>
										<tr>
											<td>123</td>
											<td>Melona</td>
											<td>25</td>
											<td>54</td>
											<td>5/27/2025</td>
										</tr>
										<tr>
											<td>123</td>
											<td>Melona</td>
											<td>25</td>
											<td>54</td>
											<td>5/27/2025</td>
										</tr>
										<tr>
											<td>123</td>
											<td>Melona</td>
											<td>25</td>
											<td>54</td>
											<td>5/27/2025</td>
										</tr>
										<tr>
											<td>123</td>
											<td>Melona</td>
											<td>25</td>
											<td>54</td>
											<td>5/27/2025</td>
										</tr>
										<tr>
											<td>123</td>
											<td>Melona</td>
											<td>25</td>
											<td>54</td>
											<td>5/27/2025</td>
										</tr>
										<tr>
											<td>123</td>
											<td>Melona</td>
											<td>25</td>
											<td>54</td>
											<td>5/27/2025</td>
										</tr>
										<tr>
											<td>123</td>
											<td>Melona</td>
											<td>25</td>
											<td>54</td>
											<td>5/27/2025</td>
										</tr>
										<tr>
											<td>123</td>
											<td>Melona</td>
											<td>25</td>
											<td>54</td>
											<td>5/27/2025</td>
										</tr>
										<tr>
											<td>123</td>
											<td>Melona</td>
											<td>25</td>
											<td>54</td>
											<td>5/27/2025</td>
										</tr>
										<tr>
											<td>123</td>
											<td>Melona</td>
											<td>25</td>
											<td>54</td>
											<td>5/27/2025</td>
										</tr>
										<tr>
											<td>123</td>
											<td>Melona</td>
											<td>25</td>
											<td>54</td>
											<td>5/27/2025</td>
										</tr>
										<tr>
											<td>123</td>
											<td>Melona</td>
											<td>25</td>
											<td>54</td>
											<td>5/27/2025</td>
										</tr>
										<tr>
											<td>123</td>
											<td>Melona</td>
											<td>25</td>
											<td>54</td>
											<td>5/27/2025</td>
										</tr>
										<tr>
											<td>123</td>
											<td>Melona</td>
											<td>25</td>
											<td>54</td>
											<td>5/27/2025</td>
										</tr>
										<tr>
											<td>123</td>
											<td>Melona</td>
											<td>25</td>
											<td>54</td>
											<td>5/27/2025</td>
										</tr>
										<tr>
											<td>123</td>
											<td>Melona</td>
											<td>25</td>
											<td>54</td>
											<td>5/27/2025</td>
										</tr>
										<tr>
											<td>123</td>
											<td>Melona</td>
											<td>25</td>
											<td>54</td>
											<td>5/27/2025</td>
										</tr>
										<tr>
											<td>123</td>
											<td>Melona</td>
											<td>25</td>
											<td>54</td>
											<td>5/27/2025</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>

<!-- DataTables JS -->
	<script src="../assets/datatable/datatables.min.js"></script>
	<script src="../assets/datatable/datatables.js"></script>
	<script>

		//This part is for the Current Date Display
		const currentDate = new Date();
		const year = currentDate.getFullYear();
  		const month = String(currentDate.getMonth() + 1).padStart(2, '0'); // Month is 0-indexed
  		const day = String(currentDate.getDate()).padStart(2, '0');
  		const formattedDate = `${year}-${month}-${day}`; //YYYY-MM-DD format
  		document.getElementById("currentDate").textContent = "Date: "+ formattedDate;

	</script>

</html>
