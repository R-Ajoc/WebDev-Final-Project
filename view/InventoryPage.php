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
					<button id="openPopup" class="ms-4 mb-3 btn btn-primary fw-bolder" name="addProduct">Add Product</button>
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

				<!-- This Popup form will serves as for adding Items to Inventory -->
				<div id="popupForm" class="popup"> 
						<div class="popup-content">
							<span class="close-btn">&times;</span>
							<h2>Add Item to Inventory</h2>
							<form>
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
								<input class="mt-3 btn btn-success" type="submit" value="Submit">
							</form>
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

		//This portion to display Pop-up Form in Adding Items to Inventory
		document.addEventListener('DOMContentLoaded', () => {
			const openPopupBtn = document.getElementById('openPopup');
			const popupForm = document.getElementById('popupForm');
			const closeBtn = document.querySelector('.close-btn');

			console.log('Script loaded: openPopupBtn =', openPopupBtn, 'popupForm =', popupForm);

			popupForm.style.display = 'none';

			openPopupBtn.addEventListener('click', () => {
				console.log('Add Product button clicked');
				popupForm.style.display = 'flex';
			});

			closeBtn.addEventListener('click', () => {
				console.log('Close button clicked');
				popupForm.style.display = 'none';
			});

			window.addEventListener('click', (event) => {
				if (event.target === popupForm) {
					console.log('Overlay clicked');
					popupForm.style.display = 'none';
				}
			});
		});

	</script>

</html>