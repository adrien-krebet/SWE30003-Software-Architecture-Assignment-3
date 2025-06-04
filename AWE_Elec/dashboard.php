<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit;
}
$user = $_SESSION["user"];
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard - AWE Electronics</title>
  <!-- Bootstrap & FontAwesome -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <!-- Custom Theme CSS -->
  <link rel="stylesheet" href="style.css">
</head>
<body>

  <!-- Brand Header -->
  <div class="brand-header">
    <h1 class="display-5 fw-bold">AWE Electronics</h1>
    <p class="text-muted">Welcome back, <?= htmlspecialchars($user["email"]) ?> 👋</p>
  </div>

  <!-- Dashboard Panel -->
  <div class="dashboard-container">
    <h3><?= $user["accessLevel"] ? "Admin Panel" : "Customer Dashboard" ?></h3>

    <div class="dashboard-links">
      <?php if ($user["accessLevel"]): ?>
        <a href="#"><i class="fa-solid fa-box-open"></i> Add Product</a>
        <a href="#"><i class="fa-solid fa-chart-line"></i> View Statistics</a>
      <?php else: ?>
        <a href="#"><i class="fa-solid fa-store"></i> Browse Catalogue</a>
        <a href="#"><i class="fa-solid fa-shopping-cart"></i> Shopping Cart</a>
      <?php endif; ?>
    </div>

    <div class="logout">
      <a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
    </div>
  </div>

</body>
</html>
