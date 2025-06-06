<?php
session_start();

// Sample news items (can be dynamic later)
$news = [
    "🎉 Mega Sale: 25% off on all laptops this week!",
    "🆕 New arrivals in our Gaming section!",
    "🚚 Free shipping for orders over $100!"
];

$loggedIn = isset($_SESSION["user"]);
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
  <meta charset="UTF-8">
  <title>Home - AWE Electronics</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="styles.css">
</head>
<body>

  <div class="container mt-5 mb-5">
    <!-- Branding -->
    <div class="text-center mb-4 brand-heading">
      <h1 class="display-5 fw-bold">Welcome to AWE Electronics</h1>
      <p class="text-muted">Powering your tech dreams ⚡</p>
    </div>

    <!-- Info About AWE -->
    <div class="info-box text-center mb-5">
      <h2>Discover AWE Electronics</h2>
      <p>
        At AWE Electronics, we offer premium tech gear for enthusiasts, professionals, and anyone who loves getting hands-on. 
        Explore a wide range of electronics, gadgets, and components at unbeatable prices.
      </p>
      <p>⚡ Trusted Brands • Fast Shipping • Reliable Support ⚡</p>
    </div>

    <!-- News Section -->
    <div class="news-box">
      <h4 class="text-info mb-3">📰 Latest News & Promotions</h4>
      <ul class="list-group list-group-flush">
        <?php foreach ($news as $item): ?>
          <li class="list-group-item bg-transparent text-light"><?= $item ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>

  <!-- Bottom Navigation -->
  <nav class="bottom-nav navbar navbar-expand navbar-dark">
    <div class="container justify-content-around">
      <a class="nav-link" href="index.php">Home</a>
      <a class="nav-link" href="shop.php">Catalogue</a>

      <?php if ($loggedIn): ?>
        <a class="nav-link" href="profile.php">My Profile</a>
        <a class="nav-link" href="logout.php">Logout</a>
      <?php else: ?>
        <a class="nav-link" href="login.php">Login</a>
        <a class="nav-link" href="signup.php">Sign Up</a>
      <?php endif; ?>
    </div>
  </nav>

</body>
</html>
