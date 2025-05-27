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

	<!-- DataTables CSS -->
	<link rel="stylesheet" href="../assets/datatable/datatables.css">


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
							<a href="Dashboard.html" class="menu-btn btn d-block ms-2"><img src="../assets/images/home.svg" class="menu-logo me-3">Dashboard</a>
						</div>
						<div class="menu-items d-block">
							<a href="InventoryPage.html" class="menu-btn btn d-block ms-2"><img src="../assets/images/inventory.svg" class="menu-logo me-3">Inventory</a>
						</div>
						<div class="menu-items d-block">
							<a href="create.php" class="menu-btn btn d-block ms-2"><img src="../assets/images/transaction.svg" class="menu-logo me-3">Transactions</a>
						</div>
						<div class="menu-items d-block">
							<a href="create.php" class="menu-btn btn d-block ms-2"><img src="../assets/images/sales.svg" class="menu-logo me-3">Sales</a>
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

		<div class="Inventory">
			<div class="container dashBoard-content">
				<div class="header-content d-flex justify-content-between">
				  <h1 class="ms-4">Inventory</h1>
				  <h2 id="currentDate"></h2>
				</div>
				<hr>

				<div class="container">
					<button type="button" class="ms-4 mb-3 btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
						Add Product
					</button>
					<div class="col rounded ms-3 p-3 inventory-Item text-white">
						<div class="lowerDiv">Product List Table</div>
						<table id="productTable" class="display table-bordered">
							<thead>
								<tr>
									<th>Product ID</th>
									<th>Product Name</th>
									<th>Price</th>
									<th>Quantity in Stock</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>123</td>
									<td>Melona</td>
									<td>50</td>
									<td>61</td>
									<td>
										<div class="actionButton d-flex justify-content-evenly">
											<button onclick="confirm()" class="button btn btn-success">Edit Item</button>
											<button class="button btn btn-danger">Delete Item</button>
										</div>
									</td>
								</tr>
							</tbody>
							<tfoot>
								<tr>
									<th>Product ID</th>
									<th>Product Name</th>
									<th>Price</th>
									<th>Quantity in Stock</th>
									<th>Action</th>
								</tr>
							</tfoot>
						</table>
					</div>
				</div>
				
				<!-- This Modal Popup form will serves as for adding Items to Inventory -->
				<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
					<div class="modal-dialog modal-dialog-centered">
						<div class="modal-content">
							<form action=""method="POST">
								<div class="modal-header">
									<h5 class="modal-title" id="staticBackdropLabel">Add Item to Inventory</h5>
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
										<input type="text" class="form-control" name="prodPrice" aria-label="prodPrice" aria-describedby="price">
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
			</div>
		</div>
	</div>
</body>

	<!-- DataTables JS -->
	<script src="../assets/datatable/datatables.min.js"></script>
	<script src="../assets/datatable/datatables.js"></script>
	<script>
		new DataTable('#productTable', {
			paging: false,
			scrollCollapse: true,
			scrollY: '200px'
		});

		//This part is for the Current Date Display
		const currentDate = new Date();
		const year = currentDate.getFullYear();
  		const month = String(currentDate.getMonth() + 1).padStart(2, '0'); // Month is 0-indexed
  		const day = String(currentDate.getDate()).padStart(2, '0');
  		const formattedDate = `${year}-${month}-${day}`; //YYYY-MM-DD format
  		document.getElementById("currentDate").textContent = "Date: "+ formattedDate;

	</script>

</html>
