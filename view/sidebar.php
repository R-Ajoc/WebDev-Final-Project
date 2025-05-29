<!-- sidebar.php -->
<div class="sidebar">
  <div>
    <div class="brand-box mb-4">
      <div class="logo-circle">
        <img src="../assets/images/logo-placeholder.png" alt="Logo">
      </div>
      <div class="mt-2 fw-bold" style="font-size: 14px;">Store<br>Management<br>System</div>
    </div>

    <nav class="nav flex-column">
      <a href="Dashboard.php" class="nav-link">
        <img src="../assets/images/home.svg" class="icon" alt="Dashboard Icon"> Dashboard
      </a>
      <div class="divider"></div>

      <a href="InventoryPage.php" class="nav-link">
        <img src="../assets/images/inventory.svg" class="icon" alt="Inventory Icon"> Inventory
      </a>
      <div class="divider"></div>

      <a href="TransactionPage.php" class="nav-link">
        <img src="../assets/images/transaction.svg" class="icon" alt="Transactions Icon"> Transactions
      </a>
      <div class="divider"></div>

      <a href="Sales.php" class="nav-link">
        <img src="../assets/images/sales.svg" class="icon" alt="Sales Icon"> Sales
      </a>
      <div class="divider"></div>
    </nav>
  </div>

  <div class="logout">
    <a href="EntryPage.php" class="nav-link">
      <img src="../assets/images/logout.svg" class="icon" alt="Logout Icon"> Log Out
    </a>
  </div>
</div>

<style>
  .sidebar {
    width: 250px;
    background-color: #004aad;
    height: 100vh;
    padding: 20px 10px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    position: fixed; /* Keep it on the left side */
    top: 0;
    left: 0;
    z-index: 1000;
  }

  .brand-box {
    background-color: #ff3131;
    border-radius: 10px;
    padding: 15px;
    color: white;
    text-align: center;
  }

  .brand-box .logo-circle {
    width: 70px;
    height: 70px;
    background-color: white;
    border-radius: 50%;
    margin: 0 auto 10px auto;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
  }

  .logo-circle img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  .nav-link {
    color: white !important;
    padding: 10px 15px;
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .nav-link:hover {
    background-color: rgba(255, 255, 255, 0.1);
    border-radius: 5px;
  }

  .divider {
    border-bottom: 1px solid white;
    margin: 8px 0;
  }

  .logout {
    margin-top: auto;
  }

  .sidebar img.icon {
    width: 20px;
    height: 20px;
  }
</style>
