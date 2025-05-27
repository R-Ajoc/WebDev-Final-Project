<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SARISMART Login</title>
    <link href="../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/style.css" rel="stylesheet">
    <link href="../assets/EntryPage.css" rel="stylesheet">
</head>
<body>
    <div class="login-wrapper">
        <h1 class="login-title">SARISMART</h1>
        <p class="login-subtitle">Enter password to proceed</p>

        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger py-1">Invalid password. Please try again.</div>
        <?php endif; ?>

        <form class="login-form" action="../controller/adminsecurityController.php?action=login" method="POST">
            <input type="password" name="password" class="form-control mb-2" placeholder="password" required>
            <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-primary btn-login">Login</button>
            </div>
        </form>
    </div>

    <script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
