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
							<a href="TransactionPage.html" class="menu-btn btn d-block ms-2"><img src="../assets/images/transaction.svg" class="menu-logo me-3">Transactions</a>
						</div>
						<div class="menu-items d-block">
							<a href="SalesReport.html" class="menu-btn btn d-block ms-2"><img src="../assets/images/sales.svg" class="menu-logo me-3">Sales</a>
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
			<div class="container saleRep-content">
				<div class="header-content d-flex justify-content-between">
				  <h1 class="ms-4">Sales Report</h1>
				  <h2 id="currentDate"></h2>
				</div>

				<hr>

				<div class="saleContent">
					<div class="contentOption">
						<div class="pt-4 me-5 d-flex justify-content-end">
							<label for="dropdown" class="fs-5 fw-3 text-white">Pick Date:</label>
							<div class="dropdown ms-3">
								<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-bs-toggle="dropdown" aria-expanded="false">
									Dropdown
								</button>
								<ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
									<li><button class="dropdown-item" type="button">Sample</button></li>
									<li><button class="dropdown-item" type="button">Sample</button></li>
									<li><button class="dropdown-item" type="button">Sample</button></li>
								</ul>
							</div>

						</div>
					</div>

					<div class="contentResult">
						<div class="container p-4">
							<div class="row">
								<div class="col col-7 p-5 ms-5 reportFirst text-center text-white">
									<h3 class="tsaHeader">Total Sales Amount</h3>
									<h4 id="reportTSA">Sample</h4>
								</div>
								<div class="col col-4 ms-5 p-0 reportSecond text-center text-white">
									<div class="numTract">
										<p class="ntHeader">No. of Transactions</p>
										<p class="reportNT">Sample</p>
									</div>
									<div class="topsellProd  text-white">
										<p class="tspHeader">Best-selling Product</p>
										<p class="reportTSP">Sample</p>
									</div>
								</div>
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