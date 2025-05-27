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

		<div class="dashBoard">
			<div class="container dashBoard-content">
				<div class="header-content d-flex justify-content-between">
				  <h1 class="ms-4">Dashboard</h1>
				  <h2 id="currentDate"></h2>
				</div>
				<hr>
				<div class="stockAlert rounded ms-3 mb-5">
					<div class="alert p-4 text-white">Welcome</div>
				</div>

				<div class="container">
					<div class="row g-4">
						<div class="col rounded p-5 ms-3 dashboard-item numProd text-white text-center">
								<h1>Total No. of Products</h1>
						</div>
						<div class="col rounded p-5 ms-3 dashboard-item saleMonth text-white text-center">
								<h1>Total Monthly Sales</h1>
							
						</div>
						<div class="col rounded p-5 ms-3 dashboard-item topsellProd text-white text-center">
								<h1>Top-selling Products</h1>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>

<script>
	const currentDate = new Date();
		const year = currentDate.getFullYear();
  		const month = String(currentDate.getMonth() + 1).padStart(2, '0'); // Month is 0-indexed
  		const day = String(currentDate.getDate()).padStart(2, '0');
  		const formattedDate = `${year}-${month}-${day}`; //YYYY-MM-DD format
  		document.getElementById("currentDate").textContent = "Date: "+ formattedDate;

</script>

</html>
